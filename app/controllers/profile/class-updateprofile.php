<?php
/**
 * File class-updateprofile.php
 *
 * Contains the controller for updating the userprofile
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
 *  Controller for updating the userprofile
 */
class UpdateProfile {
	/**
	 * Updates the current user's profile information.
	 *
	 * This method updates various user meta fields, including personal details, contact information, and preferences.
	 * It also updates the user's email address and shows a success message.
	 *
	 * @param string $firstname The first name of the user.
	 * @param string $lastname The last name of the user.
	 * @param string $email The email address of the user.
	 * @param string $telephone The telephone number of the user.
	 * @param string $street The street address of the user.
	 * @param string $housenumber The house number of the user. This could be a string or integer.
	 * @param string $zip The ZIP code of the user's address.
	 * @param string $city The city of the user's address.
	 * @param string $allergies The allergies information of the user.
	 * @param string $intolerances The food intolerance information of the user.
	 * @param string $medication The medication information of the user.
	 * @param int    $localgroup The ID of the local group associated with the user.
	 * @param string $birthday The birthday of the user in a suitable format (e.g., 'YYYY-MM-DD').
	 * @param string $nickname The nickname of the user.
	 *
	 * @return void
	 */
	public static function execute(
		string $firstname,
		string $lastname,
		string $email,
		string $telephone,
		string $street,
		string $housenumber,
		string $zip,
		string $city,
		string $allergies,
		string $intolerances,
		string $medication,
		int $localgroup,
		string $birthday,
		string $nickname
	) {
		$user_id = get_current_user_id();
		update_user_meta( $user_id, 'first_name', $firstname );
		update_user_meta( $user_id, 'last_name', $lastname );
		update_user_meta( $user_id, 'telephone', $telephone );
		update_user_meta( $user_id, 'localgroup', $localgroup );
		update_user_meta( $user_id, 'street', $street );
		update_user_meta( $user_id, 'housenumber', $housenumber );
		update_user_meta( $user_id, 'zipcode', $zip );
		update_user_meta( $user_id, 'city', $city );
		update_user_meta( $user_id, 'allergies', $allergies );
		update_user_meta( $user_id, 'intolerances', $intolerances );
		update_user_meta( $user_id, 'medication', $medication );
		update_user_meta( $user_id, 'birthday', $birthday );
		update_user_meta( $user_id, 'solea_nickname', $nickname );
		wp_update_user(
			array(
				'ID'         => $user_id,
				'user_email' => $email,
			)
		);

		solea_show_message( __('The profile was updated.', 'solea') , true );
		$user         = wp_get_current_user();
		$local_groups = LocalGroup::all();
		$plugin_data  = get_plugin_data( SOLEA_PLUGIN_STARTUP_FILE );
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
