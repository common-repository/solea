<?php
/**
 * File: inform-localgroup-mail.php
 *
 * @since 2024-07-29
 * @license GPL-3.0-or-later
 *
 * @package Solea/Mails/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\Requests\GetParticipationTypeName;

/**
 * Generates an informational email about the event's registration status and participant details for a local group.
 *
 * This function creates an email message providing information about the event's registration status,
 * including whether the event is still open for registrations or has just closed. It also includes a list of
 * participants registered for the local group.
 *
 * @param Event         $event The event object containing details about the event.
 * @param Participant[] $participants An array of Participant objects registered for the local group.
 *
 * @return string The formatted HTML message for the email.
 */
function solea_inform_localgroup_mail( Event $event, array $participants ): string {
	$now = new \DateTime();

	$registration_end = \DateTime::createFromFormat( 'Y-m-d', $event->registration_end );
	$compare          = $now->diff( $registration_end );

	$return = '<h3>' . __( 'Hello,', 'solea' ) . '</h3><br /><br />';

	if ( 1 === $compare->invert ) {
		$return .= wp_sprintf(
			/* Translators: %1$s: Event-Name, %2$s Registration end day */
			__( 'This is just a small information email to let you know that your event %1$s is still open for registrations until %2$s.', 'solea' ),
			$event->event_name,
			$registration_end->format( 'd.m.Y' )
		) .
					'<br /><br />' .
					__( 'The following participants are registered for your local group:', 'solea' );
	} else {
		$return .= wp_sprintf(
			/* Translators: %s is the name of the event. */
			__( 'The event "%s" has just closed. Please check the participation lists.', 'solea' ),
			$event->event_name
		) .
					'<br /><br />' .
					__( 'The following participants are currently registered for your local group:', 'solea' );
	}

	$return .= '<ul>';
	foreach ( $participants as $participant ) {
		$return .= '<li>' . $participant->firstname . ' ' . $participant->lastname;
		if ( '' !== $participant->nickname ) {
			$return .= ' (' . $participant->nickname . ')';
		}
		$return .= ' (' . solea_get_age( $participant->birthday ) . ' ' . __( 'years', 'solea' ) . ') - ' .
					GetParticipationTypeName::execute( $participant->participant_group ) . '</li>';
	}
	$return .= '</ul>';

	return $return;
}
