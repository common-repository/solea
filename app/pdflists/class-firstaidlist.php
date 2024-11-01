<?php
/**
 * Class FirstAidList
 *
 * Generates a first aid list for an event
 *
 * @package Solea\PdfLists
 */

namespace Solea\PdfLists;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\Requests\BathRequest;
use Solea\App\Requests\GetLocalGroupName;

/**
 * Class FirstAidList
 *
 * Represents a first aid list for an event.
 */
class FirstAidList {

	/**
	 * Generates the table header for the first aid list PDF.
	 *
	 * @param string $event_name The name of the event.
	 *
	 * @return string The formatted table header HTML.
	 */
	private function get_table_header( string $event_name ): string {
		return '<h1>' . __( 'First Aid List for ', 'solea' ) . $event_name . '</h1><br /><br /><br /><br /><table style="border-spacing: 0; width: 100%; page-break-after: always">' .
				'<tr>' .
				'<td>' . __( 'First Name', 'solea' ) . '</td>' .
				'<td>' . __( 'Last Name', 'solea' ) . '</td>' .
				'<td>' . __( 'Local Group', 'solea' ) . '</td>' .
				'<td>' . __( 'Age', 'solea' ) . '</td>' .
				'<td>' . __( 'Swimming Permission', 'solea' ) . '</td>' .
				'<td>' . __( 'Allergies', 'solea' ) . '</td>' .
				'<td>' . __( 'Medications', 'solea' ) . '</td>' .
				'<td>' . __( 'Notes', 'solea' ) . '</td>';
	}


	/**
	 * Constructor for creating a first aid list PDF for an event.
	 *
	 * @param Event $event The event object.
	 */
	public function __construct( Event $event ) {
		$output = '';

		$i = 0;
		foreach ( $event->get_all_participants() as $participant ) {

			if ( 0 === $i ) {
				$output .= $this->get_table_header( $event->event_name );
			}
				++$i;
				$output .= '<tr style="min-height: 80px; height: 80px; border-style: solid; border-width: 1px;">' .
							'<td style="padding-right: 10px; border-style: solid; border-width: 1px;">' . $participant->firstname . '<br /><br /></td>' .
							'<td style="padding-right: 10px; border-style: solid; border-width: 1px;">' . $participant->lastname . '</td>' .
							'<td style="padding-right: 10px; border-style: solid; border-width: 1px;">' . GetLocalGroupName::execute( $participant->local_group ) . '</td>' .
							'<td style="padding-right: 10px; border-style: solid; border-width: 1px;">' . solea_get_age( $participant->birthday ) . '</td>' .
							'<td style="border-style: solid; border-width: 1px;">' . BathRequest::execute( $participant->swimming_permission ) . '</td>' .
							'<td style="border-style: solid; border-width: 1px;">' . $participant->allergies . '<br />' . $participant->intolerances . '</td>' .
							'<td style="border-style: solid; border-width: 1px;">' . $participant->medication . '</td>' .
							'<td style="border-style: solid; border-width: 1px;">' . $participant->notices . '</td></tr>';
			if ( 10 === $i ) {
				$output .= '</table>';
				$i       = 0;
			}
		}

		$output .= '</table></body></html>';
		solea_create_pdf( $output, $event->event_name . '_' . __( 'First aid list', 'solea' ) . '.pdf', 'landscape' );
	}
}
