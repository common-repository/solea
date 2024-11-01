<?php
/**
 * File: new-participant-mail.php
 *
 * @since 2024-07-24
 * @license GPL-3.0-or-later
 *
 * @package Solea/Mails/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\models\Participant;

/**
 * Generates an email notification for a new participant registration.
 *
 * This function creates an HTML email message to inform about a new participant who has signed up for an event.
 * It includes details about the participant and provides a link to view more details if the recipient is part of the event management team.
 *
 * @param Participant $participant The participant who has just signed up.
 * @param Event       $event The event for which the participant has signed up.
 *
 * @return string The formatted HTML message for the email.
 */
function solea_new_participant_mail( Participant $participant, Event $event ): string {
	$return = '<h3>' . esc_html__( 'Hello', 'solea' ) . ',</h3><br /><br />' .
				wp_sprintf(
				/* Translators: %s Event name */
					esc_html__( 'A new participant has just signed up for the event "%s".', 'solea' ),
					esc_html( $event->event_name )
				) . '<br /><br /><table>' .
				'<tr><td>' . esc_html__( 'Firstname:', 'solea' ) . '</td><td>' . esc_html( $participant->firstname ) . '</td></tr>' .
				'<tr><td>' . esc_html__( 'Lastname:', 'solea' ) . '</td><td>' . esc_html( $participant->lastname ) . '</td></tr>' .
				'<tr><td>' . esc_html__( 'Nickname:', 'solea' ) . '</td><td>' . esc_html( $participant->nickname ) . '</td></tr>' .
				'<tr><td>' . esc_html__( 'E-Mail:', 'solea' ) . '</td><td>' . esc_html( $participant->email_1 ) . '</td></tr>';

	if ( ! empty( $participant->email_2 ) ) {
		$return .= '<tr><td>' . esc_html__( 'E-Mail (parents):', 'solea' ) . '</td><td>' . esc_html( $participant->email_2 ) . '</td></tr>';
	}

	$return .= '</table><br /><br />' .
				esc_html__( 'If you are part of the event management, you can see all details on:', 'solea' ) . ' ' .
				'<a href="' . esc_url( site_url() ) . '">' . esc_url( site_url() ) . '</a>';

	return $return;
}
