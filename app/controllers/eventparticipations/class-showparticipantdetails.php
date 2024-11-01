<?php
/**
 * File: class-showparticipantdetails.php
 *
 * @since 2024-07-26
 * @license GPL-3.0-or-later
 *
 * @package Solea/Controllers/EventParticipations/
 */

namespace solea\App\Controllers\EventParticipations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\models\Participant;

/**
 * Class ShowParticipantDetails
 *
 * Handles the display of detailed information for a specific participant.
 * This includes retrieving event details and including the appropriate template for displaying participant information.
 */
class ShowParticipantDetails {

	/**
	 * Displays detailed information for a participant.
	 *
	 * This method retrieves the event associated with the participant and
	 * includes a template to show the participant's details. It ensures that
	 * the user has the necessary permissions to view the event details.
	 *
	 * @param Participant $participant The participant whose details are to be displayed.
	 *                                 This object contains the participant's information and event ID.
	 *
	 * @return void
	 */
	public static function execute( Participant $participant ) {
		$event = Event::get_with_permission_check( $participant->event_id );

		require SOLEA_TEMPLATE_DIR . '/participants/showdetails.php';
	}
}
