<?php
/**
 * File: class-informeventmanagement.php
 *
 * @since 2024-07-29
 * @license GPL-3.0-or-later
 *
 * @package Solea/Tasks/
 */

namespace Solea\App\Tasks;

use Solea\App\models\Event;
use Solea\App\Actions\Events\RemindEventManagement as RemindManagementAction;

/**
 * Class RemindEventManagement
 *
 * This class manages the execution of event reminders.
 */
class RemindEventManagement {

	/**
	 * Executes a series of actions based on certain conditions.
	 *
	 * This method iterates through a list of closed events and performs actions based on the current date and other conditions.
	 * It checks if the current date is before the registration end date of an event, and if it's not a weekend (Saturday or Sunday).
	 * If these conditions are met, it executes the RemindManagementAction for the event.
	 *
	 * @return void
	 */
	public static function execute() {
		$now = new \DateTime();

		$weekday = (int) $now->format( 'w' );
		foreach ( Event::list_closed_events() as $event ) {
			$registration_end = \DateTime::createFromFormat( 'Y-m-d', $event->registration_end );
			$compare          = $now->getTimestamp() - $registration_end->getTimestamp();
			if ( 0 > $compare ) {
				continue;
			}

			if ( 1 === $weekday || 6 === $weekday || 0 === $weekday ) {
				continue;
			}

			if ( 2 === $weekday && ( 2 === $compare->days || 3 === $compare->days || 4 === $compare->days ) ) {
				RemindManagementAction::execute( $event );
			} elseif ( 2 !== $weekday && 2 === $compare->days ) {
				RemindManagementAction::execute( $event );
			}
		}
	}
}
