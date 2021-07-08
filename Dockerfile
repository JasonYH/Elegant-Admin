FROM php:7.4.21-alpine3.13

LABEL maintainer="JasonYu <coderyu2018@gmail.com>"

# Start as root
USER root

###########################################################################
# Set Timezone
###########################################################################
ARG TZ=PRC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

###########################################################################
# If you're in China, or you need to change sources, will be set CHANGE_SOURCE to true in .env.
###########################################################################
ARG XEDEBUG_INSTALL=true  
ARG CHANGE_SOURCE=false
RUN apk --update add --no-cache \
   && apk add --no-cache libzip-dev libpng-dev php-gd git  $PHPIZE_DEPS \
   && docker-php-ext-install bcmath gd \
   && php -r "copy('https://install.phpcomposer.com/installer', 'composer-setup.php');" \
   && php composer-setup.php \
   ; if [ ${XEDEBUG_INSTALL} = "true" ];then \
   pecl install xdebug  \
   && echo 'zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20190902/xdebug.so'>/usr/local/etc/php/conf.d/xdebug.ini \
   && echo 'xdebug.mode=coverage'>>/usr/local/etc/php/conf.d/xdebug.ini ;\
  fi \
  && pecl install redis && echo 'extension=redis.so'>/usr/local/etc/php/conf.d/redis.ini \
  && apk del gcc libc-dev libgcc make autoconf file g++ gcc libc-dev make pkgconf re2c  $PHPIZE_DEPS libpng-dev \
  && rm -rf /var/cache/apk/* && rm -rf /tmp/*
# Set default work directory
WORKDIR /var/www

#################
#libzip-dev 包解决 No package 'libzip' found
################

