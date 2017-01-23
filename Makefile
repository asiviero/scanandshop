all: phpdep jsdep

.PHONY: all phpdep jsdep test run db

jsdep:
	npm install
	gulp

composer.phar:
	sh composer.sh

phpdep: composer.phar
	php composer.phar install
	php artisan doctrine:migrations:migrate

test:
	phpunit

run:
	php artisan serve
