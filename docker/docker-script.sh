#!/bin/bash
echo "🚀 Executando docker-script.sh..."
composer install --no-interaction --no-plugins --no-scripts

composer global require laravel/installer
exec "$@"
