init: init-solved-bug
init-solved-bug: add-or-pass-env down up composer-i migrate-fresh seed app-key-gen down up

add-or-pass-env:
	cp -n .env.example .env
up:
	/bin/bash sail up -d
composer-i:
	/bin/bash sail composer install
migrate-fresh:
	/bin/bash sail artisan migrate:fresh
seed:
	/bin/bash sail artisan db:seed
app-key-gen:
	/bin/bash sail artisan key:generate
down:
	/bin/bash sail down
