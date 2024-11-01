<?php
/**
 * File: class-listavailableevents.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package Solea/Controllers/Events/
 */

namespace solea\App\Controllers\Events;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;

/**
 * Class ListAvailableEvents
 *
 * Provides functionality to list events that are currently open and available to the public.
 * It retrieves a list of open events and includes a template to display these events on a public-facing page.
 */
class ListAvailableEvents {

	/**
	 * Retrieves and displays a list of open events available to the public.
	 *
	 * This method fetches all events that are currently open for registration or participation
	 * and includes a template to present these events on a public-facing page.
	 *
	 * @return void
	 */
	public static function execute_from_public() {
		$events = Event::list_open_events();

		require SOLEA_TEMPLATE_DIR . '/events/public-available-events.php';
	}
}
