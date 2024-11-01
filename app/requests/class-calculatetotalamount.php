<?php
/**
 * File: class-calculatetotalamount.php
 *
 * @since 2024-07-23
 * @license GPL-3.0-or-later
 *
 * @package Solae/Requests
 */

namespace Solea\App\Requests;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\models\Participant;

/**
 * Class CalculateTotalAmount
 *
 * A class for calculating the total amount based on the event, participant group, amount class, arrival date, and departure date.
 */
class CalculateTotalAmount {
	/**
	 * Calculates the amount for a participant in an event.
	 *
	 * @param Event  $event The event object.
	 * @param string $participant_group The participant group (e.g. 'participant', 'volunteer', etc.).
	 * @param string $amount_class The amount class ('regular', 'reduced', 'social').
	 * @param string $arrival The arrival date of the participant in 'Y-m-d' format.
	 * @param string $depature The departure date of the participant in 'Y-m-d' format.
	 *
	 * @return float The calculated amount for the participant.
	 */
	public static function execute( Event $event, string $participant_group, string $amount_class, string $arrival, string $depature ): float {
		$amount = 0.00;
		if ( $event->registration_solidarity ) {
			switch ( $amount_class ) {
				case 'regular':
					$amount = $event->amount_participant;
					break;

				case 'reduced':
					$amount = $event->amount_reduced;
					break;
				case 'social':
					$amount = $event->amount_social;
					break;
			}
		} else {
			$event_start = \DateTime::createFromFormat( 'Y-m-d', $arrival );
			$event_end   = \DateTime::createFromFormat( 'Y-m-d', $depature );
			$interval    = $event_end->diff( $event_start );

			$days = $interval->days;
			++$days;

			switch ( $participant_group ) {
				case Participant::PARTICIPATION_GROUP_PARTICIPANT:
					$amount = $event->amount_participant;
					break;

				case Participant::PARTICIPATION_GROUP_VOLUNTEER:
					$amount = $event->amount_volunteer;
					break;

				case Participant::PARTICIPATION_GROUP_TEAM:
					$amount = $event->amount_team;
					break;

				case Participant::PARTICIPATION_GROUP_OTHER:
					$amount = $event->amount_other;
					break;

				case Participant::PARTICIPATION_GROUP_ONLINE:
					$amount = $event->amount_online;
					break;
			}

			$amount *= $days;
			if ( null !== $event->amount_max && $amount > $event->amount_max ) {
				$amount = $event->amount_max;
			}
		}

		$amount_factor     = 1;
		$today             = new \DateTime();
		$last_minute_start = \DateTime::createFromFormat( 'Y-m-d', $event->last_minute_begin );

		if ( $today->getTimestamp() >= $last_minute_start->getTimestamp() ) {
			$amount_factor += (int) $event->increase_amount_last_minute / 100;
		}

		return $amount * $amount_factor;
	}
}
