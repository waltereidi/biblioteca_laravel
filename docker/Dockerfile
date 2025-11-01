FROM php:8.2-fpm

# Instala dependências de sistema essenciais
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    curl \
    imagemagick \
    ghostscript \
    libmagickwand-dev --no-install-recommends \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instala e habilita o Imagick
RUN pecl install imagick \
    && docker-php-ext-enable imagick

# Instala Node.js (versão LTS 20.x)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y nodejs \
    && npm install -g npm@latest \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instala e configura o Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=debug,develop" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log=/tmp/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Instala o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www/html/biblioteca

# Ajusta permissões
RUN chown -R www-data:www-data /var/www/html/biblioteca

# Copia e torna executável o script de inicialização
COPY docker-script.sh /usr/local/bin/docker-script.sh
RUN chmod +x /usr/local/bin/docker-script.sh

# Copia php-config customizado
COPY ./php/php-config.ini /usr/local/etc/php/conf.d/php-config.ini

# Testa Ghostscript e Imagick (sem quebrar o build)
RUN if command -v gs >/dev/null 2>&1; then gs --version; else echo "⚠️ Ghostscript não encontrado"; fi \
    && php -r "echo 'Imagick version: ' . (new Imagick())->getVersion()['versionString'] . PHP_EOL;"

ENTRYPOINT ["/usr/local/bin/docker-script.sh"]
CMD ["php-fpm"]
