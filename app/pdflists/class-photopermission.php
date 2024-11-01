<?php
/**
 * Class PhotoPermission
 *
 * This class is responsible for generating a PDF document with a photo permission list for an event.
 *
 * @package Solea/Libs
 */

namespace Solea\PdfLists;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\Requests\GetLocalGroupName;

/**
 * Class PhotoPermission
 *
 * This class is responsible for generating a PDF document with a photo permission list for an event.
 *
 * @package Solea/Libs
 */
class PhotoPermission {

	/**
	 * Retrieves the table header for a given event name.
	 *
	 * @param string $event_name The name of the event.
	 *
	 * @return string The table header HTML markup for the event.
	 */
	private function get_table_header( string $event_name ): string {
			return '<h1>' . $event_name . ' - ' . __( 'Photo Permission', 'solea' ) . '</h1><br />' .
					'<br /><br /><table style="border-spacing: 0; width: 100%; page-break-after: always">' .
					'<tr>' .
					'<td style="border-style:solid none solid solid; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'Name', 'solea' ) . '</td>' .
					'<td style="border-style:solid none solid solid; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'Local group', 'solea' ) . '</td>' .
					'<td style="border-style:solid none solid solid; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'Photo Permission Social Media', 'solea' ) . '</td>' .
					'<td style="border-style:solid none solid solid; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'Photo Permission Print Media', 'solea' ) . '</td>' .
					'<td style="border-style:solid none solid solid; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'Photo Permission Websites', 'solea' ) . '</td>' .
					'<td style="border-style:solid none solid solid; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'Photo Permission Partner Mailings', 'solea' ) . '</td>' .
					'<td style="border-style:solid solid solid solid; border-width: 1px; text-align: center; font-weight: bold;">' . __( 'Photo Permission Internal Archives', 'solea' ) . '</td>' .
					'</tr>';
	}


	/**
	 * __construct method creates an HTML table with photo permission information for participants of an event, and converts it to a PDF using solea_create_pdf function.
	 *
	 * @param Event $event The event object.
	 *
	 * @return void
	 */
	public function __construct( Event $event ) {

		$output = '<html><body>';

		$i = 0;

		foreach ( $event->get_all_participants() as $participant ) {
			if ( 0 === $i ) {
				$output .= $this->get_table_header( $event->event_name );
			}
			++$i;
			$output .= '<tr style="">';
			$output .= '<td style="height: 60px; border-width: 1px; border-style: none solid solid solid;">' . $participant->firstname . ( '' !== $participant->nickname ? ' (' . $participant->nickname . ')' : '' ) . ' ' . $participant->lastname . '</td>';
			$output .= '<td style="height: 60px; border-width: 1px; border-style: none solid solid solid;">' . GetLocalGroupName::execute( $participant->local_group ) . '</td>';
			$output .= '<td style="text-align: center; border-width: 1px; border-style: none solid solid none;">' . ( true === (bool) $participant->foto_socialmedia ? 'X' : '---' ) . '</td>';
			$output .= '<td style="text-align: center; border-width: 1px; border-style: none solid solid none;">' . ( true === (bool) $participant->foto_print ? 'X' : '---' ) . '</td>';
			$output .= '<td style="text-align: center; border-width: 1px; border-style: none solid solid none;">' . ( true === (bool) $participant->foto_webseite ? 'X' : '---' ) . '</td>';
			$output .= '<td style="text-align: center; border-width: 1px; border-style: none solid solid none;">' . ( true === (bool) $participant->foto_partner ? 'X' : '---' ) . '</td>';
			$output .= '<td style="text-align: center; border-width: 1px; border-style: none solid solid none;">' . ( true === (bool) $participant->foto_intern ? 'X' : '---' ) . '</td>';

			$output .= '</tr>';
			if ( 7 === $i ) {
				$output .= '</table>';
				$i       = 0;
			}
		}

		$output .= '</body></html>';

		solea_create_pdf( $output, $event->event_name . '_' . __( 'Photo permission', 'solea' ) . '.pdf', 'landscape' );
	}
}
