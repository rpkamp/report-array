test: lint phpcs phpunit

lint:
	vendor/bin/parallel-lint . --exclude vendor

phpcs:
	vendor/bin/phpcs --standard=PSR2 src/

phpunit:
ifeq ($(TRAVIS),true)
	vendor/bin/phpunit --testdox --coverage-clover=coverage.xml
else
	vendor/bin/phpunit --testdox
endif

.PHONY: test lint phpcs phpunit
