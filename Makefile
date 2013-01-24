PHP = $(shell which php)
PHPUNIT = vendor/bin/phpunit
COMPOSER_FLAGS=--no-ansi --verbose --no-interaction

all: test

test: $(PHPUNIT)
	$(PHP) $(PHPUNIT) test

composer-install: composer.phar
	$(PHP) composer.phar $(COMPOSER_FLAGS) install --dev

update: composer.phar
	$(PHP) composer.phar $(COMPOSER_FLAGS) update --dev

composer.phar:
	curl -s -z composer.phar -o composer.phar http://getcomposer.org/composer.phar


vendor/bin/phpunit: composer-install


.PHONY: all test
