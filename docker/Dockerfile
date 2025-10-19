FROM php:8.2-fpm

# Instala dependências do sistema e extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    curl \
    && docker-php-ext-install pdo pdo_pgsql

# Instala Node.js e npm (versão LTS atual)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Instala o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www/html/biblioteca

# Ajusta permissões
RUN chown -R www-data:www-data /var/www/html/biblioteca

# Copia e torna executável o script de inicialização
COPY docker-script.sh /usr/local/bin/docker-script.sh
RUN chmod +x /usr/local/bin/docker-script.sh

ENTRYPOINT ["/usr/local/bin/docker-script.sh"]
CMD ["php-fpm"]
