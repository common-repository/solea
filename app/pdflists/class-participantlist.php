<?php
/**
 * Class ParticipantList
 *
 * This class is responsible for generating a participant list PDF for an event.
 *
 * @package Solea/PdfLibs
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
 * Class ParticipantList
 *
 * This class is responsible for generating a participant list PDF for an event.
 *
 * @package Solea/PdfLibs
 */
class ParticipantList {

	/**
	 * Generates the table header for the participant list.
	 *
	 * @param string $event_name The name of the event.
	 *
	 * @return string The generated HTML table header.
	 */
	private function get_table_header( string $event_name ): string {
		return '<h1>' . __( 'Participant list for', 'solea' ) . ' ' . $event_name . '</h1><br /><br /><br /><br /><table style="border-spacing: 0; width: 100%;page-break-after: always">' .
				'<tr>' .
				'<td>' . __( 'First name', 'solea' ) . '</td>' .
				'<td>' . __( 'Last name', 'solea' ) . '</td>' .
				'<td>' . __( 'Participant group', 'solea' ) . '</td>' .
				'<td>' . __( 'Local group', 'solea' ) . '</td>' .
				'<td>' . __( 'Birthday', 'solea' ) . '</td>' .
				'<td>' . __( 'Date', 'solea' ) . '</td>' .
				'<td>' . __( 'Attendance days', 'solea' ) . '</td>' .
				'<td>' . __( 'Signature', 'solea' ) . '</td>';
	}

	/**
	 * Constructs a new object of the class.
	 *
	 * This method generates a participant list HTML table and creates a PDF file from it.
	 *
	 * @param Event $event The Event object representing the event for which the participant list is being generated.
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

				$anreise = \DateTime::createFromFormat( 'Y-m-d', $participant->arrival );
				$abreise = \DateTime::createFromFormat( 'Y-m-d', $participant->departure );

				$cmpd = date_diff( $anreise, $abreise );
				$days = $cmpd->d + 1;

				$output .= '<tr style="min-height: 80px; height: 80px; border-style: solid; border-width: 1px;">' .
							'<td style="width: 150px; border-style: solid; border-width: 1px;">' . $participant->firstname .
							( '' !== $participant->nickname ? '<br /> (' . $participant->nickname . ')' : '' ) . '</td>' .
							'<td style="width: 150px; border-style: solid; border-width: 1px;">' . $participant->lastname . '</td>' .
							'<td style="padding-right: 100px; border-style: solid; border-width: 1px;">' . GetParticipationTypeName::execute( $participant->participant_group ) . '</td>' .
							'<td style="padding-right: 100px; border-style: solid; border-width: 1px;">' . GetLocalGroupName::execute( $participant->local_group ) . '</td>' .
							'<td style="padding-right: 50px; border-style: solid; border-width: 1px;">' .
							\DateTime::createFromFormat( 'Y-m-d', $participant->birthday )->format( 'd.m.Y' ) . '<br />' .
							'(' . solea_get_age( $participant->birthday ) . ' ' . __( 'years', 'solea' ) . ')</td>' .
							'<td style="padding-right: 50px; border-style: solid; border-width: 1px;">' .
							\DateTime::createFromFormat( 'Y-m-d', $participant->arrival )->format( 'd.m.Y' ) . ' - ' .
							\DateTime::createFromFormat( 'Y-m-d', $participant->departure )->format( 'd.m.Y' ) . '</td>' .
							'<td style="border-style: solid; border-width: 1px;">' . $days . '</td>' .
							'<td style="padding-right: 150px; border-style: solid; border-width: 1px;"></td></tr>';
				if ( 12 === $i ) {
					$output .= '</table>';
					$i       = 0;
				}
			}

			$output .= '</table></body></html>';
			$i       = 0;
		}

		$output .= '</table></body></html>';
		solea_create_pdf( $output, $event->event_name . '_' . __( 'Participant list', 'solea' ) . '.pdf', 'landscape' );
	}
}
