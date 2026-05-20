FROM wordpress:6.5-php8.2-apache

# SQLite extension + unzip + WP-CLI
RUN apt-get update -qq \
    && apt-get install -y --no-install-recommends \
       sqlite3 libsqlite3-dev unzip \
    && docker-php-ext-install pdo_sqlite \
    && rm -rf /var/lib/apt/lists/* \
    && curl -fsSL https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
       -o /usr/local/bin/wp \
    && chmod +x /usr/local/bin/wp

# Download SQLite integration plugin into WP source dir
# (the original entrypoint copies /usr/src/wordpress → /var/www/html on first boot)
RUN curl -fsSL \
    "https://downloads.wordpress.org/plugin/sqlite-database-integration.latest-stable.zip" \
    -o /tmp/sqlite.zip \
    && unzip -q /tmp/sqlite.zip -d /usr/src/wordpress/wp-content/plugins/ \
    && rm /tmp/sqlite.zip \
    && cp /usr/src/wordpress/wp-content/plugins/sqlite-database-integration/db.copy \
          /usr/src/wordpress/wp-content/db.php \
    && mkdir -p /usr/src/wordpress/wp-content/database

# Copy our custom theme
COPY wp-content/themes/ashfxpro /usr/src/wordpress/wp-content/themes/ashfxpro

# Startup wrapper
COPY render-entrypoint.sh /render-entrypoint.sh
RUN chmod +x /render-entrypoint.sh

# Dummy DB env vars — replaced by SQLite's db.php drop-in at runtime
ENV WORDPRESS_DB_HOST=localhost \
    WORDPRESS_DB_USER=wp \
    WORDPRESS_DB_PASSWORD=wp \
    WORDPRESS_DB_NAME=wordpress

EXPOSE 80
ENTRYPOINT ["/render-entrypoint.sh"]
CMD ["apache2-foreground"]
