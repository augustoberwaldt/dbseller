FROM php:5-fpm

RUN apt-get update \
  && apt-get install -y imagemagick libmagickwand-dev libmagickcore-dev \
  && apt-get install -y libmcrypt-dev libcurl4-gnutls-dev libicu-dev libxslt-dev libssl-dev

RUN docker-php-ext-install -j$(nproc) exif iconv mcrypt mysqli pdo_mysql zip curl bcmath opcache \
  && docker-php-ext-install -j$(nproc) json intl session xmlrpc xsl \
  && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
  && docker-php-ext-install -j$(nproc) gd

RUN pecl install redis \
  && pecl install mongodb \
  && pecl install mongo \
  && pecl install imagick \
  && docker-php-ext-enable redis mongo mongodb imagick

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/UTC /etc/localtime
RUN "date"