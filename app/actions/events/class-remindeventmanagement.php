<?php
/**
 * File: class-remindeventmangement.php
 *
 * @since 2024-07-29
 * @license GPL-3.0-or-later
 *
 * @package Solea/Actions/Events/
 */

namespace Solea\App\Actions\Events;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\Libs\MailLibrary;

/**
 * Class RemindEventManagement
 *
 * Handles the task of reminding the event management about the event status and participant details.
 */
class RemindEventManagement {

	/**
	 * Executes the reminder notification process for the event management.
	 *
	 * @param Event $event The event object containing details about the event.
	 */
	public static function execute( Event $event ) {
		$mail = new MailLibrary();
		$mail->set_recipients( $event->get_organiser_mails( true ) );
		$mail->set_message( solea_inform_management_mail( $event ) );
		$mail->set_subject(
			'[solea] ' . wp_sprintf(
			/* Translators: %s is the name of the event */
				__( 'Event "%s" is closed - Please check participants', 'solea' ),
				$event->event_name
			)
		);
		$mail->send();
	}
}
