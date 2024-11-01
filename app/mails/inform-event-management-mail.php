<?php
/**
 * File: inform-event-management-mail.php
 *
 * @since 2024-07-29
 * @license GPL-3.0-or-later
 *
 * @package Solea/Mails
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;

/**
 * Generates an informational email about the event registration status.
 *
 * This function creates an email message informing about the current status of an event's registration period.
 * It informs whether the event is still open for registrations or has just closed.
 *
 * @param Event $event The event object containing details about the event.
 *
 * @return string The formatted HTML message for the email.
 */
function solea_inform_management_mail( Event $event ): string {
	$now = new \DateTime();

	$registration_end = \DateTime::createFromFormat( 'Y-m-d', $event->registration_end );
	$compare          = $now->diff( $registration_end );

	$return = '<h3>' . __( 'Hello,', 'solea' ) . '</h3><br /><br />';

	if ( 1 !== $compare->invert ) {
		$return .= wp_sprintf(
					/* Translators: %1$s is the event name, %2$s the endday of registration. */
			__( 'This is just a small information email that your event %1$s is still open for registrations until %2$s.', 'solea' ),
			$event->event_name,
			$registration_end->format( 'd.m.Y' )
		) .
					'<br /><br />' .
					wp_sprintf(
					/* Translators: %1$s is the url, %2$s the url. */
						__( 'You can already check the participant list here: <a href="%1$s">%2$s</a>', 'solea' ),
						get_admin_url() . 'admin.php?page=solea-show-event_' . $event->id,
						get_admin_url() . 'admin.php?page=solea-show-event_' . $event->id
					);
	} else {
		$return .= wp_sprintf(
			/* Translators: %s is the name of the event */
			__( 'The event "%s" has just closed. Please check the participation lists.', 'solea' ),
			$event->event_name
		) .
					'<br /><br />' .
					wp_sprintf(
					/* Translators: %1$s is the url, %2$s the url. */
						__( 'You can check the participant list here: <a href="%1$s">%2$s</a>', 'solea' ),
						get_admin_url() . 'admin.php?page=solea-show-event_' . $event->id,
						get_admin_url() . 'admin.php?page=solea-show-event_' . $event->id
					);
	}

	return $return;
}
