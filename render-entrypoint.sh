#!/bin/bash
set -euo pipefail

WP=/var/www/html

# ── 1. Copy WordPress core files (synchronous — no race condition) ────────────
if [ ! -f "$WP/wp-load.php" ]; then
    echo "Copying WordPress to $WP..."
    cp -a /usr/src/wordpress/. "$WP/"
    chown -R www-data:www-data "$WP"
fi

# ── 2. Set up SQLite drop-in ──────────────────────────────────────────────────
mkdir -p "$WP/wp-content/database"
if [ ! -f "$WP/wp-content/db.php" ]; then
    cp "$WP/wp-content/plugins/sqlite-database-integration/db.copy" \
       "$WP/wp-content/db.php"
fi
chown -R www-data:www-data "$WP/wp-content"

# ── 3. Create wp-config.php ───────────────────────────────────────────────────
if [ ! -f "$WP/wp-config.php" ]; then
    wp config create \
        --allow-root --path="$WP" \
        --dbname=wordpress \
        --dbuser=wp \
        --dbpass=wp \
        --dbhost=localhost \
        --skip-check
fi

# ── 4. Install WordPress (first boot only) ────────────────────────────────────
if ! wp core is-installed --allow-root --path="$WP" 2>/dev/null; then
    SITE_URL="${RENDER_EXTERNAL_URL:-http://localhost}"

    wp core install \
        --allow-root --path="$WP" \
        --url="$SITE_URL" \
        --title="AshFXPro" \
        --admin_user=admin \
        --admin_password="${WP_ADMIN_PASSWORD:-Admin2024!}" \
        --admin_email="admin@ashfxpro.com" \
        --skip-email

    wp theme activate ashfxpro --allow-root --path="$WP"
    wp rewrite structure '/%postname%/' --allow-root --path="$WP"
    wp rewrite flush --hard --allow-root --path="$WP"

    FRONT_ID=$(wp post create \
        --allow-root --path="$WP" \
        --post_type=page \
        --post_title='Home' \
        --post_status=publish \
        --post_name=home \
        --porcelain)

    wp option update show_on_front  page        --allow-root --path="$WP"
    wp option update page_on_front  "$FRONT_ID" --allow-root --path="$WP"

    echo "WordPress installed at $SITE_URL"
fi

# ── 5. Start Apache ───────────────────────────────────────────────────────────
exec apache2-foreground
