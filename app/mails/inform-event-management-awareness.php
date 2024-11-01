<?php
/**
 * File: inform-event-management-awareness.php
 *
 * @since 2024-10-11
 * @license GPL-3.0-or-later
 *
 * @package Solea/Mails/
 */

use Solea\App\models\Event;


/**
 * Sends an email to inform management about event awareness.
 *
 * @param Event  $event The event object containing event details.
 * @param string $membermanagement_mail The email address of the responsible membership manager.
 *
 * @return string The formatted email content with event closure information and instructions for contacting the membership manager.
 */
function solea_inform_management_awareness_mail( Event $event, string $membermanagement_mail ): string {
	return '<h3>' . __( 'Hello,', 'solea' ) . '</h3><br /><br />' .
		wp_sprintf(
		/* translators: %s is event name */
			__( 'The event "%s" has just closed.', 'solea' ),
			$event->event_name
		) . '<br />' .
		wp_sprintf(
		/* translators: %s is event name */
			__( 'Please check out the list of adult participants and Contact the responsible membership manager via the email address %s to clarify whether all adult participants have submitted the extended police clearance certificate.', 'solea' ),
			$membermanagement_mail
		);
}
