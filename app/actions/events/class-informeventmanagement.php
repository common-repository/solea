<?php
/**
 * File: class-informeventmanagement.php
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
use Solea\App\models\LocalGroup;
use Solea\Libs\MailLibrary;
/**
 * Class InformEventManagement
 *
 * Handles the task of informing the event management and local groups about the event status and participant details.
 */
class InformEventManagement {

	/**
	 * Executes the notification process for the event management and local groups.
	 *
	 * @param Event $event The event object containing details about the event.
	 */
	public static function execute( Event $event ) {
		$now = new \DateTime();

		$registration_end = \DateTime::createFromFormat( 'Y-m-d', $event->registration_end );
		$compare          = $now->getTimestamp() - $registration_end->getTimestamp();

		$mail = new MailLibrary();
		$mail->set_recipients( $event->get_organiser_mails( true ) );
		$mail->set_message( solea_inform_management_mail( $event ) );

		if ( 0 > $compare ) {
			$mail->set_subject(
				'[solea] ' . wp_sprintf(
				/* Translators: %s is the name of the event */
					__( 'Participation report for  %s - Please check participants', 'solea' ),
					$event->event_name
				)
			);
		} else {
			$mail->set_subject(
				'[solea] ' . wp_sprintf(
				/* Translators: %s is the name of the event */
					__( 'Event %s is closed - Please check participants', 'solea' ),
					$event->event_name
				)
			);
		}

		$mail->send();
		foreach ( $event->get_participants_by_group() as $group_id => $participants ) {
			$group      = LocalGroup::where( 'id', $group_id )->first();
			$group_mail = new MailLibrary();
			$group_mail->add_recipient( $group->email );
			$group_mail->set_subject(
				'[solea] ' . wp_sprintf(
				/* Translators: %s is the name of the event */
					__( 'Participation report for  %s - Please check participants', 'solea' ),
					$event->event_name
				)
			);
			$group_mail->set_message( solea_inform_localgroup_mail( $event, $participants ) );
			$group_mail->set_sender( $event->event_email );
			$group_mail->send();
		}
	}
}
