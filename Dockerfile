FROM debian

RUN apt-get update -y && apt-get install -y nginx php php-cli php-fpm

COPY src /var/www/html
COPY keyn.conf /etc/nginx/sites-available/default

EXPOSE 80/tcp

CMD service php7.4-fpm start && service nginx start && tail -f /dev/null