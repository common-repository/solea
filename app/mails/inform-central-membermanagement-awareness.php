<?php
/**
 * File: inform-central-membermanagement-awareness.php
 *
 * @since 2024-10-11
 * @license GPL-3.0-or-later
 *
 * @package Solea/Mails/
 */

use Solea\App\models\Event;

/**
 * Sends an awareness email to central member management regarding a closed event.
 *
 * @param Event  $event The event object containing event information.
 * @param string $eventmanagement_mail The email address of the event management.
 *
 * @return string The formatted email content providing instructions for contacting event management
 * and checking participant submissions.
 */
function solea_inform_central_membermanagement_awareness_mail( Event $event, string $eventmanagement_mail ): string {
	return '<h3>' . __( 'Hello,', 'solea' ) . '</h3><br /><br />' .
	wp_sprintf(
		/* translators: %s is event name */
		__( 'The event "%s" has just closed.', 'solea' ),
		$event->event_name
	) . '<br />' .
	wp_sprintf(
		/* translators: %s is event name */
		__( 'Please contact the event management via the email address %s to get a list of all adult participants and check if they have submitted the extended police clearance certificate.', 'solea' ),
		$eventmanagement_mail
	);
}
