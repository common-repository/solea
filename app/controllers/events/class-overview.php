<?php
/**
 * Class Overview
 *
 * This class represents the Events Overview Controller.
 *
 * @package solea\App\Controllers\Events
 */

namespace solea\App\Controllers\Events;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Overview
 */
class Overview {

	/**
	 * Executes the method.
	 *
	 * @return void
	 */
	public static function execute() {

		require SOLEA_TEMPLATE_DIR . '/events/overview.php';
	}
}
