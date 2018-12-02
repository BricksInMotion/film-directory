FROM alpine:3.8

# Install the AMP stack
RUN apk update && \
    apk upgrade && \
    apk add bash bash-completion apache2 php7-common mariadb

# Copy the server config
COPY ./.htaccess /var/www/html

COPY ./start-amp.sh /start-amp.sh
RUN chmod +x /start-amp.sh
ENTRYPOINT ["sh", "/start-amp.sh" ]
