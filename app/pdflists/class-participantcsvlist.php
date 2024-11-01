<?php
/**
 * Class ParticipantCSVList
 *
 * This class is responsible for generating and exporting a CSV participant list for an event.
 *
 * @package Solea/PdfLists
 */

namespace Solea\PdfLists;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Bdp\Modules\EventParticipants\Reqeust\AnwesenheitRequest;
use Solea\App\models\Event;
use Solea\App\Requests\GetLocalGroupName;
use Solea\App\Requests\GetLocalGroupZip;
use Solea\App\Requests\GetParticipationTypeName;
use Solea\Libs\FileAccess;

/**
 * Class ParticipantCSVList
 *
 * This class is responsible for generating and exporting a CSV participant list for an event.
 *
 * @package Solea\PdfLists
 */
class ParticipantCSVList {

	/**
	 * This method returns the table header for the given event name.
	 *
	 * @return string The table header as a string.
	 */
	private function get_table_header(): string {
		return '"' . __( 'First name', 'solea' ) . '",' .
				'"' . __( 'Last name', 'solea' ) . '",' .
				'"' . __( 'Participant group', 'solea' ) . '",' .
				'"' . __( 'Local group', 'solea' ) . '",' .
				'"' . __( 'Birthday', 'solea' ) . '",' .
				'"' . __( 'Arrival', 'solea' ) . '",' .
				'"' . __( 'Departure', 'solea' ) . '",' .
				'"' . __( 'Attendance days', 'solea' ) . '",' .
				'"' . __( 'Zip code', 'solea' ) . '",' .
				'"' . __( 'Zip code (local group)', 'solea' ) . '"';
	}

	/**
	 * Class constructor
	 *
	 * @param Event $event The event object.
	 *
	 * @return void
	 */
	public function __construct( Event $event ) {
		$output = $this->get_table_header() . PHP_EOL;

		foreach ( $event->get_participants_by_group() as $group => $participants ) {
			foreach ( $participants as $participant ) {

				$anreise = \DateTime::createFromFormat( 'Y-m-d', $participant->arrival );
				$abreise = \DateTime::createFromFormat( 'Y-m-d', $participant->departure );

				$cmpd = date_diff( $anreise, $abreise );
				$days = $cmpd->d;

				if ( 0 === $days ) {
					$days = 1;
				} else {
					++$days;
				}

				$output .= '"' . $participant->firstname . '",' .
							'"' . $participant->lastname . '",' .
							'"' . GetParticipationTypeName::execute( $participant->participant_group ) . '",' .
							'"' . GetLocalGroupName::execute( $participant->local_group ) . '",' .
							'"' . \DateTime::createFromFormat( 'Y-m-d', $participant->birthday )->format( 'd.m.Y' ) . '",' .
							'"' . \DateTime::createFromFormat( 'Y-m-d', $participant->arrival )->format( 'd.m.Y' ) . '",' .
							'"' . \DateTime::createFromFormat( 'Y-m-d', $participant->departure )->format( 'd.m.Y' ) . '",' .
							'"' . $days . '",' .
							'"' . $participant->zip . '",' .
							'"' . GetLocalGroupZip::execute( $participant->local_group ) . '"' . PHP_EOL;
			}
		}

		$filename = $event->event_name . '_' . __( 'Participant list', 'solea' ) . '.csv';

		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment; filename="' . $filename );

		$file_access = new FileAccess();
		$dir         = wp_upload_dir();

		$file_access->put_contents( $dir['path'] . '/export.csv', $output, SOLEA_WP_FS_CHMOD_FILE );
		$file_access->output_file( $dir['path'] . '/export.csv' );
		$file_access->delete( $dir['path'] . '/export.csv' );

		exit;
	}
}
