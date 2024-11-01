<?php
/**
 * File class-extendprofile.php
 *
 * Contains controller for profile page
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package Solea/Controllers/Profile
 */

namespace Solea\App\Controllers\profile;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\LocalGroup;

/**
 *  Controller for profile page
 */
class ExtendProfile {

	/**
	 * Display the form to enter additional profile data
	 *
	 * @return void
	 */
	public static function execute() {
		$user         = wp_get_current_user();
		$local_groups = LocalGroup::all();

		$plugin_data = get_plugin_data( SOLEA_PLUGIN_STARTUP_FILE );
		wp_enqueue_script(
			'solea-profile',
			SOLEA_PLUGIN_URL . '/assets/javascripts/profile.js',
			array(),
			$plugin_data['Version'],
			array( 'in_footer' => false )
		);

		require SOLEA_TEMPLATE_DIR . '/profile/profile.php';
	}
}
