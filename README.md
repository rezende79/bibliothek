## How to run on local machine

1. Create a .env file with this content into project root folder
```
APP_ENV=dev
APP_SECRET=secret
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
```

2. Run the commands below
```shell
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:migrations:migrate --env=test
make phpunit
symfony server:start
```