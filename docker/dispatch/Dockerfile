FROM php:7.2-cli

# because docker caches each new line of command, we should add new packages one per new line to avoid long image rebuilds

RUN apt-get update \
    && apt-get -y install \
            # Required by composer
            git \
            zlib1g-dev \
        --no-install-recommends

RUN docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-install -j$(nproc) bcmath

# Cleanup to keep the images size small
RUN apt-get purge -y \
        zlib1g-dev \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/*

# Install composer
COPY install-composer.sh /install-composer.sh
RUN chmod +x /install-composer.sh
RUN /install-composer.sh && rm /install-composer.sh

WORKDIR /usr/src/