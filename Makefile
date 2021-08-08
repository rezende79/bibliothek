cs-fix-install: ## Install php-cs-fixer
	composer require --working-dir=tools/php-cs-fixer friendsofphp/php-cs-fixer

cs-fix: ## Run php-cs-fixer
	tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src

phpunit: ## Run tests
	php ./vendor/bin/phpunit