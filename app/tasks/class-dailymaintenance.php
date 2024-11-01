<?php
/**
 * File: class-dailymaintenance.php
 *
 * @since 2024-07-29
 * @license GPL-3.0-or-later
 *
 * @package Solea/Tasks
 */

namespace Solea\App\Tasks;

use solea\App\Actions\Events\AwarenessManagement;
use Solea\App\Actions\Events\InformEventManagement;
use Solea\App\models\Event;

/**
 * Class DailyMaintenance
 *
 * Performs daily maintenance tasks related to events.
 */
class DailyMaintenance {
	/**
	 * Executes the event registration process.
	 *
	 * This method checks for open events and updates their signup status based on the registration end date.
	 * If the registration end date has passed, the event's signup_allowed attribute will be set to false and the event will be saved.
	 * It also notifies the event management system about the updated event using the InformEventManagement::execute() method.
	 *
	 * @return void
	 */
	public static function execute() {
		$now = new \DateTime();
		foreach ( Event::list_open_events() as $event ) {
			$registration_end = \DateTime::createFromFormat( 'Y-m-d', $event->registration_end );

			$compare = $now->getTimestamp() - $registration_end->getTimestamp();

			if ( 0 > $compare ) {
				continue;
			}

			$awareness_management = AwarenessManagement::get_instance( $event );
			$awareness_management->send_signup_mails();

			$event->signup_allowed = false;
			$event->save();

			InformEventManagement::execute( $event );
		}
	}
}
