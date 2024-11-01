<?php
/**
 * File: class-editparticipant.php
 *
 * @since 2024-07-26
 * @license GPL-3.0-or-later
 *
 * @package Solea/Controllers/EventParticipations/
 */

namespace solea\App\Controllers\EventParticipations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\models\Participant;

/**
 * Class EditParticipant
 *
 * Handles the logic for displaying the participant edit interface.
 * It prepares the necessary data and loads the appropriate templates for editing participant details.
 */
class EditParticipant {

	/**
	 * Executes the logic to display the participant edit interface.
	 *
	 * Retrieves the event associated with the participant and then includes the necessary templates
	 * for displaying the participant edit form. The method also handles the current tab being active
	 * to display the appropriate section of the participant's details.
	 *
	 * @param string      $slug         A slug representing the current page or context. This can be used for determining the correct template or functionality.
	 * @param string      $active_tab   The identifier for the currently active tab. This helps in displaying the relevant tab content.
	 * @param Participant $participant The participant object containing the details of the participant to be edited.
	 *
	 * @return void
	 */
	public static function execute( string $slug, string $active_tab, Participant $participant ) {
		$event = Event::get_with_permission_check( $participant->event_id );

		$plugin_data = get_plugin_data( SOLEA_PLUGIN_STARTUP_FILE );
		wp_enqueue_script(
			'solea-participant-script',
			SOLEA_PLUGIN_URL . '/assets/javascripts/participant.js',
			array(),
			$plugin_data['Version'],
			array( 'in_footer' => false )
		);

		wp_enqueue_style(
			'solea-participant-style',
			SOLEA_PLUGIN_URL . '/assets/stylesheets/participant.css',
			array(),
			$plugin_data['Version']
		);

		require SOLEA_TEMPLATE_DIR . '/participants/index.php';

		require SOLEA_TEMPLATE_DIR . '/participant-update/index.php';
	}
}
