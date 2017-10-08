test:
	vendor/bin/parallel-lint . --exclude vendor
	vendor/bin/phpunit
.PHONY: test
