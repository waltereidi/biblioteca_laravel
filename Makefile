buildup:
	docker compose -f docker/docker-compose.yml up -d --build
bash:
	docker exec -it laravel_app bash
bashdb:
	docker exec -it laravel_db bash
runserver: 
	docker exec -it laravel_app bash -c "php artisan serve --host=0.0.0.0 --port=8000"


