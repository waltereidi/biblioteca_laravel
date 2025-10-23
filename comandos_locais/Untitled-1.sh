# ================================
# Redirect HTTP -> HTTPS (Frontend)
# ================================
server {
    listen 80;
    listen [::]:80;
    server_name livrosexpo.site www.livrosexpo.site;

    return 301 https://$host$request_uri;
}


server {
    server_name livrosexpo.site www.livrosexpo.site;

    listen 443 ssl;
    listen [::]:443 ssl;
    root /var/www/html/biblioteca/public;

    ssl_certificate /etc/letsencrypt/live/livrosexpo.site/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/livrosexpo.site/privkey.pem;
    include /etc/letsencrypt/options-ssl-nginx.conf;
    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;

    # Laravel configuration
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;  # adjust PHP version if needed
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Deny access to hidden files and directories (like .env)
    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Increase upload size (optional)
    client_max_body_size 50M;

    # Access and error logs
    access_log /var/log/nginx/laravel_access.log;
    error_log  /var/log/nginx/laravel_error.log;
}