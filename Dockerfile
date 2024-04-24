FROM php:8.2-cli
RUN apt-get update && apt-get install -y \
        zlib1g-dev \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd

WORKDIR /usr/src/app/
CMD ["php", "index.php"]
