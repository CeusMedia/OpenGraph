composer-install-dev:
	@test ! -d vendor/phpstan/phpstan && XDEBUG_MODE=off composer install || true

composer-install-nodev:
	@test ! -f vendor/autoload.php && XDEBUG_MODE=off composer install --no-dev || true

composer-update-dev:
	@XDEBUG_MODE=off composer update

composer-update-modev:
	@XDEBUG_MODE=off composer update --no-dev

dev-phpstan: composer-install-dev
	@vendor/bin/phpstan analyse --configuration phpstan.neon --xdebug || true

dev-phpstan-save-baseline: composer-install-dev composer-update-dev
	@vendor/bin/phpstan analyse --configuration phpstan.neon --generate-baseline phpstan-baseline.neon || true

dev-test-syntax:
	@find src -type f -print0 | xargs -0 -n1 xargs php -l
#	@find test -type f -print0 | xargs -0 -n1 xargs php -l

dev-rector-check:
	@vendor/bin/rector process src --dry-run

dev-rector-fix:
	@vendor/bin/rector process src

#dev-doc: composer-install-dev
#	@test -f doc/API/search.html && rm -Rf doc/API || true
#	@php vendor/ceus-media/doc-creator/doc.php --config-file=doc.xml
#
#dev-test-all-with-coverage:
#	@XDEBUG_MODE=coverage vendor/bin/phpunit -v || true
#
#dev-test-integration: composer-install-dev
#	@XDEBUG_MODE=off vendor/bin/phpunit -v --no-coverage --testsuite integration || true
#
#dev-test-units: composer-install-dev
#	@XDEBUG_MODE=off vendor/bin/phpunit -v --no-coverage --testsuite unit || true
#
#dev-test-units-parallel: composer-install-dev
#	@XDEBUG_MODE=off vendor/bin/paratest -v --no-coverage --testsuite unit || true
#
#dev-test-units-with-coverage: composer-install-dev
#	@XDEBUG_MODE=coverage vendor/bin/phpunit -v --testsuite unit || true
#
#dev-retest-integration: composer-install-dev
#	@XDEBUG_MODE=off vendor/bin/phpunit -v --no-coverage --testsuite integration --order-by=defects --stop-on-defect || true
#
#dev-retest-units: composer-install-dev
#	@XDEBUG_MODE=off vendor/bin/phpunit -v --no-coverage --testsuite unit --order-by=defects --stop-on-defect || true
