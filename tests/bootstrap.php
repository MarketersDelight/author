<?php
/**
 * Run the Author Extras tests on the theme's inheritance test bootstrap,
 * which stubs WordPress and loads the theme code Author Extras builds on.
 * Set MD_THEME_DIR when the theme isn't beside md-dropins in wp-content.
 *
 * @since 1.0
 */

define( 'MD_TEST_THEME_DIR', getenv( 'MD_THEME_DIR' ) ?: dirname( __DIR__, 3 ) . '/themes/marketers-delight' );

require_once MD_TEST_THEME_DIR . '/tests/inheritance/bootstrap.php';
require_once dirname( __DIR__ ) . '/functions.php';
require_once dirname( __DIR__ ) . '/author.php';
