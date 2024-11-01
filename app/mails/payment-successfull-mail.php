<?php
/**
 * File: payment-successfull-mail.php
 *
 * @since 2024-07-27
 * @license GPL-3.0-or-later
 *
 * @package Solea/Mails/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\models\Participant;


/**
 * Generates an email notification for a successful payment.
 *
 * This function creates an HTML email message to notify a participant that their payment has been received
 * and provides details about the payment status and any remaining balance.
 *
 * @param Participant $participant The participant who made the payment.
 *
 * @return string The formatted HTML message for the email.
 */
function solea_payment_successfull_mail( Participant $participant ): string {
	// Determine the nice name for the participant.
	$nicename = ! empty( $participant->nickname )
		? esc_html( $participant->nickname )
		: esc_html( $participant->firstname . ' ' . $participant->lastname );

	/* Translators: %s name of participant */
	$return = '<h3>' . wp_sprintf( __( 'Hello %s,', 'solea' ), $nicename ) . '</h3><br /><br />' .
				wp_sprintf(
					/* Translators: %s Total paid amount */
					__( 'We have received your payment. You have now paid %s.', 'solea' ),
					solea_format_amount( $participant->amount_paid )
				) . '<br /><br />';

	// Check if the payment is complete.
	if ( $participant->amount === $participant->amount_paid ) {
		$return .= __( 'All required payment is now complete, and you are fully registered for the event.', 'solea' );
	} else {
		// Get the event details.
		$event = Event::get_with_permission_check( $participant->event_id );

		// Add remaining balance and registration deadline information.
		$return .= wp_sprintf(
					/* Translators: %s Amojunt that is missing */
			__( 'Please note that an amount of %s is still missing.', 'solea' ),
			solea_format_amount( $participant->amount - $participant->amount_paid )
		) . '<br />' .
					wp_sprintf(
						/* Translators: %s registration end day */
						__( 'Your registration may be canceled if the remaining amount is not received by %s.', 'solea' ),
						\DateTime::createFromFormat( 'Y-m-d', $event->registration_end )->format( 'd.m.Y' )
					) . '<br />' .
					__( 'If full payment is not possible within this period, please contact the event management.', 'solea' );
	}

	return $return;
}
