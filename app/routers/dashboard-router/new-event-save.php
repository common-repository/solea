<?php
/**
 * File: new-event-save.php
 *
 * @since 2024-07-22
 * @license GPL-3.0-or-later
 *
 * @package solea/Routers/Partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use solea\App\Actions\Events\CreateEvent;


if ( ! isset( $_SESSION['solea_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['solea_nonce'] ) ) ) ) {
	wp_die( 'Invalid Router call' );
}

if (
	! isset( $_REQUEST['registration_mode'] ) ||
	! isset( $_REQUEST['event_name'] ) ||
	! isset( $_REQUEST['event_email'] ) ||
	! isset( $_REQUEST['event_begin'] ) ||
	! isset( $_REQUEST['event_end'] ) ||
	! isset( $_REQUEST['registration_end'] ) ||
	! isset( $_REQUEST['regular_amount'] ) ||
	! isset( $_REQUEST['last_minute_begin_group'] ) ||
	! isset( $_REQUEST['amount_teamer'] ) ||
	! isset( $_REQUEST['description_teamer'] ) ||
	! isset( $_REQUEST['amount_volunteer'] ) ||
	! isset( $_REQUEST['description_volunteers'] ) ||
	! isset( $_REQUEST['amount_participant'] ) ||
	! isset( $_REQUEST['description_participants'] ) ||
	! isset( $_REQUEST['amount_others'] ) ||
	! isset( $_REQUEST['age_alcoholic'] ) ||
	! isset( $_REQUEST['description_others'] ) ||
	! isset( $_REQUEST['amount_online'] ) ||
	! isset( $_REQUEST['amount_maximum'] ) ||
	! isset( $_POST['all_groups'] )
) {
	wp_die( 'Missing parameters for new Event' );
}

if ( ! isset( $_REQUEST['group'] ) ) {
	wp_die( esc_html__( 'At least one participating group required', 'solea' ) );
}

$billing_end         = null;
$account_owner       = null;
$account_iban        = null;
$payment_direct      = false;
$contributing_groups = '';

$participating_groups = array();
$all_groups           = explode( ',', sanitize_text_field( wp_unslash( $_POST['all_groups'] ) ) );
foreach ( $all_groups as $current_group ) {
	if ( isset( $_POST['group'][ $current_group ] ) ) {
		$participating_groups[] = $current_group;
	}
}


$contributing_groups = implode( ',', $participating_groups );
$wekly_report        = isset( $_REQUEST['weekly_report'] );
$enable_all_eating   = isset( $_REQUEST['enable_all_eating'] );
$registration_mode   = sanitize_text_field( wp_unslash( $_REQUEST['registration_mode'] ) );
$event_name          = sanitize_text_field( wp_unslash( $_REQUEST['event_name'] ) );
$event_email         = sanitize_text_field( wp_unslash( $_REQUEST['event_email'] ) );
$event_begin         = sanitize_text_field( wp_unslash( $_REQUEST['event_begin'] ) );
$event_end           = sanitize_text_field( wp_unslash( $_REQUEST['event_end'] ) );
$registration_end    = sanitize_text_field( wp_unslash( $_REQUEST['registration_end'] ) );
$event_end_date      = \DateTime::createFromFormat( 'Y-m-d', $event_end );
$age_alcoholics      = (int) sanitize_text_field( wp_unslash( $_REQUEST['age_alcoholic'] ) );

$billing_end = $event_end_date->add( new DateInterval( 'P4W' ) )->format( 'Y-m-d' );

if ( isset( $_REQUEST['payment_direct'] ) && isset( $_REQUEST['account_owner'] ) && isset( $_REQUEST['account_iban'] ) ) {
	$payment_direct = true;
	$account_owner  = sanitize_text_field( wp_unslash( $_REQUEST['account_owner'] ) );
	$account_iban   = sanitize_text_field( wp_unslash( $_REQUEST['account_iban'] ) );
}

if ( 'solidarity' === $registration_mode ) {
	$regular_amount = floatval( sanitize_text_field( wp_unslash( $_REQUEST['regular_amount'] ) ) );

	if ( ! isset( $_REQUEST['reduced_amount'] ) ||
		! isset( $_REQUEST['solidary_amount'] ) ||
	! isset( $_REQUEST['lastminute_amount'] ) ||
	! isset( $_REQUEST['last_minute_begin'] ) ) {
		wp_die( 'Missing parameters' );
	}

	$text_solidarity_amount = sanitize_text_field( wp_unslash( $_REQUEST['solidary_amount'] ) );
	$text_reduced_amount    = sanitize_text_field( wp_unslash( $_REQUEST['reduced_amount'] ) );

	$regular_amount       = floatval( sanitize_text_field( str_replace( ',', '.', sanitize_text_field( wp_unslash( $_REQUEST['regular_amount'] ) ) ) ) );
	$solidarity_amount    = '' !== $text_solidarity_amount ? floatval( str_replace( ',', '.', $text_solidarity_amount ) ) : null;
	$reduced_amount       = '' !== $text_solidarity_amount ? floatval( str_replace( ',', '.', $text_reduced_amount ) ) : null;
	$last_minute_increase = (int) sanitize_text_field( wp_unslash( $_REQUEST['lastminute_amount'] ) );
	$last_minute_date     = sanitize_text_field( wp_unslash( $_REQUEST['last_minute_begin'] ) );

	CreateEvent::create_solidarity_event(
		$event_name,
		$event_email,
		$event_begin,
		$event_end,
		$registration_end,
		$payment_direct,
		$wekly_report,
		$enable_all_eating,
		$age_alcoholics,
		$regular_amount,
		$last_minute_increase,
		$last_minute_date,
		$contributing_groups,
		$solidarity_amount,
		$reduced_amount,
		$account_owner,
		$account_iban,
		$billing_end
	);
} else {
	if ( ! isset( $_REQUEST['lastminute_amount_group'] ) ) {
		wp_die( 'Missing parameters' );
	}
	$last_minute_increase = (int) sanitize_text_field( wp_unslash( $_REQUEST['lastminute_amount_group'] ) );
	$last_minute_date     = sanitize_text_field( wp_unslash( $_REQUEST['last_minute_begin_group'] ) );

	$text_teamer_amount      = sanitize_text_field( wp_unslash( $_REQUEST['amount_teamer'] ) );
	$text_volunteer_amount   = sanitize_text_field( wp_unslash( $_REQUEST['amount_volunteer'] ) );
	$text_participant_amount = sanitize_text_field( wp_unslash( $_REQUEST['amount_participant'] ) );
	$text_other_amount       = sanitize_text_field( wp_unslash( $_REQUEST['amount_others'] ) );
	$text_online_amount      = sanitize_text_field( wp_unslash( $_REQUEST['amount_online'] ) );

	$amount_maximum          = floatval( str_replace( ',', '.', sanitize_text_field( wp_unslash( $_REQUEST['amount_maximum'] ) ) ) );
	$description_teamer      = sanitize_text_field( wp_unslash( $_REQUEST['description_teamer'] ) );
	$description_volunteer   = sanitize_text_field( wp_unslash( $_REQUEST['description_volunteers'] ) );
	$description_participant = sanitize_text_field( wp_unslash( $_REQUEST['description_participants'] ) );
	$description_others      = sanitize_text_field( wp_unslash( $_REQUEST['description_others'] ) );

	$teamer_amount      = '' !== $text_teamer_amount ? floatval( str_replace( ',', '.', $text_teamer_amount ) ) : null;
	$volunteer_amount   = '' !== $text_volunteer_amount ? floatval( str_replace( ',', '.', $text_volunteer_amount ) ) : null;
	$participant_amount = '' !== $text_participant_amount ? floatval( str_replace( ',', '.', $text_participant_amount ) ) : null;
	$other_amount       = '' !== $text_other_amount ? floatval( str_replace( ',', '.', $text_other_amount ) ) : null;
	$online_amount      = '' !== $text_online_amount ? floatval( str_replace( ',', '.', $text_online_amount ) ) : null;

	CreateEvent::create_classic_event(
		$event_name,
		$event_email,
		$event_begin,
		$event_end,
		$registration_end,
		$payment_direct,
		$wekly_report,
		$enable_all_eating,
		$age_alcoholics,
		$teamer_amount,
		$volunteer_amount,
		$participant_amount,
		$other_amount,
		$online_amount,
		$amount_maximum,
		$description_teamer,
		$description_volunteer,
		$description_participant,
		$description_others,
		$last_minute_increase,
		$last_minute_date,
		$contributing_groups,
		$account_owner,
		$account_iban,
		$billing_end
	);
}

solea_show_message( __( 'The event was created', 'solea' ) );
