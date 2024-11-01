<?php
/**
 * File setup.php
 *
 * Basic site setup for the solea plugin.
 *
 * This file includes various setup functions for the plugin,
 * including object setup, page setup, role setup, and menu setup.
 *
 * @package solea/Setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once SOLEA_PLUGIN_DIR . '/setup/setup-objects.php';
require_once SOLEA_PLUGIN_DIR . '/setup/setup-page.php';
require_once SOLEA_PLUGIN_DIR . '/setup/setup-roles.php';
require_once SOLEA_PLUGIN_DIR . '/setup/setup-menus.php';

/**
 * Basic setup calls
 *
 * @return void
 */
function solea_admin_setup() {
	solea_setup_objects();
	solea_setup_page();
}
