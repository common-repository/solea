<?php
/**
 * File: class-registrationfailed.php
 *
 * @since 2024-07-24
 * @license GPL-3.0-or-later
 *
 * @package Solea/Controllers/EventParticipations/
 */

namespace solea\App\Controllers\EventParticipations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;

/**
 * Class RegistrationFailed
 *
 * Handles the display of error messages related to registration issues.
 * This includes scenarios where registration has failed or the participant is already registered.
 */
class RegistrationFailed {

	/**
	 * Displays an error message when registration fails.
	 *
	 * Includes the template for displaying a failed registration message. This could be used to show
	 * errors such as validation issues or technical problems during registration.
	 *
	 * @param Event  $event The event for which registration failed. Provides context and details related to the event.
	 * @param string $name The name of the participant or other relevant identifier used in the error message.
	 *
	 * @return void
	 */
	public static function display_error( Event $event, string $name ) {
		if ( ! isset( $event->id ) || '' === $name ) {
			wp_die( 'Internal error occured.' );
		}
		require SOLEA_TEMPLATE_DIR . '/event-registration/after-submit/failed.php';
	}

	/**
	 * Displays a message when the participant is already registered.
	 *
	 * Includes the template for showing a message indicating that the participant is already registered.
	 * This might be used to prevent duplicate registrations and inform the user accordingly.
	 *
	 * @param Event  $event The event for which the participant is already registered. Provides context and details related to the event.
	 * @param string $name The name of the participant or other relevant identifier used in the message.
	 *
	 * @return void
	 */
	public static function display_already_registered( Event $event, string $name ) {
		if ( ! isset( $event->id ) || '' === $name ) {
			wp_die( 'Internal error occured.' );
		}
		require SOLEA_TEMPLATE_DIR . '/event-registration/after-submit/alreadyexisting.php';
	}
}
