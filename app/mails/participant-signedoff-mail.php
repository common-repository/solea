<?php
/**
 * File: participant-signedoff-mail.php
 *
 * @since 2024-07-27
 * @license GPL-3.0-or-later
 *
 * @package Solea/Mails/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Generates an email notification for a participant who has signed off from an event.
 *
 * This function creates an HTML email message to inform about a participant who has just signed off from an event.
 * It includes details about the participant and provides a contact link for further inquiries.
 *
 * @param Participant $participant The participant who has signed off.
 * @param Event       $event The event from which the participant has signed off.
 *
 * @return string The formatted HTML message for the email.
 */
function solea_participant_signedoff_mail( Participant $participant, Event $event ): string {
	$return = '<h3>' . esc_html__( 'Hello', 'solea' ) . ',</h3><br /><br />' .
				wp_sprintf(
					/* Translators: %s$s is the name of the participant, %2$s the name of the event.  */
					esc_html__( 'The participant %1$s has just signed off from the event "%2$s".', 'solea' ),
					esc_html( $participant->firstname . ' ' . $participant->lastname ),
					esc_html( $event->event_name )
				) . '<br /><br />' .
				esc_html__( 'For further questions, please contact', 'solea' ) . ' ' .
				'<a href="mailto:' . esc_html( $event->event_email ) . '">' . esc_html__( 'The event management crew', 'solea' ) . '</a>';

	return $return;
}
