init: add-or-pass-env down up composer-i migrate-fresh seed app-key-gen

add-or-pass-env:
	cp -n .env.example .env
up:
	bash sail up -d
composer-i:
	bash sail composer install
migrate-fresh:
	bash sail artisan migrate:fresh
seed:
	bash sail artisan db:seed
app-key-gen:
	bash sail artisan key:generate
down:
	bash sail down
