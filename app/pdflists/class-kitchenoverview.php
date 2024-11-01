<?php
/**
 * Class KitchenOverview
 *
 * This class generates a kitchen overview for a given event.
 *
 * @package Solea/PdfLibs
 */

namespace Solea\PdfLists;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\Requests\EatingRequest;


/**
 * Class KitchenOverview
 *
 * This class generates a kitchen overview for a given event.
 *
 * @package Solea/PdfLibs
 */
class KitchenOverview {
	/**
	 * Constructs a new instance of the class.
	 *
	 * @param Event $event The event object.
	 *
	 * @return void
	 */
	public function __construct( Event $event ) {
		$participants = $event->get_all_participants();

		$output = '<html><body><h1>' . $event->event_name . ' - ' . __( 'Kitchen overview', 'solea' ) . '</h1><br />';

		$start_date = \DateTime::createFromFormat( 'Y-m-d', $event->date_begin );
		$end_date   = \DateTime::createFromFormat( 'Y-m-d', $event->date_end );

		$colspan = 2;
		if ( $event->enable_all_eating ) {
			$colspan = 3;
		}

		$output .= '<br /><br /><table style="border-spacing: 0; width: 100%;">' .
				'<tr>' .
				'<td rowspan="2" style="text-align: center; font-weight: bold;">Datum</td>' .
				'<td style="border-style:solid solid none solid; border-width: 1px; text-align: center; font-weight: bold;" colspan="' . $colspan . '">' . __( 'Breakfast', 'solea' ) . '</td>' .
				'<td style="border-style:solid solid none none; border-width: 1px; text-align: center; font-weight: bold;" colspan="' . $colspan . '">' . __( 'Lunch', 'solea' ) . '</td>' .
				'<td style="border-style:solid solid none none; border-width: 1px; text-align: center; font-weight: bold;" colspan="' . $colspan . '">' . __( 'Dinner', 'solea' ) . '</td></tr><tr>';
		if ( $event->enable_all_eating ) {
			$output .= '<td style="border-style:none solid none solid; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'All', 'solea' ) . '</td>';
		}

				$output .= '<td style="border-style:none solid none solid; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'Vegetarian', 'solea' ) . '</td>' .
				'<td style="border-style:none solid none none; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'Vegan', 'solea' ) . '</td>';

		if ( $event->enable_all_eating ) {
			$output .= '<td style="border-style:none solid none solid; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'All', 'solea' ) . '</td>';
		}
				$output .= '<td style="border-style:none solid none none; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'Vegetarian', 'solea' ) . '</td>' .
				'<td style="border-style:none solid none none; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'Vegan', 'solea' ) . '</td>';
		if ( $event->enable_all_eating ) {
			$output .= '<td style="border-style:none solid none solid; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'All', 'solea' ) . '</td>';
		}
				$output .= '<td style="border-style:none solid none none; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'Vegetarian', 'solea' ) . '</td>' .
				'<td style="border-style:none solid none none; border-width: 1px; border-style:none solid none none; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'Vegan', 'solea' ) . '</td>' .
				'</tr>';

		for ( $cur_date = $start_date; $cur_date->getTimestamp() <= $end_date->getTimestamp(); $cur_date->modify( '+1 day' ) ) {

			$vegetarian = EatingRequest::send( $participants, 'vegetarian', $cur_date );
			$vegan      = EatingRequest::send( $participants, 'vegan', $cur_date );
			$meat       = EatingRequest::send( $participants, 'all', $cur_date );

			$output .= '<tr style="border-width: 1px; border-style: solid; height: 60px;">';
			$output .= '<td style="border-width: 1px; border-style: solid;">' . $cur_date->format( 'd.m.Y' ) . '</td>';

			if ( $event->enable_all_eating ) {
				$output .= '<td style="text-align: center; border-width: 1px; border-style: solid;">' . $meat['1'] . '</td>';
			}

			$output .= '<td style="text-align: center; border-width: 1px; border-style: solid;">' . $vegetarian['1'] . '</td>';
			$output .= '<td style="text-align: center; border-width: 1px; border-style: solid;">' . $vegan['1'] . '</td>';

			if ( $event->enable_all_eating ) {
				$output .= '<td style="text-align: center; border-width: 1px; border-style: solid;">' . $meat['2'] . '</td>';
			}
			$output .= '<td style="text-align: center; border-width: 1px; border-style: solid;">' . $vegetarian['2'] . '</td>';
			$output .= '<td style="text-align: center; border-width: 1px; border-style: solid;">' . $vegan['2'] . '</td>';

			if ( $event->enable_all_eating ) {
				$output .= '<td style="text-align: center; border-width: 1px; border-style: solid;">' . $meat['3'] . '</td>';
			}

			$output .= '<td style="text-align: center; border-width: 1px; border-style: solid;">' . $vegetarian['3'] . '</td>';
			$output .= '<td style="text-align: center; border-width: 1px; border-style: solid;">' . $vegan['3'] . '</td>';

			$output .= '</tr>';
		}

		$output .= '</table></body></html>';

		solea_create_pdf( $output, $event->event_name . '_' . __( 'Kitchen overview', 'solea' ) . '.pdf', 'landscape' );
	}
}
