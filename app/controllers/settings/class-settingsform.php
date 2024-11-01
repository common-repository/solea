<?php
/**
 * File: class-settingsform.php
 *
 * @since 2024-07-22
 * @license GPL-3.0-or-later
 *
 * @package Solea/Controllers/Settings/
 */

namespace solea\App\Controllers\settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\LocalGroup;

/**
 * Class SettingsForm
 *
 * Handles the display of settings pages for the plugin. Provides methods to print settings forms based on the active tab and mode.
 */
class SettingsForm {

	/**
	 * Prints the settings page.
	 *
	 * This method loads the appropriate settings page based on the provided slug, active tab, and mode. It also handles
	 * different modes like displaying general settings, local groups, or editing a specific group.
	 *
	 * @param string $slug The slug used for identifying the specific settings page.
	 *
	 * @return void
	 */
	public static function print_settings_page( string $slug ) {
		if ( null === $slug ) {
			wp_die( 'Invalid script call' );
		}
		require SOLEA_TEMPLATE_DIR . '/settings/settings.php';
	}


	/**
	 * Prints the local group page based on the given parameters.
	 *
	 * @param string      $slug The slug of the page.
	 * @param string|null $mode The mode of the page. Defaults to 'local-groups'.
	 * @param int|null    $group_id The ID of the group. Only used when $mode is 'edit-group-form'.
	 *
	 * @return void
	 */
	public static function print_local_group_page( string $slug, ?string $mode, ?int $group_id = null ) {
		if ( null === $slug ) {
			wp_die( 'Invalid script call' );
		}
		if ( null === $mode ) {
			$mode       = 'local-groups';
			$all_groups = LocalGroup::all();
		} elseif ( 'edit-group-form' ) {
			$group = LocalGroup::where( 'id', $group_id )->first();
		}

		$page = 'options-general.php';
		if ( is_multisite() ) {
			$page = 'network/settings.php';
		}

		require SOLEA_TEMPLATE_DIR . '/partials/settings/' . $mode . '.php';
	}
}
