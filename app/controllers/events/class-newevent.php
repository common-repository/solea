<?php
/**
 * File: class-newevent.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package solea/Controllers/Events
 */

namespace solea\App\Controllers\Events;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\LocalGroup;

/**
 * Class NewEvent
 *
 * Handles the creation of new events by displaying a form for event creation.
 * It includes functionality to enqueue necessary scripts and load the form template.
 */
class NewEvent {

	/**
	 * Prints the event creation form.
	 *
	 * This method enqueues the necessary JavaScript files for the event creation form,
	 * retrieves all local groups, and includes the template for the new event form.
	 *
	 * @param string $slug The slug for the event, used for routing or form identification.
	 * @param bool   $mareike_active A boolean indicating if the plugin "mareike" is installed and, affecting form behavior or appearance.
	 *
	 * @return void
	 */
	public static function print_form( string $slug, bool $mareike_active ): void {
		if ( '' === $slug ) {
			wp_die( 'Internal error occured' );
		}

		$mareike_is_active = false;
		if ( $mareike_active ) {
			$mareike_is_active = true;
		}

		$plugin_data = get_plugin_data( SOLEA_PLUGIN_STARTUP_FILE );

		wp_enqueue_script(
			'solea-newevent',
			SOLEA_PLUGIN_URL . '/assets/javascripts/new-event-form.js',
			array(),
			$plugin_data['Version'],
			array( 'in_footer' => false )
		);

		$groups = LocalGroup::all();
		if ( count( $groups ) === 0 ) {
			wp_die( esc_html__( 'Please create at least one local group first.', 'solea' ) );
		}
		require SOLEA_TEMPLATE_DIR . '/events/new.php';
	}
}
