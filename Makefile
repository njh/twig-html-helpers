PHP = $(shell which php)
PHPUNIT = vendor/bin/phpunit
PHPUNIT_FLAGS = --verbose
COMPOSER_FLAGS=--no-ansi --verbose --no-interaction

all: test

test: $(PHPUNIT)
	$(PHP) $(PHPUNIT) $(PHPUNIT_FLAGS) ./test

coverage: $(PHPUNIT)
	$(PHP) $(PHPUNIT) $(PHPUNIT_FLAGS) --coverage-html ./coverage ./test

composer-install: composer.phar
	$(PHP) composer.phar $(COMPOSER_FLAGS) install

update: composer.phar
	$(PHP) composer.phar $(COMPOSER_FLAGS) update

composer.phar:
	curl -s -z composer.phar -o composer.phar https://getcomposer.org/composer.phar


vendor/bin/phpunit: composer-install

clean:
	find . -name '.DS_Store' -type f -delete
	-rm -f composer.phar composer.lock
	-rm -Rf vendor
	-rm -Rf coverage

.PHONY: all test clean
