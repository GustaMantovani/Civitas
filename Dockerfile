FROM ubuntu:23.10

ARG timezone 
ENV TIMEZONE=${timezone:-"America/Sao_Paulo"} 

RUN apt update && apt install -y supervisor apache2 htop nano net-tools php libapache2-mod-php php-mysql

COPY config/dir.conf /etc/apache2/mods-enabled/dir.conf 
COPY config/php.ini /etc/php/8.2/apache2/php.ini

RUN mkdir -p /var/log/supervisor
COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["supervisord", "-n"]