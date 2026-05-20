#!/bin/bash
set -euo pipefail

WP=/var/www/html

# ── Phase 1: copy WP files + create wp-config.php ──────────────────────────
# The original docker-entrypoint.sh does this, then exec's apache2-foreground.
# We run it in the background so we can run WP-CLI setup afterwards.
docker-entrypoint.sh apache2-foreground &
APACHE_PID=$!

# Wait for WordPress core files to be present
until [ -f "$WP/wp-load.php" ]; do sleep 1; done

# Ensure SQLite drop-in is in the live docroot
if [ ! -f "$WP/wp-content/db.php" ]; then
    cp "$WP/wp-content/plugins/sqlite-database-integration/db.copy" \
       "$WP/wp-content/db.php"
fi
mkdir -p "$WP/wp-content/database"
chown -R www-data:www-data "$WP/wp-content"

# ── Phase 2: install WordPress (only on first boot) ─────────────────────────
if ! wp core is-installed --allow-root --path="$WP" 2>/dev/null; then

    SITE_URL="${RENDER_EXTERNAL_URL:-http://localhost}"

    wp core install \
        --allow-root \
        --path="$WP" \
        --url="$SITE_URL" \
        --title="AshFXPro" \
        --admin_user=admin \
        --admin_password="${WP_ADMIN_PASSWORD:-Admin2024!}" \
        --admin_email="admin@ashfxpro.com" \
        --skip-email

    wp theme activate ashfxpro --allow-root --path="$WP"
    wp rewrite structure '/%postname%/' --allow-root --path="$WP"
    wp rewrite flush --allow-root --path="$WP"

    # Create static front page
    FRONT_ID=$(wp post create \
        --allow-root --path="$WP" \
        --post_type=page \
        --post_title='Home' \
        --post_status=publish \
        --post_name=home \
        --porcelain)

    wp option update show_on_front  page     --allow-root --path="$WP"
    wp option update page_on_front  "$FRONT_ID" --allow-root --path="$WP"

    echo "✓ WordPress installed at $SITE_URL"
fi

# ── Phase 3: keep Apache running ────────────────────────────────────────────
wait "$APACHE_PID"
