# How to run on local machine
```shell
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:migrations:migrate --env=test
make phpunit
symfony server:start
```