#!/bin/sh
# Runs the Author Extras tests with the theme's PHPUnit. Set MD_THEME_DIR when
# the theme isn't at ../../themes/marketers-delight.

set -e
cd "$(dirname "$0")/.."

theme="${MD_THEME_DIR:-../../themes/marketers-delight}"

php "$theme/tests/bin/phpunit.phar" -c phpunit.xml "$@"
