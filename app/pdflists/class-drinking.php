<?php
/**
 * Class Drinking
 *
 * This class is responsible for generating a PDF document containing a list of participants and their non-alcoholic beverage preferences for an event.
 *
 * @package Solea/PdfLibs
 */

namespace Solea\PdfLists;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\Requests\GetLocalGroupName;

/**
 * Class Drinking
 *
 * This class is responsible for generating a PDF document containing a list of participants and their non-alcoholic beverage preferences for an event.
 *
 * @package Solea/PdfLibs
 */
class Drinking {

	/**
	 * Generates the table header for the non-alcoholic beverage list.
	 *
	 * @param string $event_name The name of the event.
	 *
	 * @return string The generated table header HTML.
	 */
	private function get_table_header( string $event_name ): string {
		return '<h1>' . __( 'Non-Alcoholic Beverage List for ', 'solea' ) . $event_name . '</h1><br /><br /><br /><br /><table style="border-spacing: 0; width: 100%; page-break-after: always">' .
				'<tr>' .
				'<td>' . __( 'First Name', 'solea' ) . '</td>' .
				'<td>' . __( 'Last Name', 'solea' ) . '</td>' .
				'<td>' . __( 'Local Group', 'solea' ) . '</td>' .
				'<td>' . __( 'Age', 'solea' ) . '</td>' .
				'<td>' . __( 'Beverages', 'solea' ) . '</td>';
	}

	/**
	 * Constructor method for the class.
	 *
	 * @param Event $event The event object.
	 *
	 * @return void
	 */
	public function __construct( Event $event ) {
		$output = '';

		$i = 0;
		foreach ( $event->get_participants_by_group() as $localgroup => $participants ) {
			if ( count( $participants ) === 0 ) {
				continue;
			}
			foreach ( $participants as $participant ) {

				if ( 0 === $i ) {
					$output .= $this->get_table_header( $event->event_name );
				}
				++$i;

				$output .= '<tr style="min-height: 80px; height: 80px; border-style: solid; border-width: 1px;">' .
							'<td style="width: 150px; border-style: solid; border-width: 1px;">' . $participant->firstname .
							( '' !== $participant->nickname ? '<br /> (' . $participant->nickname . ')' : '' ) . '</td>' .
							'<td style="width: 150px; border-style: solid; border-width: 1px;">' . $participant->lastname . '</td>' .
							'<td style="padding-right: 100px; border-style: solid; border-width: 1px;">' . GetLocalGroupName::execute( $localgroup ) . '</td>' .
							'<td style="padding-right: 50px; border-style: solid; border-width: 1px;">' . solea_get_age( $participant->birthday ) . ' ' . __( 'years', 'solea' ) . '</td>' .
							'<td style="padding-right: 150px; border-style: solid; border-width: 1px;"></td></tr>';
				if ( 12 === $i ) {
					$output .= '</table>';
					$i       = 0;
				}
			}
			$output .= '</table>';
			$i       = 0;
		}
		$output .= '</table></body></html>';
		solea_create_pdf( $output, $event->event_name . '_' . __( 'Drinking list (non-alcoholic)', 'solea' ) . '.pdf', 'landscape' );
	}
}
