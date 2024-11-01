<?php
/**
 * File: class-ajaxrouter.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package solea/Routers
 */

namespace Solea\App\Routers;

use solea\App\Controllers\EventParticipations\CreatePrintableList;
use solea\App\Controllers\EventParticipations\ShowParticipantDetails;
use Solea\App\models\Event;
use Solea\App\models\Participant;
use Solea\App\Requests\CreateSepaQRCode;

if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}

/**
 * Class AjaxRouter
 *
 * This class handles Ajax requests and executes the requested method based on the provided parameters.
 * It performs checks on the session nonce and script call before executing the method.
 */
class AjaxRouter {
	/**
	 * Execute the requested method based on the provided parameters.
	 *
	 * This method checks the session nonce and script call before executing the requested method.
	 * It handles different cases based on the value of the "method" parameter provided in the request.
	 *
	 * @return void
	 */
	public static function execute() {
		if ( ! isset( $_SESSION['solea_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['solea_nonce'] ) ) ) ) {
			wp_die( 'Invalid Router call' );
		}

		if ( ! isset( $_REQUEST['method'] ) ) {
			wp_die( 'Invalid script call' );
		}
		$methode = sanitize_key( wp_unslash( $_REQUEST['method'] ) );
		switch ( $methode ) {
			case 'print-participant':
				if ( ! isset( $_REQUEST['participant-id'] ) ) {
					wp_die( 'Missing parameters for displaying participant' );
				}

				$participant = Participant::get_with_permission_check( (int) sanitize_key( wp_unslash( $_REQUEST['participant-id'] ) ) );
				ShowParticipantDetails::execute( $participant );
				return;

			case 'print-list':
				if (
				! isset( $_REQUEST['list-type'] ) ||
				! isset( $_REQUEST['event-id'] ) ) {
					wp_die( 'Missing parameters for creating a list' );
				}

				$list_type = sanitize_key( wp_unslash( $_REQUEST['list-type'] ) );
				$eventid   = (int) sanitize_key( wp_unslash( $_REQUEST['event-id'] ) );
				$event     = Event::get_with_permission_check( $eventid );

				CreatePrintableList::execute( $event, $list_type );
				return;
			case 'generate-payment-link':
				if ( ! isset( $_REQUEST['amount'] ) ||
					! isset( $_REQUEST['recipient'] ) ||
					! isset( $_REQUEST['subject'] ) ||
					! isset( $_REQUEST['iban'] ) ) {
					wp_die( 'Not enough data to generate bank code' );
				}

				$amount = sanitize_text_field( wp_unslash( $_REQUEST['amount'] ) );

				CreateSepaQRCode::send(
					$amount,
					sanitize_text_field( wp_unslash( $_REQUEST['recipient'] ) ),
					sanitize_text_field( wp_unslash( $_REQUEST['subject'] ) ),
					sanitize_text_field( wp_unslash( $_REQUEST['iban'] ) )
				);
				return;

		}
	}
}
