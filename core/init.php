<?php
/**
 * File: init.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package solea/Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/defines.php';
require_once ABSPATH . '/wp-admin/includes/plugin.php';
require_once ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php';
require_once ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php';
require_once ABSPATH . '/wp-includes/pluggable.php';
require_once ABSPATH . '/wp-includes/capabilities.php';
require_once ABSPATH . '/wp-admin/includes/template.php';
require_once ABSPATH . '/wp-admin/includes/file.php';
require_once ABSPATH . '/wp-admin/includes/upgrade.php';

require SOLEA_PLUGIN_DIR . '/vendor/autoload.php';

$directories = array(
	'models/',
	'routers/',
	'routers/',
	'controllers/',
	'controllers/events',
	'controllers/eventparticipations',
	'controllers/settings',
	'controllers/mails',
	'controllers/profile',
	'actions/',
	'actions/events',
	'actions/participants',
	'requests/',
	'mails/',
	'pdflists/',
	'tasks',

);

require_once SOLEA_PLUGIN_DIR . '/core/multisite.php';
require_once SOLEA_PLUGIN_DIR . '/libs/class-mainmodel.php';
require_once SOLEA_PLUGIN_DIR . '/libs/class-maillibrary.php';
require_once SOLEA_PLUGIN_DIR . '/libs/pdfhandler.php';
require_once SOLEA_PLUGIN_DIR . '/libs/statusmessage.php';
require_once SOLEA_PLUGIN_DIR . '/libs/capabilities.php';
require_once SOLEA_PLUGIN_DIR . '/libs/amount.php';
require_once SOLEA_PLUGIN_DIR . '/libs/age.php';
require_once SOLEA_PLUGIN_DIR . '/libs/telephone.php';
require_once SOLEA_PLUGIN_DIR . '/libs/email.php';

foreach ( $directories as $directory ) {
	$directory = SOLEA_PLUGIN_DIR . '/app/' . $directory;

	$handle = opendir( $directory );
	while ( $entry = readdir( $handle ) ) {
		if ( '.' !== $entry && '..' !== $entry ) {
			$file_path = $directory . DIRECTORY_SEPARATOR . $entry;
			if ( is_file( $file_path ) && pathinfo( $file_path, PATHINFO_EXTENSION ) === 'php' ) {
				require_once $file_path;
			}
		}
	}

	closedir( $handle );
}

require_once SOLEA_PLUGIN_DIR . 'libs/class-fileaccess.php';
require_once SOLEA_PLUGIN_DIR . 'core/sqlsetup.php';
require_once SOLEA_PLUGIN_DIR . 'core/cronjob.php';
require_once SOLEA_PLUGIN_DIR . 'setup/setup.php';
require_once SOLEA_PLUGIN_DIR . 'core/guilib.php';
