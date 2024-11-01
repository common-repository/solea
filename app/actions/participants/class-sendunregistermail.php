<?php
/**
 * File: class-sendunregistermail.php
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
 * Class SendUnregisterMail
 *
 * Handles sending notification emails when a participant is unregistered from an event.
 */
class SendUnregisterMail {

	/**
	 * Executes the process of sending a notification email about a participant's unregistration.
	 *
	 * @param Participant $participant The participant object that was unregistered.
	 * @param Event       $event The event from which the participant was unregistered.
	 * @return void
	 */
	public static function execute( Participant $participant, Event $event ) {
		$mail = new MailLibrary();
		$mail->set_recipients( $event->get_organiser_mails() );
		$mail->add_recipient( $participant->get_local_group_mail() );
		$mail->set_subject(
			'[solea] ' . wp_sprintf(
			/* Translators: %s is the name of the event */
				__( 'Participant for event "%s" was unregistered', 'solea' ),
				$event->event_name
			)
		);

		$mail->set_message( solea_new_participant_mail( $participant, $event ) );
		$mail->send();
	}
}
