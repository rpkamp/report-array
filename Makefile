test: lint phpcs phpunit

lint:
	vendor/bin/parallel-lint . --exclude vendor

phpcs:
	vendor/bin/phpcs --standard=PSR2 src/

phpunit:
ifeq ($(TRAVIS),true)
	vendor/bin/phpunit --coverage-clover=coverage.xml
else
	vendor/bin/phpunit
endif

.PHONY: test lint phpcs phpunit
