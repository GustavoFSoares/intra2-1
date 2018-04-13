FROM nginx:latest
LABEL Author="Gustavo Soares" 
COPY /client-teste/public /var/www/public
COPY /docker/config/nginx.conf /etc/nginx/nginx.conf
RUN chmod 755 -R /var/www/public
EXPOSE 80
ENTRYPOINT [ "nginx" ]

CMD [ "-g", "daemon off;" ]