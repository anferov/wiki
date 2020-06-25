FROM alpine:3.9

ARG USER_ID=1000
ENV USER_ID "$USER_ID"
ENV TERM xterm

RUN set -x \
  && apk add --no-cache \
    bash \
    curl \
    vim \
    nano \
    iputils tzdata \
    nginx

COPY sites-enabled/          /etc/nginx/sites-enabled/
COPY nginx.conf              /etc/nginx/
#COPY fastcgi_params          /etc/nginx/
#COPY .bashrc                 /srv/www/.bashrc
#COPY dev/                    /root/dev/
#COPY .bashrc                 /root/.bashrc

RUN mkdir -p /var/cache/nginx/ && rm -rf /etc/nginx/conf.d/default.conf

EXPOSE 80

STOPSIGNAL SIGTERM

SHELL ["/bin/bash", "-c"]

CMD ["nginx", "-g", "daemon off;"]