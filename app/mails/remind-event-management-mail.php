<?php
/**
 * File: remind-event-management-mail.php
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

/**
 * Generates a reminder email for the event management.
 *
 * This function creates an HTML email message reminding the event management to check the payment status
 * of participants after the event registration has closed.
 *
 * @param Event $event The event for which the reminder is being sent.
 *
 * @return string The formatted HTML message for the email.
 */
function solea_remind_management_mail( Event $event ): string {
	return '<h3>' . __( 'Hello,', 'solea' ) . '</h3><br /><br />' .
			wp_sprintf(
			/* Translators: %1$s is the event name, %2$s the endday of registration. */
				__( 'The event "%1$s" was closed on %2$s. Please check now if every participant has paid the event contributions.', 'solea' ),
				$event->event_name,
				DateTime::createFromFormat( 'Y-m-d', $event->registration_end )->format( 'd.m.Y' )
			) .
			'<br /><br />' .
			wp_sprintf(
			/* Translators: %1$s ievent url, %2$s event url */
				__( 'You can check the participant list here: <a href="%1$s">%2$s</a>', 'solea' ),
				get_admin_url() . '/admin.php?page=solea-show-event_2',
				get_admin_url() . 'admin.php?page=solea-show-event_' . $event->id
			);
}
