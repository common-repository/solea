<?php
/**
 * File: class-weeklyinformmanagement.php
 *
 * @since 2024-07-29
 * @license GPL-3.0-or-later
 *
 * @package Solea/Tasks/
 */

namespace Solea\App\Tasks;

use Solea\App\Actions\Events\InformEventManagement;
use Solea\App\models\Event;

/**
 * Class WeeklyInformManagement
 *
 * This class is responsible for executing the weekly inform management process.
 * It lists all open events and calls the InformEventManagement class to execute the inform process for each event.
 */
class WeeklyInformManagement {
	/**
	 * Executes the `execute` method
	 *
	 * This method is responsible for executing the logic to inform the `InformEventManagement` class about all the open events.
	 *
	 * @return void
	 */
	public static function execute() {
		$now = new \DateTime();
		foreach ( Event::list_open_events() as $event ) {
			if ( ! $event->weekly_report ) {
				continue;
			}

			InformEventManagement::execute( $event );
		}
	}
}
