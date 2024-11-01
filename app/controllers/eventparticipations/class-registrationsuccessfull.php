<?php
/**
 * File: class-registrationsuccessfull.php
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

use solea\App\Actions\Participants\SendNewParticipantMail;
use Solea\App\models\Event;
use Solea\App\models\Participant;
use Solea\App\Requests\EatingHabit;
use Solea\Libs\MailLibrary;

/**
 * Class RegistrationSuccessfull
 *
 * Handles the successful registration process for a participant.
 * This includes sending a confirmation email and displaying a success message.
 */
class RegistrationSuccessfull {

	/**
	 * Executes the process for a successful participant registration.
	 *
	 * This method sends a confirmation email to the participant and displays a success message.
	 * It retrieves the event details, formats the participant's arrival and departure dates,
	 * and then includes a template to show the success message.
	 *
	 * @param Participant $participant The participant who has successfully registered.
	 *                                  Contains information like names, dates, and event ID.
	 *
	 * @return void
	 */
	public static function execute( Participant $participant ) {
		$event = Event::where( 'id', $participant->event_id )->first();

		$nicename = $participant->firstname . ' ' . $participant->lastname;
		if ( null !== $participant->nickname ) {
			$nicename = $participant->nickname;
		}
		$arrival          = \DateTime::createFromFormat( 'Y-m-d', $participant->arrival )->format( 'd.m.Y' );
		$departure        = \DateTime::createFromFormat( 'Y-m-d', $participant->departure )->format( 'd.m.Y' );
		$registration_end = \DateTime::createFromFormat( 'Y-m-d', $event->registration_end )->format( 'd.m.Y' );
		$eating_habit     = EatingHabit::execute( $participant->eating_habit );
		$payment_purpose  = str_replace( '_', ' ', $event->event_name )
							. ' - ' . __( 'Contribution', 'solea' ) . ' ' . $participant->firstname . ' ' . $participant->lastname;

		SendNewParticipantMail::execute( $participant );

		require SOLEA_TEMPLATE_DIR . '/event-registration/after-submit/success.php';
	}
}
