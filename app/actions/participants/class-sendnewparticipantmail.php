<?php
/**
 * File: class-sendnewparticipantmail.php
 *
 * @since 2024-07-27
 * @license GPL-3.0-or-later
 *
 * @package Solea/Actions/Participants/
 */

namespace solea\App\Actions\Participants;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\models\Participant;
use Solea\Libs\MailLibrary;

/**
 * Class SendNewParticipantMail
 *
 * Handles sending confirmation emails to a new participant and notifying the event management.
 */
class SendNewParticipantMail {

	/**
	 * Executes the process of sending a confirmation email to the new participant and notifying event management.
	 *
	 * @param Participant $participant The participant object containing details of the participant.
	 * @return void
	 */
	public static function execute( Participant $participant ) {
		$nicename = ( '' !== $participant->nickname ? $participant->nickname : $participant->firstname . ' ' . $participant->lastname );

		$event            = Event::where( 'id', $participant->event_id )->first();
		$arrival          = \DateTime::createFromFormat( 'Y-m-d', $participant->arrival )->format( 'd.m.Y' );
		$departure        = \DateTime::createFromFormat( 'Y-m-d', $participant->departure )->format( 'd.m.Y' );
		$registration_end = \DateTime::createFromFormat( 'Y-m-d', $event->registration_end )->format( 'd.m.Y' );

		$payment_purpose = '';
		if ( $event->payment_direct ) {
			$payment_purpose = str_replace( '_', ' ', $event->event_name )
								. ' - ' . __( 'Contribution', 'solea' ) . ' ' . $participant->firstname . ' ' . $participant->lastname;
		}

		$eating_habit = __( 'I also eat meat', 'solea' );
		if ( 'vegetarian' === $participant->eating_habit ) {
			$eating_habit = __( 'Vegetarian', 'solea' );
		}
		if ( 'vegan' === $participant->eating_habit ) {
			$eating_habit = __( 'Vegan', 'solea' );
		}

		$mail = new MailLibrary();
		$mail->set_message(
			solea_get_registration_successfull_for_participant_mail(
				$nicename,
				$event,
				$participant->amount,
				$payment_purpose,
				$arrival,
				$departure,
				$eating_habit,
				$registration_end
			)
		);
		$mail->set_sender( $event->event_email );
		$mail->set_subject( '[solea] - ' . __( 'Your registration confirmation for event', 'solea' ) . ' "' . $event->event_name . '"' );
		$mail->add_recipient( $participant->email_1 );

		if ( null !== $participant->email_2 ) {
			$mail->add_recipient( $participant->email_2 );
		}

		$mail->send();
	}
}
