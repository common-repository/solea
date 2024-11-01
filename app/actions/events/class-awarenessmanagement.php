<?php
/**
 * File: class-awarenessmanagement.php
 *
 * @since 2024-10-11
 * @license GPL-3.0-or-later
 *
 * @package Solea/Actions/Events
 */

namespace solea\App\Actions\Events;

use Solea\App\models\Event;
use Solea\Libs\MailLibrary;

/**
 * Class AwarenessManagement
 */
class AwarenessManagement {

	/**
	 * Retrieves an instance of AwarenessManagement based on the provided Event object.
	 *
	 * @param Event $event The Event object for which the AwarenessManagement instance is requested.
	 *
	 * @return AwarenessManagement An instance of AwarenessManagement initialized with the provided Event object.
	 */
	public static function get_instance( Event $event ): AwarenessManagement {
		return new AwarenessManagement( $event );
	}

	/**
	 * Declares the variable $member_management_mail without any initial value assigned to it.
	 *
	 * @var $member_management_mail Contains recipients for member management.
	 */
	private string $member_management_mail = '';

	/**
	 * Declares an empty array for event management.
	 *
	 * @var $event_management Contains recipients for event management.
	 */
	private array $event_management = array();

	/**
	 * Variable representing the event that occurred.
	 *
	 * @var $event Contains the event.
	 */
	private Event $event;

	/**
	 * Variable to denote whether sending is required or not.
	 *
	 * @var $send_required Contains if the awareness check needs to be done.
	 */
	private bool $send_required = false;

	/**
	 * Constructs a new instance of the class.
	 *
	 * @param Event $event The event object for which the emails are being sent.
	 *
	 * @return void
	 */
	public function __construct( Event $event ) {
		$this->member_management_mail = get_option( 'solea_central_member_management', '' ); // @Todo: DFefault value
		$this->event_management       = $event->get_organiser_mails();
		$this->send_required          = false;
		$this->event                  = $event;
		$local_groups                 = array();
		foreach ( $event->get_all_participants() as $participant ) {
			if ( solea_is_fullaged( $participant->geburtsdatum ) ) {
				continue;
			}

			if ( ! in_array( $participant->get_local_group_membermanagement_mail(), $local_groups, true ) ) {
				$local_groups[] = $participant->get_local_group_membermanagement_mail();
			}
			$this->send_required = true;
		}

		if ( count( $local_groups ) === 1 ) {
			$this->member_management_mail = $local_groups[0];
		}
	}

	/**
	 * Sends sign-up confirmation emails to event participants and management.
	 *
	 * @return bool True if the emails were sent successfully, false otherwise.
	 */
	public function send_signup_mails(): bool {
		if ( ! $this->send_required ) {
			return false;
		}

		$membermanagement_mail_text = solea_inform_central_membermanagement_awareness_mail( $this->event, $this->event->event_email );
		$eventmanagement_mail_text  = solea_inform_management_awareness_mail( $this->event, $this->member_management_mail );

		$mail_eventmanagement = new MailLibrary();
		$mail_eventmanagement->set_subject(
			'[solea] - ' . wp_sprintf(
				/* translators: %s is name of the event */
				__( 'Check fullaged participants for event %s', 'solea' ),
				$this->event->event_name
			)
		);

		$mail_eventmanagement->set_recipients( $this->event_management );
		$mail_eventmanagement->set_message( $eventmanagement_mail_text );
		$mail_eventmanagement->send();

		$mail_membermanagement = new MailLibrary();
		$mail_membermanagement->set_message( $membermanagement_mail_text );
		$mail_membermanagement->set_subject(
			'[solea] - ' . wp_sprintf(
				/* translators: %s is name of the event */
				__( 'Check fullaged participants for event %s', 'solea' ),
				$this->event->event_name
			)
		);

		$mail_eventmanagement->add_recipient( $this->member_management_mail );
		$mail_eventmanagement->send();
		return true;
	}
}
