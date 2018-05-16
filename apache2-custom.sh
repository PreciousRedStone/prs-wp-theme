#!/usr/bin/env bash

echo "- Setting WP installation path...";
WP_PATH=/var/www/html
WP_THEMES_PATH=$WP_PATH/wp-content/themes

if which wp > /dev/null; then
    echo "- WP CLI is already installed";
else
    echo "- Copy WP CLI...";
    curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
    chmod +x wp-cli.phar
    mv -f wp-cli.phar /usr/local/bin/wp
fi

echo "- Confirm WP CLI install...";
wp --info

echo "- Copy build files...";
cp -f /tmp/package.json /tmp/package-lock.json /tmp/gulpfile.js /var/www/html/

echo "- Install nodejs modules...";
npm install

# Production only stuff
if [ "$WP_ENV" == "production" ]; then

    echo "- Running in production...";

    echo "- Build theme...";
    node_modules/.bin/gulp build

    echo "- Build theme and copy to destination";
    cp -R prs-wp-theme-dist/* $WP_THEMES_PATH/prs-wp-theme

    echo "- Activating 'prs-wp-theme'...";
    wp theme activate prs-wp-theme --allow-root

    echo "- Fixing permissions for theme directory";
    chown -R www-data:www-data $WP_PATH
    find $WP_PATH -type f -exec chmod 644 {} +
    find $WP_PATH -type d -exec chmod 755 {} +
else
    # Add dev user
    wp user create dev dev@preciousredstone.com --role=administrator --user_pass=password --allow-root
fi

echo "- Starting apache";
exec "apache2-foreground"