FROM nginx:stable-alpine

RUN mkdir -p /var/www/wp-web-crawler

# Set working directory
WORKDIR /var/www/wp-web-crawler

ADD docker-files/nginx/conf.d/app.conf /etc/nginx/conf.d/app.conf

ENV NGINXUSER=wp
ENV NGINXGROUP=wp

RUN sed -i "s/user www-data/user ${NGINXUSER}/g" /etc/nginx/nginx.conf

RUN adduser -g ${NGINXGROUP} -s /bin/sh -D ${NGINXUSER}