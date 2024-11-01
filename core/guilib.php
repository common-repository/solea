<?php
/**
 * File: guilib.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package solea/Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\Routers\AjaxRouter;

/**
 * Loads Stylesheets and JavaScript to page
 *
 * @return void
 */
function solea_enqueue_custom_scripts() {
	$plugin_data = get_plugin_data( SOLEA_PLUGIN_STARTUP_FILE );

	wp_enqueue_style(
		'solea-dashboard-style',
		SOLEA_PLUGIN_URL . '/assets/stylesheets/dashboard.css',
		array(),
		$plugin_data['Version']
	);
	wp_enqueue_script(
		'solea-ajax',
		SOLEA_PLUGIN_URL . '/assets/javascripts/ajax.js',
		array(),
		$plugin_data['Version'],
		array( 'in_footer' => false )
	);

	wp_enqueue_script(
		'solea-lib',
		SOLEA_PLUGIN_URL . '/assets/javascripts/library.js',
		array(),
		$plugin_data['Version'],
		array( 'in_footer' => false )
	);

	wp_enqueue_script(
		'solea-js',
		SOLEA_PLUGIN_URL . '/assets/javascripts/dashboard.js',
		array(),
		$plugin_data['Version'],
		array( 'in_footer' => false )
	);
}

/**
 * Initiates the Ajax component
 *
 * @return void
 */
function solea_load_ajax_content() {
	AjaxRouter::execute();
	exit;
}

/**
 * Initialize plugin for localization.
 *
 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
 *
 * Locales found in:
 *     - WP_LANG_DIR/rank-math/solea-LOCALE.mo
 *     - WP_LANG_DIR/plugins/solea-LOCALE.mo
 */
function solea_localization_setup() {
	$locale = get_user_locale();

	$locale = apply_filters( 'plugin_locale', $locale, SOLEA_PLUGIN_SLUG ); // phpcs:ignore

	unload_textdomain( SOLEA_PLUGIN_SLUG );
	if ( false === load_textdomain( SOLEA_PLUGIN_SLUG, WP_LANG_DIR . '/plugins/' . SOLEA_PLUGIN_SLUG . '-' . $locale . '.mo' ) ) {
		load_textdomain( SOLEA_PLUGIN_SLUG, WP_LANG_DIR . '/' . SOLEA_PLUGIN_SLUG . '/' . SOLEA_PLUGIN_SLUG . '-' . $locale . '.mo' );
	}

	load_textdomain( SOLEA_PLUGIN_SLUG, SOLEA_PLUGIN_DIR . '/languages/' . SOLEA_PLUGIN_SLUG . '-' . $locale . '.mo', $locale );
}
