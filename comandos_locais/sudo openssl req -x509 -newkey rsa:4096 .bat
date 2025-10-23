sudo openssl req -x509 -newkey rsa:4096 -keyout /etc/letsencrypt/live/livrosexpo.site/livrosexpo.key -out /etc/letsencrypt/live/livrosexpo.site/livrosexpo.crt -days 365 -nodes

ssl_certificate /etc/letsencrypt/live/livrosexpo.site/fullchain.pem;
ssl_certificate_key /etc/letsencrypt/live/livrosexpo.site/privkey.pem;

sudo chmod 777 /etc/letsencrypt/live/livrosexpo.site/
sudo chown root:root /etc/letsencrypt/live/livrosexpo.site/



sudo certbot --nginx -d livrosexpo.site -d www.livrosexpo.site -d homol.livrosexpo.site -d homol.livrosexpo.site

