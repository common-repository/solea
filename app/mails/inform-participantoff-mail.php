<?php
/**
 * File: inform-participantoff-mail.php
 *
 * @since 2024-07-27
 * @license GPL-3.0-or-later
 *
 * @package Solea/Mails/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Participant;
use Solea\App\models\Event;

/**
 * Generates an email informing a participant that they have been signed off from an event.
 *
 * This function creates an HTML message to notify a participant that they have been signed off from the event.
 * It also informs them that the event management will contact them regarding any refunds and provides contact details
 * for further inquiries.
 *
 * @param Participant $participant The participant who has been signed off.
 * @param Event       $event The event from which the participant has been signed off.
 *
 * @return string The formatted HTML message for the email.
 */
function solea_participant_inform_signedoff_mail( Participant $participant, Event $event ): string {
	$return = '<h3>' .
				wp_sprintf(
				/* Translators: %s$s is the name of the participant, %2$s the name of the event.  */

					__( 'Hello %1$s,</h3><br />You are now signed off from the event "%2$s"<br /><br />The event management will contact you if you receive any refunds.', 'solea' ),
					esc_html( $participant->firstname . ' ' . $participant->lastname ),
					esc_html( $event->event_name )
				) .
				'<p>' .
				esc_html__( 'For further questions, please contact', 'solea' ) . ' ' .
				'<a href="mailto:' . esc_html( $event->event_email ) . '">' .
				esc_html__( 'The event management crew', 'solea' ) .
				'</a>' .
				'</p>';

	return $return;
}
