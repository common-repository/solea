<?php
/**
 * File: class-eatingrequest.php
 *
 * @since 2024-07-25
 * @license GPL-3.0-or-later
 *
 * @package Solae/Requests/
 */

namespace Solea\App\Requests;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Illuminate\Database\Eloquent\Collection;

/**
 * This class is responsible for calculating the participant count for a given eating habit and date.
 */
class EatingRequest {
	/**
	 * Calculate the participant count for a given eating habit and date.
	 *
	 * @param Collection $participants The collection of participants to calculate the count for.
	 * @param string     $eating_habit The eating habit to filter participants by.
	 * @param \DateTime  $date The date to calculate the count for.
	 *
	 * @return array The participant count for each eating habit (1, 2, 3) as an associative array.
	 */
	public static function send( Collection $participants, string $eating_habit, \DateTime $date ) {
		$participant_count = array(
			'1' => 0,
			'2' => 0,
			'3' => 0,
		);

		foreach ( $participants as $participant ) {
			if ( $participant->eating_habit !== $eating_habit ) {
				continue;
			}

			$anreise = \DateTime::createFromFormat( 'Y-m-d', $participant->arrival );
			$abreise = \DateTime::createFromFormat( 'Y-m-d', $participant->departure );

			if ( $anreise->getTimestamp() < $date->getTimestamp() && $abreise->getTimestamp() > $date->getTimestamp() ) {
				++$participant_count['1'];
				++$participant_count['2'];
				++$participant_count['3'];
			} elseif ( $anreise->getTimestamp() === $date->getTimestamp() ) { // Anreisetag.
				if ( 3 === (int) $participant->arrival_eating ) {
					++$participant_count['1'];
					++$participant_count['2'];
					++$participant_count['3'];
				} elseif ( 2 === (int) $participant->arrival_eating ) {
					++$participant_count['2'];
					++$participant_count['3'];
				} elseif ( 1 === (int) $participant->arrival_eating ) {
					++$participant_count['3'];
				}
			} elseif ( $abreise->getTimestamp() === $date->getTimestamp() ) { // Abreisetag.
				if ( 3 === (int) $participant->departure_eating ) {
					++$participant_count['1'];
					++$participant_count['2'];
					++$participant_count['3'];
				} elseif ( 2 === (int) $participant->departure_eating ) {
					++$participant_count['1'];
					++$participant_count['2'];
				} elseif ( 1 === (int) $participant->departure_eating ) {
					++$participant_count['1'];
				}
			}
		}

		return $participant_count;
	}
}
