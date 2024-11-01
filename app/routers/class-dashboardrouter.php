<?php
/**
 * File: class-dashboardrouter.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package solea/Routers
 */

namespace Solea\App\Routers;

use solea\App\Actions\Events\CreateEvent;
use solea\App\Actions\Events\CreateSolidarityEvent;
use solea\App\Actions\Participants\SendNewParticipantMail;
use solea\App\Actions\Participants\SendUnregisterMail;
use solea\App\Controllers\EventParticipations\DisplayEventParticipants;
use solea\App\Controllers\EventParticipations\EditParticipant;
use solea\App\Controllers\Events\ListAvailableEvents;
use solea\App\Controllers\Events\NewEvent;
use solea\App\Controllers\Events\Overview;
use solea\App\Controllers\Mails\MailCompose;
use Solea\App\Controllers\profile\ExtendProfile;
use Solea\App\Controllers\profile\UpdateProfile;
use solea\App\Controllers\settings\SettingsForm;
use Solea\App\models\Event;
use Solea\App\models\Participant;
use Solea\Libs\MailLibrary;

if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}

/**
 * Executes the given action based on the requested page.
 */
class DashboardRouter {
	/**
	 * Executes the given action based on the requested page.
	 *
	 * @return void
	 */
	public static function execute() {
		$plugin_data = get_plugin_data( SOLEA_PLUGIN_STARTUP_FILE );

		if ( ! isset( $_SESSION['solea_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['solea_nonce'] ) ) ) ) {
			wp_die( 'Invalid Router call' );
		}

		if ( ! isset( $_REQUEST['page'] ) ) {
			wp_die( 'No Slug given' );
		}

		$mareike_installed = is_plugin_active( 'mareike/mareike.php' );

		$page     = sanitize_key( wp_unslash( $_REQUEST['page'] ) );
		$slug     = $page;
		$event_id = null;

		if ( str_contains( $page, '_' ) ) {
			$tmp_data = explode( '_', $page );
			$slug     = $tmp_data[0];
			$event_id = (int) $tmp_data[1];
		}

		switch ( $slug ) {
			case 'solea-list-events':
				Overview::execute();
				break;

			case 'solea-profile':
				if ( isset( $_POST['sent'] ) ) {
					if (
							! isset( $_POST['first_name'] ) ||
							! isset( $_POST['last_name'] ) ||
							! isset( $_POST['email'] ) ||
							! isset( $_POST['telephone'] ) ||
							! isset( $_POST['street'] ) ||
							! isset( $_POST['number'] ) ||
							! isset( $_POST['city'] ) ||
							! isset( $_POST['zip'] ) ||
							! isset( $_POST['allergies'] ) ||
							! isset( $_POST['localgroup'] ) ||
							! isset( $_POST['birthday'] ) ||
							! isset( $_POST['nickname'] ) ||
							! isset( $_POST['intolerances'] ) ||
							! isset( $_POST['medication'] )
						) {
						wp_die( 'Missing form arguments' );
					}

						$firstname = sanitize_text_field( wp_unslash( $_POST['first_name'] ) );
						$lastname  = sanitize_text_field( wp_unslash( $_POST['last_name'] ) );
						$email     = sanitize_text_field( wp_unslash( $_POST['email'] ) );
					$telephone     = sanitize_text_field( wp_unslash( $_POST['telephone'] ) );
					$street        = sanitize_text_field( wp_unslash( $_POST['street'] ) );
					$housenumber   = sanitize_text_field( wp_unslash( $_POST['number'] ) );
					$city          = sanitize_text_field( wp_unslash( $_POST['city'] ) );
					$zip           = sanitize_text_field( wp_unslash( $_POST['zip'] ) );
					$allergies     = sanitize_text_field( wp_unslash( $_POST['allergies'] ) );
					$intolerances  = sanitize_text_field( wp_unslash( $_POST['intolerances'] ) );
					$medication    = sanitize_text_field( wp_unslash( $_POST['medication'] ) );
					$localgroup    = (int) sanitize_key( wp_unslash( $_POST['localgroup'] ) );
					$birthday      = sanitize_text_field( wp_unslash( $_POST['birthday'] ) );
					$nickname      = sanitize_text_field( wp_unslash( $_POST['nickname'] ) );
					UpdateProfile::execute( $firstname, $lastname, $email, $telephone, $street, $housenumber, $zip, $city, $allergies, $intolerances, $medication, $localgroup, $birthday, $nickname );
					return;
				}

				ExtendProfile::execute();
				return;

			case 'solea-signupp-for-event':
				ListAvailableEvents::execute_from_public();
				return;

			case 'solea-show-event':
				$active_tab     = 'tab1';
				$action         = null;
				$participant_id = 0;

				if ( isset( $_REQUEST['tab'] ) ) {
					$active_tab = sanitize_key( wp_unslash( $_REQUEST['tab'] ) );
				}

				if ( isset( $_REQUEST['participant-id'] ) ) {
					$participant_id = (int) sanitize_key( ( wp_unslash( $_REQUEST['participant-id'] ) ) );
				}

				if ( isset( $_REQUEST['action'] ) ) {
					$action = sanitize_key( wp_unslash( $_REQUEST['action'] ) );
					switch ( $action ) {
						case 'update-event':
							if ( ! isset( $_POST['event_name'] ) ||
								! isset( $_POST['event_email'] ) ||
								! isset( $_POST['registration_end'] ) ||
								! isset( $_POST['event_url'] ) ||
								! isset( $_POST['group'] ) ||
								! isset( $_POST['all_groups'] )
							) {
								wp_die( 'Missing form params' );
							}
							$event                    = Event::get_with_permission_check( $event_id );
							$event->event_name        = sanitize_text_field( wp_unslash( $_POST['event_name'] ) );
							$event->event_email       = sanitize_email( wp_unslash( $_POST['event_email'] ) );
							$event->registration_end  = sanitize_text_field( wp_unslash( $_POST['registration_end'] ) );
							$event->signup_allowed    = isset( $_POST['signup_allowed'] );
							$event->weekly_report     = isset( $_POST['weekly_report'] );
							$event->enable_all_eating = isset( $_POST['enable_all_eating'] );
							$event->event_url         = sanitize_url( wp_unslash( $_POST['event_url'] ) );

							$participating_groups = array();
							$all_groups           = explode( ',', sanitize_text_field( wp_unslash( $_POST['all_groups'] ) ) );
							foreach ( $all_groups as $current_group ) {
								if ( isset( $_POST['group'][ $current_group ] ) ) {
									$participating_groups[] = $current_group;
								}
							}

							$event->contributing_groups = implode( ',', $participating_groups );
							$event->save();

							solea_show_message( __( 'The event was updated', 'solea' ) );
							break;

						case 'send-mail':
							if ( ! isset( $_POST['sendmail'] ) ||
							! isset( $_POST['recipient'] ) ||
							! isset( $_POST['subject'] ) ||
							! isset( $_POST['mail-text'] )
							) {
								wp_die( 'Invalid system call' );
							}

							$event      = Event::get_with_permission_check( $event_id );
							$recipients = sanitize_text_field( wp_unslash( $_POST['recipient'] ) );
							$subject    = sanitize_text_field( wp_unslash( $_POST['subject'] ) );
							$mailtext   = wp_kses_post( wp_unslash( $_POST['mail-text'] ), );

							$mail = new MailLibrary();
							$mail->set_subject( $subject );
							$mail->set_message( $mailtext );
							$mail->set_sender( $event->event_email );
							$mail->set_recipients_from_text( $recipients );
							$protocol = $mail->send();
							if ( isset( $_POST['send_copy'] ) ) {
								$mail_management = new MailLibrary();
								$mail_management->set_subject( __( 'Mail send report', 'solea' ) );
								$mail_management->set_message(
									__( 'The following message was sent to: ', 'solea' ) . '<br />' .
														implode( '<br />', $protocol['sent'] ) . '<br /><br />' .
									__( 'Errors occured sending to the following addresses: ', 'solea' ) . '<br />' .
									implode( '<br />', $protocol['failed'] ) . ':' .
									'<hr />' . $mailtext
								);
								$mail_management->set_recipients( $event->get_organiser_mails() );
								$mail_management->send();
							}

							if ( 0 < count( $protocol['sent'] ) ) {
								solea_show_message( __( 'Successfully sent messages', 'solea' ) . ': ' . count( $protocol['sent'] ) . ' ' . __( 'Mails', 'solea' ) );
							}

							if ( 0 < count( $protocol['failed'] ) ) {
								solea_show_message( __( 'Failed to sent messages', 'solea' ) . ': ' . count( $protocol['failed'] ) . ' ' . __( 'Mails', 'solea' ), false );
							}

							break;

						case 'send-mail-to-group':
							if ( ! isset( $_REQUEST['group-type'] ) || ! isset( $_REQUEST['group'] ) ) {
								wp_die( 'Missing action parameters' );
							}

							$group_type = sanitize_key( wp_unslash( $_REQUEST['group-type'] ) );
							$event      = Event::get_with_permission_check( $event_id );
							$group      = sanitize_key( wp_unslash( $_REQUEST['group'] ) );

							switch ( $group_type ) {
								case 'participation_group':
									MailCompose::compose_by_participation_group( $event, $group, $page, $active_tab );
									return;

								case 'localgroup':
									MailCompose::compose_by_local_group( $event, (int) $group, $page, $active_tab );
									return;

								case 'all':
									MailCompose::compose_by_event( $event, $page, $active_tab );
									return;

								case 'singlemail':
									$participant = Participant::get_with_permission_check( (int) $group );
									MailCompose::compose_for_participant( $participant, $page, $active_tab );
									return;
							}

							break;

						case 'resignon':
							$participant                  = Participant::get_with_permission_check( $participant_id );
							$participant->date_unregister = null;
							$participant->save();
							SendNewParticipantMail::execute( $participant );
							solea_show_message(
								__( 'The participant was re-registered.', 'solea' ) . PHP_EOL .
												__( 'The participant was informed by email.', 'solea' )
							);
							break;

						case 'update-payment':
							if ( ! isset( $_POST['amount_paid'] ) ) {
								wp_die( 'Invalid Router call' );
							}

							$participant = Participant::get_with_permission_check( $participant_id );
							$event       = Event::get_with_permission_check( $participant->event_id );

							$participant->amount_paid = floatval( str_replace( ',', '.', sanitize_text_field( wp_unslash( $_POST['amount_paid'] ) ) ) );
							$participant->save();
							$mail = new MailLibrary();
							$mail->set_message( solea_payment_successfull_mail( $participant ) );
							$mail->set_sender( $event->event_email );
							$mail->set_subject( '[solea] - ' . __( 'Your registration confirmation for event', 'solea' ) . ' "' . $event->event_name . '"' );
							$mail->add_recipient( $participant->email_1 );
							if ( null !== $participant->email_2 ) {
								$mail->add_recipient( $participant->email_2 );

							}
							$mail->send();
							solea_show_message(
								__( 'The amount was registered.', 'solea' ) . PHP_EOL .
												__( 'The participant was informed by email.', 'solea' )
							);
							break;

						case 'edit-participant':
							$participant = Participant::get_with_permission_check( $participant_id );

							if ( isset( $_POST['save'] ) ) {
								require SOLEA_PLUGIN_DIR . 'app/routers/dashboard-router/update-participant-save.php';
								solea_show_message( __( 'The participant data were updated', 'solea' ) );
							}

							EditParticipant::execute( $page, $active_tab, $participant );
							return;

						case 'signoff-participant':
							if ( ! isset( $_POST['date_unregister'] ) ) {
								wp_die( 'Invalid Router call' );
							}

							$participant                  = Participant::get_with_permission_check( $participant_id );
							$participant->date_unregister = sanitize_text_field( wp_unslash( $_POST['date_unregister'] ) );

							$participant->save();
							$event = Event::get_with_permission_check( $participant->event_id );

							$mail = new MailLibrary();
							$mail->set_message( solea_participant_inform_signedoff_mail( $participant, $event ) );
							$mail->set_sender( $event->event_email );
							$mail->set_subject( '[solea] - ' . __( 'Your registration confirmation for event', 'solea' ) . ' "' . $event->event_name . '"' );
							$mail->add_recipient( $participant->email_1 );
							if ( null !== $participant->email_2 ) {
								$mail->add_recipient( $participant->email_2 );

							}
							$mail->send();

							solea_show_message(
								__( 'The participant was deregistered.', 'solea' ) . PHP_EOL .
												__( 'The participant was informed by email.', 'solea' )
							);
					}
				}

				DisplayEventParticipants::execute( $page, $active_tab, $event_id );
				return;

			case 'solea-localgroups':
				$mode     = null;
				$group_id = null;

				if ( isset( $_REQUEST['mode'] ) ) {
					$mode = sanitize_key( wp_unslash( $_REQUEST['mode'] ) );
				}

				if ( isset( $_REQUEST['group-id'] ) ) {
					$group_id = (int) sanitize_key( wp_unslash( $_REQUEST['group-id'] ) );
				}

				if ( isset( $_POST['save-option'] ) ) {
					$save_option = sanitize_key( wp_unslash( $_POST['save-option'] ) );
					switch ( $save_option ) {
						case 'new-group':
							require SOLEA_PLUGIN_DIR . 'app/routers/dashboard-router/new-group-save.php';
							break;
						case 'update-group':
							require SOLEA_PLUGIN_DIR . 'app/routers/dashboard-router/update-group-save.php';
							break;
					}
				}

				SettingsForm::print_local_group_page( $slug, $mode, $group_id );
				return;

			case 'solea-settings':
				$mode     = null;
				$group_id = null;

				if ( isset( $_REQUEST['mode'] ) ) {
					$mode = sanitize_key( wp_unslash( $_REQUEST['mode'] ) );
				}

				if ( isset( $_REQUEST['group-id'] ) ) {
					$group_id = (int) sanitize_key( wp_unslash( $_REQUEST['group-id'] ) );
				}

				if ( isset( $_POST['save-option'] ) ) {
					$save_option = sanitize_key( wp_unslash( $_POST['save-option'] ) );
					require SOLEA_PLUGIN_DIR . 'app/routers/dashboard-router/settings-save.php';
				}

				SettingsForm::print_settings_page( $slug );
				return;

			case 'solea-add-event':
				if ( isset( $_REQUEST['create'] ) ) {
					require SOLEA_PLUGIN_DIR . 'app/routers/dashboard-router/new-event-save.php';
				}

				NewEvent::print_form( $slug, $mareike_installed );
				return;
		}
	}
}
