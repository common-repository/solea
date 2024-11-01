<?php
/**
 * Class AmountList
 *
 * Generates an amount list in PDF format for an event.
 *
 * @package Solea\PdfLists
 */

namespace Solea\PdfLists;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Bdp\Modules\EventParticipants\Reqeust\AnwesenheitRequest;
use Solea\App\models\Event;
use Solea\App\Requests\GetLocalGroupName;
use Solea\App\Requests\GetParticipationTypeName;

/**
 * Class AmountList
 *
 * Generates an amount list in PDF format for an event.
 *
 * @package Solea\PdfLists
 */
class AmountList {

	/**
	 * Get the table header for the amount list
	 *
	 * @param string $event_name The name of the event.
	 *
	 * @return string The HTML markup for the table header.
	 */
	private function get_table_header( string $event_name ): string {
		return '<h1>' . __( 'Amount list for', 'solea' ) . ' ' . $event_name . '</h1><br /><br /><br /><br /><table style="border-spacing: 0; width: 100%;page-break-after: always">' .
				'<tr>' .
				'<td>' . __( 'First name', 'solea' ) . '</td>' .
				'<td>' . __( 'Last name', 'solea' ) . '</td>' .
				'<td>' . __( 'Participant group', 'solea' ) . '</td>' .
				'<td>' . __( 'Local group', 'solea' ) . '</td>' .
				'<td>' . __( 'Date', 'solea' ) . '</td>' .
				'<td>' . __( 'Amount', 'solea' ) . '</td>';
	}

	/**
	 * Constructor for the __construct method
	 *
	 * @param Event $event The event object to be processed.
	 *
	 * @return void
	 */
	public function __construct( Event $event ) {
		$output = '';

		$i = 0;

		foreach ( $event->get_participants_by_group() as $group => $participants ) {
			foreach ( $participants as $participant ) {
				if ( 0 === $i ) {
					$output .= $this->get_table_header( $event->event_name );
				}
				++$i;

				$output .= '<tr style="min-height: 80px; height: 80px; border-style: solid; border-width: 1px;">' .
							'<td style="width: 150px; border-style: solid; border-width: 1px;">' . $participant->firstname .
							( '' !== $participant->nickname ? '<br /> (' . $participant->nickname . ')' : '' ) . '</td>' .
							'<td style="width: 150px; border-style: solid; border-width: 1px;">' . $participant->lastname . '</td>' .
							'<td style="padding-right: 100px; border-style: solid; border-width: 1px;">' . GetParticipationTypeName::execute( $participant->participant_group ) . '</td>' .
							'<td style="padding-right: 100px; border-style: solid; border-width: 1px;">' . GetLocalGroupName::execute( $participant->local_group ) . '</td>' .
							'<td style="padding-right: 50px; border-style: solid; border-width: 1px;">' .
							\DateTime::createFromFormat( 'Y-m-d', $participant->arrival )->format( 'd.m.Y' ) . ' - ' .
							\DateTime::createFromFormat( 'Y-m-d', $participant->departure )->format( 'd.m.Y' ) . '</td>' .
							'<td style="border-style: solid; border-width: 1px;">' . solea_format_amount( $participant->amount_paid ) . ' / ' .
							solea_format_amount( $participant->amount ) . '</td></tr>';
				if ( 12 === $i ) {
					$output .= '</table>';
					$i       = 0;
				}
			}

			$output .= '</table></body></html>';
			$i       = 0;
		}

		$output .= '</table></body></html>';
		solea_create_pdf( $output, $event->event_name . '_' . __( 'Amount list', 'solea' ) . '.pdf', 'landscape' );
	}
}
