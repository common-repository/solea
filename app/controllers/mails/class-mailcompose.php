<?php
/**
 * File: class-mailcompose.php
 *
 * @since 2024-07-27
 * @license GPL-3.0-or-later
 *
 * @package Solea/Controllers/Mails/
 */

namespace solea\App\Controllers\Mails;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\models\Participant;

/**
 * Class MailCompose
 *
 * Provides functionality to compose email lists for various types of recipients based on their participation group,
 * local group, individual participant, or event. It also includes a method to print the email composition form.
 */
class MailCompose {

	/**
	 * Composes email recipients based on participation group.
	 *
	 * This method gathers email addresses of participants in a specified participation group and passes them to
	 * the `print_mail_form` method for composing the email.
	 *
	 * @param Event  $event The event object containing participant information.
	 * @param string $groupname The name of the participation group for which to compose the email.
	 * @param string $slug A slug used for identifying the specific form or email type.
	 * @param string $active_tab Indicates the active tab or section in the form.
	 *
	 * @return void
	 */
	public static function compose_by_participation_group( Event $event, string $groupname, string $slug, string $active_tab ) {
		$participants = $event->get_participants_by_participation();
		$recipients   = array();
		foreach ( $participants[ $groupname ] as $participant ) {
			if ( '' !== $participant->email_1 && ! in_array( $participant->email_1, $recipients, true ) ) {
				$recipients[] = $participant->email_1;
			}

			if ( '' !== $participant->email_2 && ! in_array( $participant->email_2, $recipients, true ) ) {
				$recipients[] = $participant->email_2;
			}
		}

		self::print_mail_form( $recipients, $slug, $active_tab );
	}

	/**
	 * Composes email recipients based on local group.
	 *
	 * This method gathers email addresses of participants in a specified local group and passes them to the
	 * `print_mail_form` method for composing the email.
	 *
	 * @param Event  $event The event object containing participant information.
	 * @param int    $group_id The ID of the local group for which to compose the email.
	 * @param string $slug A slug used for identifying the specific form or email type.
	 * @param string $active_tab Indicates the active tab or section in the form.
	 *
	 * @return void
	 */
	public static function compose_by_local_group( Event $event, int $group_id, string $slug, string $active_tab ) {
		$participants = $event->get_participants_by_group();
		$recipients   = array();
		foreach ( $participants[ $group_id ] as $participant ) {
			if ( '' !== $participant->email_1 && ! in_array( $participant->email_1, $recipients, true ) ) {
				$recipients[] = $participant->email_1;
			}

			if ( '' !== $participant->email_2 && ! in_array( $participant->email_2, $recipients, true ) ) {
				$recipients[] = $participant->email_2;
			}
		}

		self::print_mail_form( $recipients, $slug, $active_tab );
	}

	/**
	 * Composes email recipients for a specific participant.
	 *
	 * This method gathers email addresses of a single participant and passes them to the `print_mail_form` method
	 * for composing the email.
	 *
	 * @param Participant $participant The participant object containing email information.
	 * @param string      $slug A slug used for identifying the specific form or email type.
	 * @param string      $active_tab Indicates the active tab or section in the form.
	 *
	 * @return void
	 */
	public static function compose_for_participant( Participant $participant, string $slug, string $active_tab ) {
		$recipients = array();

		if ( '' !== $participant->email_1 && ! in_array( $participant->email_1, $recipients, true ) ) {
			$recipients[] = $participant->email_1;
		}

		if ( '' !== $participant->email_2 && ! in_array( $participant->email_2, $recipients, true ) ) {
			$recipients[] = $participant->email_2;
		}

		self::print_mail_form( $recipients, $slug, $active_tab );
	}

	/**
	 * Composes email recipients for all participants in an event.
	 *
	 * This method gathers email addresses of all participants in the event and passes them to the `print_mail_form`
	 * method for composing the email.
	 *
	 * @param Event  $event The event object containing participant information.
	 * @param string $slug A slug used for identifying the specific form or email type.
	 * @param string $active_tab Indicates the active tab or section in the form.
	 *
	 * @return void
	 */
	public static function compose_by_event( Event $event, string $slug, string $active_tab ) {
		$participants = $event->get_all_participants();
		$recipients   = array();
		foreach ( $participants as $participant ) {
			if ( '' !== $participant->email_1 && ! in_array( $participant->email_1, $recipients, true ) ) {
				$recipients[] = $participant->email_1;
			}

			if ( '' !== $participant->email_2 && ! in_array( $participant->email_2, $recipients, true ) ) {
				$recipients[] = $participant->email_2;
			}
		}

		self::print_mail_form( $recipients, $slug, $active_tab );
	}

	/**
	 * Prints the mail composition form.
	 *
	 * This method requires the template file for composing the email and passes the recipients, slug, and tab
	 * to the template.
	 *
	 * @param array  $recipients An array of email addresses to which the mail will be sent.
	 * @param string $slug A slug used for identifying the specific form or email type.
	 * @param string $tab Indicates the active tab or section in the form.
	 *
	 * @return void
	 */
	public static function print_mail_form( array $recipients, string $slug, string $tab ) {
		if ( count( $recipients ) === 0 || '' === $slug || '' === $tab ) {
			wp_die( 'An internale error occurred' );
		}
		require SOLEA_TEMPLATE_DIR . '/mails/compose.php';
	}
}
