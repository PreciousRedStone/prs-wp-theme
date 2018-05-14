FROM wordpress:php7.1

COPY apache2-custom.sh /usr/local/bin/

WORKDIR /var/www/html
RUN npm install
RUN node_modules/.bin/gulp build

CMD ["apache2-custom.sh"]
