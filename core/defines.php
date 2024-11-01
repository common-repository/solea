<?php
/**
 * File: defines.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package solea/Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SOLEA_PLUGIN_SLUG', 'solea' );
define( 'SOLEA_PLUGIN_STARTUP_FILE', WP_PLUGIN_DIR . '/' . SOLEA_PLUGIN_SLUG . '/' . SOLEA_PLUGIN_SLUG . '.php' );

define( 'SOLEA_PLUGIN_DIR', plugin_dir_path( SOLEA_PLUGIN_STARTUP_FILE ) );
define( 'SOLEA_PLUGIN_URL', plugin_dir_url( SOLEA_PLUGIN_STARTUP_FILE ) );
define( 'SOLEA_TEMPLATE_DIR', SOLEA_PLUGIN_DIR . '/app/views/' );

define( 'SOLEA_WP_FS_CHMOD_FILE', ( fileperms( ABSPATH . 'index.php' ) & 0777 | 0644 ) );
define( 'SOLEA_WP_FS_CHMOD_DIRECTORY', ( fileperms( ABSPATH . 'index.php' ) & 0777 | 0755 ) );
