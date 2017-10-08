test:
	vendor/bin/parallel-lint . --exclude vendor
	vendor/bin/phpcs --standard=PSR2 src/
	vendor/bin/phpunit
.PHONY: test
