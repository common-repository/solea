<?php
/**
 * File: registration-successfull-participant-mail.php
 *
 * @since 2024-07-24
 * @license GPL-3.0-or-later
 *
 * @package Solea/Mails/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;


/**
 * Generates a confirmation email for a successful event registration.
 *
 * This function creates an HTML email message confirming the participant's registration for the event,
 * including details about the event, arrival, departure, eating habit, and payment instructions if applicable.
 *
 * @param string $nicename The participant's name.
 * @param Event  $event The event the participant registered for.
 * @param float  $amount The amount to be paid (if applicable).
 * @param string $payment_purpose The purpose of the payment.
 * @param string $arrival The participant's arrival date.
 * @param string $departure The participant's departure date.
 * @param string $eating_habit The participant's eating habit.
 * @param string $registration_end The registration deadline.
 *
 * @return string The formatted HTML message for the email.
 */
function solea_get_registration_successfull_for_participant_mail(
	string $nicename,
	Event $event,
	float $amount,
	string $payment_purpose,
	string $arrival,
	string $departure,
	string $eating_habit,
	string $registration_end
): string {

		/* Translators: %s Participant name */
	$return = ' <h3>' . wp_sprintf( esc_html__( 'Hello %s,', 'solea' ), $nicename ) . '</h3><br /><br />
        <p>' . wp_sprintf(
		/* Translators: %s Event name */
		esc_html__( 'Your registration for the event "%s" was successful. We have recorded the following data:', 'solea' ),
		$event->event_name
	) . '
        <table>
            <tr><td>' . esc_html__( 'Arrival', 'solea' ) . ':</td><td>' . esc_html( $arrival ) . '</td></tr>
            <tr><td>' . esc_html__( 'Departure', 'solea' ) . ':</td><td>' . esc_html( $departure ) . '</td></tr>
            <tr><td>' . esc_html__( 'Eating habit', 'solea' ) . ':</td><td>' . esc_html( $eating_habit ) . '</td></tr>
        </table>
        
        ' . esc_html__( 'If this is not correct, or if you have urgent questions, please contact', 'solea' ) . ' 
        <a href="mailto:' . esc_html( $event->event_email ) . '">' . esc_html__( 'The event management crew', 'solea' ) . '</a></p>';

	if ( $event->payment_direct && 0 < $amount ) {
		$return .= '
            <p>
                ' . esc_html__( 'To complete your registration, please transfer the registration amount immediately to the following bank account:', 'solea' ) . '
            <table>
                <tr><td>' . esc_html__( 'Account owner', 'solea' ) . ':</td><td>' . esc_html( $event->account_owner ) . '</td>
                    <td rowspan="4">';

		$amount = str_replace( ',', '.', solea_format_amount( $amount, '' ) );

		$qrcode  = admin_url(
			'admin-ajax.php?action=solea_show_ajax&method=generate-payment-link&amount=' . $amount .
			'&recipient=' . $event->account_owner .
			'&iban=' . $event->account_iban .
			'&subject=' . $payment_purpose
		);
		$return .= '
                        <img style="padding-left: 20px; padding-bottom: 0; width: 150px; height: 150px;" src="' . esc_url( $qrcode ) . '" />
                        <p style="font-size: 8pt; width: 100%; text-align: center; margin-top: -20px;">
                            ' . esc_html__( 'Giro-Code', 'solea' ) . '</p>
                    </td>
                </tr>
        
                <tr><td>' . esc_html__( 'IBAN', 'solea' ) . ':</td><td>' . esc_html( $event->account_iban ) . '</td></tr>
                <tr><td>' . esc_html__( 'Purpose', 'solea' ) . ':</td><td>' . esc_html( $payment_purpose ) . '</td></tr>
                <tr style="font-weight: bold;"><td>' . esc_html__( 'Total amount', 'solea' ) . ':</td><td>' . esc_html( solea_format_amount( $amount ) ) . '</td></tr>
            </table><br /><br />';
			/* Translators: %s registration end day */
			$return .= wp_sprintf( esc_html__( 'Please note that your registration may be cancelled if payment is not received in the specified account by %s.', 'solea' ), $registration_end ) . '<br />
            ' . esc_html__( 'If payment is not possible or only partially possible within this period, please contact the event management.', 'solea' ) . '
        
            </p>';
	} else {
		$return .= '
            <p>
                ' . esc_html__( 'You do not have to pay the registration fee. This is the case if participation is supported, billing is done through your local group, or there are other decisions.', 'solea' ) . '<br />
                ' . esc_html__( 'Your registration is complete now.', 'solea' ) . '</p>';
	}

	return $return;
}
