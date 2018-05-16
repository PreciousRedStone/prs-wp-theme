FROM wordpress:php7.1

COPY apache2-custom.sh /usr/local/bin/
COPY package.json package-lock.json gulpfile.js /tmp/

RUN apt-get update
RUN apt-get install -y curl sudo

RUN curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash - && \
    sudo apt-get install -y nodejs && \
    sudo ln -s /usr/local/bin/nodejs /usr/local/bin/node

WORKDIR /var/www/html

CMD ["apache2-custom.sh"]
