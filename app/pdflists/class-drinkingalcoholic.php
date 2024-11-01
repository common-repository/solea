<?php
/**
 * Class DrinkingAlcoholic
 *
 * This class is responsible for generating a PDF drinking list for an event,
 * specifically for alcoholic beverages.
 *
 * @package Solea\PdfLists
 */

namespace Solea\PdfLists;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\Requests\GetLocalGroupName;

/**
 * Class DrinkingAlcoholic
 *
 * This class is responsible for generating a PDF drinking list for an event,
 * specifically for alcoholic beverages.
 *
 * @package Solea\PdfLists
 */
class DrinkingAlcoholic {

	/**
	 * Generates the table header for the alcoholic beverage list.
	 *
	 * @param string $event_name The name of the event.
	 *
	 * @return string The formatted table header HTML.
	 */
	private function get_table_header( string $event_name ): string {
		return '<h1>' . __( 'Alcoholic Beverage List for ', 'solea' ) . $event_name . '</h1><br /><br /><br /><br /><table style="border-spacing: 0; width: 100%; page-break-after: always">' .
				'<tr>' .
				'<td>' . __( 'First Name', 'solea' ) . '</td>' .
				'<td>' . __( 'Last Name', 'solea' ) . '</td>' .
				'<td>' . __( 'Local Group', 'solea' ) . '</td>' .
				'<td>' . __( 'Age', 'solea' ) . '</td>' .
				'<td>' . __( 'Beer', 'solea' ) . '</td>' .
				'<td>' . __( 'Wine', 'solea' ) . '</td>' .
				'<td>' . __( 'Sparkling Wine', 'solea' ) . '</td>' .
				'<td>' . __( 'Other', 'solea' ) . '</td></tr>';
	}

	/**
	 * Constructs the object.
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
				if ( ! solea_can_drink_alcoholics( $event, $participant->birthday ) ) {
					continue;
				}

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
							'<td style="padding-right: 100px; border-style: solid; border-width: 1px;"></td>' .
							'<td style="padding-right: 100px; border-style: solid; border-width: 1px;"></td>' .
							'<td style="padding-right: 100px; border-style: solid; border-width: 1px;"></td>' .
							'<td style="padding-right: 100px; border-style: solid; border-width: 1px;"></td></tr>';

				if ( 12 === $i ) {
					$output .= '</table>';
					$i       = 0;
				}
			}
			$output .= '</table>';
			$i       = 0;
		}
		$output .= '</table></body></html>';
		solea_create_pdf( $output, $event->event_name . '_' . __( 'Drinking list (alcoholic)', 'solea' ) . '.pdf', 'landscape' );
	}
}
