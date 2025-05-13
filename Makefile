.PHONY: install run subrun migrate fresh seed rollback

	//The target name INSTALL used this if you clone this application to install the dependencies

install:
	@echo "Installing dependencies..."
	composer install
	npm install
	cp .env-example .env
	php artisan key:generate

	//This will run the application
run:
	@echo "Running your application..."
	php artisan serve

	//This will run the application on a different port
subrun:
	@echo "Running your application..."
	php artisan serve --port=8002

	//This will migrate the new migrations
migrate:
	@echo "Running migrations..."
	php artisan migrate

	//This will refresh and migrate again and also seed the database
fresh:
	@echo "Running fresh migrations..."
	php artisan migrate:fresh
	php artisan db:seed

	//This will seed the database with the AdminSeeder
seed:
	@echo "Seeding the database..."
	php artisan db:seed --class=AdminSeeder

	//This will rollback the last migration
rollback:
	@echo "Rolling back the last migration..."
	php artisan migrate:rollback