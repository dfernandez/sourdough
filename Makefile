cs-fix:
	./bin/php-cs-fixer fix . -vv

cs-fix-dry-run:
	./bin/php-cs-fixer fix . --dry-run -vv

local-server:
	php -S localhost:8080 -t public public/routing.php
