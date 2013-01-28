PHP = $(shell which php)
PHPUNIT = vendor/bin/phpunit
PHPUNIT_FLAGS = --verbose --strict
COMPOSER_FLAGS=--no-ansi --verbose --no-interaction

all: test

test: $(PHPUNIT)
	$(PHP) $(PHPUNIT) $(PHPUNIT_FLAGS) test

coverage: $(PHPUNIT)
	$(PHP) $(PHPUNIT) $(PHPUNIT_FLAGS) --coverage-html ./coverage test

composer-install: composer.phar
	$(PHP) composer.phar $(COMPOSER_FLAGS) install --dev

update: composer.phar
	$(PHP) composer.phar $(COMPOSER_FLAGS) update --dev

composer.phar:
	curl -s -z composer.phar -o composer.phar http://getcomposer.org/composer.phar


vendor/bin/phpunit: composer-install


.PHONY: all test
