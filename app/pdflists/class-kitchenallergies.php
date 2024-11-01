<?php
/**
 * Class KitchenAllergies
 *
 * The KitchenAllergies class generates a PDF file containing a kitchen list with allergies for a given event.
 *
 * @package Solea/PdfLibs
 */

namespace Solea\PdfLists;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\Requests\EatingHabit;
use Solea\App\Requests\GetLocalGroupName;

/**
 * Class KitchenAllergies
 */
class KitchenAllergies {

	/**
	 * Retrieves the table header for the kitchen list.
	 *
	 * @param string $event_name The name of the event.
	 *
	 * @return string The HTML code for the table header.
	 */
	private function get_table_header( string $event_name ): string {
		return '<h1>' . __( 'Addition to the Kitchen List for ', 'solea' ) . $event_name . '</h1><br /><br /><br /><br /><table style="border-spacing: 0; width: 100%; page-break-after: always">' .
				'<tr>' .
				'<td>' . __( 'First Name', 'solea' ) . '</td>' .
				'<td>' . __( 'Last Name', 'solea' ) . '</td>' .
				'<td>' . __( 'Local group', 'solea' ) . '</td>' .
				'<td>' . __( 'Food intolerances', 'solea' ) . '</td>' .
				'<td>' . __( 'Dietary Habits', 'solea' ) . '</td>' .
				'<td>' . __( 'Arrival', 'solea' ) . '</td>' .
				'<td>' . __( 'Departure', 'solea' ) . '</td>';
	}

	/**
	 * Constructor for the class.
	 *
	 * @param Event $event The event object.
	 *
	 * @return void
	 */
	public function __construct( Event $event ) {
		$output = '';

		$i = 0;
		foreach ( $event->get_all_participants() as  $participant ) {

			if ( '' === $participant->intolerances ) {
				continue;
			}

			if ( 0 === $i ) {
				$output .= $this->get_table_header( $event->event_name );
			}
				++$i;

				$output .= '<tr style="min-height: 80px; height: 80px; border-style: solid; border-width: 1px;">' .
							'<td style="padding-right: 10px; border-style: solid; border-width: 1px;">' . $participant->firstname . '<br /><br /></td>' .
							'<td style="padding-right: 10px; border-style: solid; border-width: 1px;">' . $participant->lastname . '</td>' .
							'<td style="padding-right: 10px; border-style: solid; border-width: 1px;">' . GetLocalGroupName::execute( $participant->local_group ) . '</td>' .
							'<td style="border-style: solid; border-width: 1px;">' . $participant->intolerances . '</td>' .
							'<td style="border-style: solid; border-width: 1px;">' . EatingHabit::execute( $participant->eating_habit ) . '</td>' .
							'<td style="border-style: solid; border-width: 1px;">' . \DateTime::createFromFormat( 'Y-m-d', $participant->arrival )->format( 'd.m.Y' ) . '</td>' .
							'<td style="border-style: solid; border-width: 1px;">' . \DateTime::createFromFormat( 'Y-m-d', $participant->departure )->format( 'd.m.Y' ) . '</td></tr>';
			if ( 13 === $i ) {
				$output .= '</table>';
				$i       = 0;
			}
		}

		$output .= '</table></body></html>';
		solea_create_pdf( $output, $event->event_name . '_' . __( 'Kitchen list with allergies', 'solea' ) . '.pdf', 'landscape' );
	}
}
