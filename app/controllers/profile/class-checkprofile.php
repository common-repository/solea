<?php
/**
 * File class-checkprofile.php
 *
 * Checks if the profile of the loggedin user is complete and triggers a function to print a messagebox if not
 * If not, a reminder is printed
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

/**
 *  Checks if the profile of the loggedin user is complete and triggers a function to print a messagebox if not
 *  If not, a reminder is printed
 */
class CheckProfile {

	/**
	 * Checks if the profile of the loggedin user is complete and triggers a function to print a messagebox if not
	 *
	 * @return void
	 */
	public static function execute() {
		$user = wp_get_current_user();

		if (
			'' === $user->first_name ||
			'' === $user->last_name ||
			'' === $user->street ||
			'' === $user->housenumber ||
			'' === $user->zipcode ||
			'' === $user->city ||
			'' === $user->birthday ||
			'' === $user->localgroup
		) {
			add_action( 'admin_notices', array( 'Solea\App\Controllers\profile\CheckProfile', 'print_infobox' ) );
		}
	}

	/**
	 * Prints the messagebox, that the profile of the loggedin user is not complete
	 *
	 * @return void
	 */
	public static function print_infobox() {
		require SOLEA_TEMPLATE_DIR . '/profile/missing-settings.php';
	}
}
