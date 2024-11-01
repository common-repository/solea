<?php
/**
 * File: update-participant-save.php
 *
 * @since 2024-07-26
 * @license GPL-3.0-or-later
 *
 * @package solea/Routers/Partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $_SESSION['solea_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['solea_nonce'] ) ) ) ) {
	wp_die( 'Invalid Router call' );
}

if (
	! isset( $_REQUEST['firstname'] ) ||
	! isset( $_REQUEST['nickname'] ) ||
	! isset( $_REQUEST['lastname'] ) ||
	! isset( $_REQUEST['arrival'] ) ||
	! isset( $_REQUEST['arrival_eating'] ) ||
	! isset( $_REQUEST['departure'] ) ||
	! isset( $_REQUEST['departure_eating'] ) ||
	! isset( $_REQUEST['participant_group'] ) ||
	! isset( $_REQUEST['amount_paid'] ) ||
	! isset( $_REQUEST['amount'] ) ||
	! isset( $_REQUEST['contact_person'] ) ||
	! isset( $_REQUEST['email_2'] ) ||
	! isset( $_REQUEST['telefon_2'] ) ||
	! isset( $_REQUEST['swimming_permission'] ) ||
	! isset( $_REQUEST['birthday'] ) ||
	! isset( $_REQUEST['street'] ) ||
	! isset( $_REQUEST['number'] ) ||
	! isset( $_REQUEST['zip'] ) ||
	! isset( $_REQUEST['city'] ) ||
	! isset( $_REQUEST['local_group'] ) ||
	! isset( $_REQUEST['email_1'] ) ||
	! isset( $_REQUEST['telefon_1'] ) ||
	! isset( $_REQUEST['eating_habit'] ) ||
	! isset( $_REQUEST['allergies'] ) ||
	! isset( $_REQUEST['medication'] ) ||
	! isset( $_REQUEST['notices'] )
) {
	wp_die( 'Missing parameters' );
}

$participant->firstname           = sanitize_text_field( wp_unslash( $_REQUEST['firstname'] ) );
$participant->nickname            = sanitize_text_field( wp_unslash( $_REQUEST['nickname'] ) );
$participant->lastname            = sanitize_text_field( wp_unslash( $_REQUEST['lastname'] ) );
$participant->arrival             = sanitize_text_field( wp_unslash( $_REQUEST['arrival'] ) );
$participant->arrival_eating      = sanitize_text_field( wp_unslash( $_REQUEST['arrival_eating'] ) );
$participant->departure           = sanitize_text_field( wp_unslash( $_REQUEST['departure'] ) );
$participant->departure_eating    = sanitize_text_field( wp_unslash( $_REQUEST['departure_eating'] ) );
$participant->participant_group   = sanitize_text_field( wp_unslash( $_REQUEST['participant_group'] ) );
$participant->amount_paid         = floatval( str_replace( ',', '.', sanitize_text_field( wp_unslash( $_REQUEST['amount_paid'] ) ) ) );
$participant->amount              = floatval( str_replace( ',', '.', sanitize_text_field( wp_unslash( $_REQUEST['amount'] ) ) ) );
$participant->contact_person      = sanitize_text_field( wp_unslash( $_REQUEST['contact_person'] ) );
$participant->email_2             = sanitize_text_field( wp_unslash( $_REQUEST['email_2'] ) );
$participant->telefon_2           = sanitize_text_field( wp_unslash( $_REQUEST['telefon_2'] ) );
$participant->swimming_permission = sanitize_text_field( wp_unslash( $_REQUEST['swimming_permission'] ) );
$participant->birthday            = sanitize_text_field( wp_unslash( $_REQUEST['birthday'] ) );
$participant->street              = sanitize_text_field( wp_unslash( $_REQUEST['street'] ) );
$participant->number              = sanitize_text_field( wp_unslash( $_REQUEST['number'] ) );
$participant->zip                 = sanitize_text_field( wp_unslash( $_REQUEST['zip'] ) );
$participant->city                = sanitize_text_field( wp_unslash( $_REQUEST['city'] ) );
$participant->local_group         = (int) sanitize_text_field( wp_unslash( $_REQUEST['local_group'] ) );
$participant->email_1             = sanitize_text_field( wp_unslash( $_REQUEST['email_1'] ) );
$participant->telefon_1           = sanitize_text_field( wp_unslash( $_REQUEST['telefon_1'] ) );
$participant->eating_habit        = sanitize_text_field( wp_unslash( $_REQUEST['eating_habit'] ) );
$participant->allergies           = sanitize_text_field( wp_unslash( $_REQUEST['allergies'] ) );
$participant->medication          = sanitize_text_field( wp_unslash( $_REQUEST['medication'] ) );
$participant->notices             = sanitize_textarea_field( wp_unslash( $_REQUEST['notices'] ) );

$participant->save();
