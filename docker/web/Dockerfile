FROM ubuntu:latest

RUN apt update && apt install -y supervisor apache2 htop nano net-tools 

COPY dir.conf /etc/apache2/mods-enabled/dir.conf 

RUN mkdir -p /var/log/supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["supervisord", "-n"]

#Devido à necessidade de terminal interativo não é possível instalar o php no container a partir do indicador RUN do Dockerfile, portanto, execute o seguinte comando após os containers estarem online: docker exec -it civitas_web bash -c "apt install -y php libapache2-mod-php php-mysql && exit" && docker restart civitas_web
