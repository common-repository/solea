<?php
/**
 * File: new-participant-save.php
 *
 * @since 2024-07-23
 * @license GPL-3.0-or-later
 *
 * @package package solea/Routers/Partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use solea\App\Actions\Participants\CreateParticipation;
use solea\App\Controllers\EventParticipations\RegistrationFailed;
use solea\App\Controllers\EventParticipations\RegistrationSuccessfull;
use Solea\App\models\Event;
use Solea\App\Requests\CalculateTotalAmount;
use Solea\App\Requests\CheckDoubleRegistration;

if ( ! isset( $_SESSION['solea_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['solea_nonce'] ) ) ) ) {
	echo esc_html__( 'This request is not valid anymore. Please go back to start page', 'solea' );
	return;
}

if (
! isset( $_REQUEST['event-id'] ) ||
	! isset( $_REQUEST['save'] ) ||
	! isset( $_REQUEST['ansprechpartner'] ) ||
	! isset( $_REQUEST['telefon_2'] ) ||
	! isset( $_REQUEST['email_2'] ) ||
	! isset( $_REQUEST['badeerlaubnis'] ) ||
! isset( $_REQUEST['vorname'] ) ||
! isset( $_REQUEST['nachname'] ) ||
! isset( $_REQUEST['pfadiname'] ) ||
! isset( $_REQUEST['localgroup'] ) ||
	! isset( $_REQUEST['geburtsdatum'] ) ||
	! isset( $_REQUEST['strasse'] ) ||
! isset( $_REQUEST['hausnummer'] ) ||
	! isset( $_REQUEST['plz'] ) ||
	! isset( $_REQUEST['ort'] ) ||
! isset( $_REQUEST['telefon_1'] ) ||
	! isset( $_REQUEST['email_1'] ) ||
! isset( $_REQUEST['participant_group'] ) ||
! isset( $_REQUEST['anreise'] ) ||
	! isset( $_REQUEST['anreise_essen'] ) ||
	! isset( $_REQUEST['abreise'] ) ||
	! isset( $_REQUEST['abreise_essen'] ) ||
	! isset( $_REQUEST['allergien'] ) ||
!isset($_REQUEST['intolerances']) ||
	! isset( $_REQUEST['medikamente'] ) ||
! isset( $_REQUEST['beitrag'] ) ||
	! isset( $_REQUEST['essgewohnheit'] ) ||
! isset( $_REQUEST['anmerkungen'] ) ||
	! isset( $_REQUEST['amount_accept'] ) ||
! isset( $_REQUEST['_dsgvo_accept'] ) ) {
	wp_die( 'Missing form params for registering the participation' );
}


$event_id = sanitize_text_field( wp_unslash( $_REQUEST['event-id'] ) );

$event = Event::where( 'id', $event_id )->first();
if ( null === $event ) {
	wp_die( 'Event not found.' );
}



$ansprechpartner   = sanitize_text_field( wp_unslash( $_REQUEST['ansprechpartner'] ) );
$telefon_2         = sanitize_text_field( wp_unslash( $_REQUEST['telefon_2'] ) );
$email_2           = sanitize_email( wp_unslash( $_REQUEST['email_2'] ) );
$badeerlaubnis     = sanitize_text_field( wp_unslash( $_REQUEST['badeerlaubnis'] ) );
$vorname           = sanitize_text_field( wp_unslash( $_REQUEST['vorname'] ) );
$nachname          = sanitize_text_field( wp_unslash( $_REQUEST['nachname'] ) );
$nickname          = sanitize_text_field( wp_unslash( $_REQUEST['pfadiname'] ) );
$localgroup        = sanitize_text_field( wp_unslash( $_REQUEST['localgroup'] ) );
$geburtsdatum      = sanitize_text_field( wp_unslash( $_REQUEST['geburtsdatum'] ) );
$strasse           = sanitize_text_field( wp_unslash( $_REQUEST['strasse'] ) );
$hausnummer        = sanitize_text_field( wp_unslash( $_REQUEST['hausnummer'] ) );
$plz               = sanitize_text_field( wp_unslash( $_REQUEST['plz'] ) );
$ort               = sanitize_text_field( wp_unslash( $_REQUEST['ort'] ) );
$telefon_1         = sanitize_text_field( wp_unslash( $_REQUEST['telefon_1'] ) );
$email_1           = sanitize_email( wp_unslash( $_REQUEST['email_1'] ) );
$participant_group = sanitize_text_field( wp_unslash( $_REQUEST['participant_group'] ) );
$anreise           = sanitize_text_field( wp_unslash( $_REQUEST['anreise'] ) );
$anreise_essen     = sanitize_text_field( wp_unslash( $_REQUEST['anreise_essen'] ) );
$abreise           = sanitize_text_field( wp_unslash( $_REQUEST['abreise'] ) );
$abreise_essen     = sanitize_text_field( wp_unslash( $_REQUEST['abreise_essen'] ) );
$allergien         = sanitize_text_field( wp_unslash( $_REQUEST['allergien'] ) );
$intolerances      = sanitize_text_field( wp_unslash( $_REQUEST['intolerances'] ) );
$medikamente       = sanitize_text_field( wp_unslash( $_REQUEST['medikamente'] ) );
$essgewohnheit     = sanitize_text_field( wp_unslash( $_REQUEST['essgewohnheit'] ) );
$anmerkungen       = sanitize_textarea_field( wp_unslash( $_REQUEST['anmerkungen'] ) );
$beitrag           = sanitize_text_field( wp_unslash( $_REQUEST['beitrag'] ) );

$foto_socialmedia = false;
$foto_print       = false;
$foto_webseite    = false;
$foto_partner     = false;
$foto_intern      = false;

if ( isset( $_REQUEST['foto']['socialmedia'] ) ) {
	$foto_socialmedia = true;
}

if ( isset( $_REQUEST['foto']['print'] ) ) {
	$foto_print = true;
}

if ( isset( $_REQUEST['foto']['webseite'] ) ) {
	$foto_webseite = true;
}

if ( isset( $_REQUEST['foto']['partner'] ) ) {
	$foto_partner = true;
}

if ( isset( $_REQUEST['foto']['intern'] ) ) {
	$foto_intern = true;
}


$nicename = $vorname . ' ' . $nachname;
if ( '' !== $nickname ) {
	$nicename = $nickname;
}

if ( ! CheckDoubleRegistration::execute( $event_id, $vorname, $nachname, $email_1, $geburtsdatum ) ) {

	$amount = CalculateTotalAmount::execute( $event, $participant_group, $beitrag, $anreise, $abreise );
	if ( solea_is_fullaged( $geburtsdatum ) ) {
		$badeerlaubnis = 'complete';
	}

	$participant = CreateParticipation::execute(
		$event,
		$participant_group,
		$vorname,
		$nachname,
		$nickname,
		$geburtsdatum,
		$localgroup,
		$ansprechpartner,
		$strasse,
		$hausnummer,
		$plz,
		$ort,
		$email_1,
		$email_2,
		$telefon_1,
		$telefon_2,
		$essgewohnheit,
		$badeerlaubnis,
		$allergien,
        $intolerances,
		$medikamente,
		$anmerkungen,
		$amount,
		$anreise,
		$anreise_essen,
		$abreise,
		$abreise_essen,
		$foto_socialmedia,
		$foto_print,
		$foto_webseite,
		$foto_partner,
		$foto_intern
	);

	if ( null === $participant ) {
		RegistrationFailed::display_error( $event, $nicename );
		return;
	}

	RegistrationSuccessfull::execute( $participant );
	return;
}

RegistrationFailed::display_already_registered( $event, $nicename );
return;
