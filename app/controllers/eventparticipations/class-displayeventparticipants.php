<?php
/**
 * File: class-display-eventparticipants.php
 *
 * @since 2024-07-25
 * @license GPL-3.0-or-later
 *
 * @package Solea/Controllers/EventParticipations/
 */

namespace solea\App\Controllers\EventParticipations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\models\LocalGroup;

/**
 * Class DisplayEventParticipants
 *
 * Handles the display of participant information for a specific event.
 * Based on the active tab, it retrieves and displays different views of participant data.
 */
class DisplayEventParticipants {

	/**
	 * Executes the display logic for event participants based on the provided parameters.
	 *
	 * Loads different templates and data based on the active tab to show the relevant participant information.
	 *
	 * @param string $slug The URL slug for the event, used for routing or context.
	 * @param string $active_tab The identifier for the currently active tab. Determines which type of participant data to display. Possible values include:
	 *                           - 'tab1': Overview of total amount.
	 *                           - 'tab2': Participants grouped by local group.
	 *                           - 'tab3': Participants grouped by participation.
	 *                           - 'tab4': Unregistered participants.
	 *                           - 'tab5': Allowed groups for the event.
	 * @param int    $event_id The ID of the event for which participant information is being displayed.
	 *
	 * @return void
	 *
	 * @throws PermissionException If the user does not have permission to access the event.
	 * @throws FileNotFoundException If the required template files are not found.
	 */
	public static function execute( string $slug, string $active_tab, int $event_id ) {
		$event = Event::get_with_permission_check( $event_id );

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

		switch ( $active_tab ) {
			case 'tab1':
				$amount = $event->get_total_amount();
				require SOLEA_TEMPLATE_DIR . '/participants/overview.php';
				break;

			case 'tab2':
				$participant_groups = $event->get_participants_by_group();
				$filter             = 'localgroup';
				require SOLEA_TEMPLATE_DIR . '/participants/list.php';
				break;

			case 'tab3':
				$participant_groups = $event->get_participants_by_participation();
				$filter             = 'participation_group';
				require SOLEA_TEMPLATE_DIR . '/participants/list.php';
				break;

			case 'tab4':
				$participant_groups = $event->get_unregistered_participants();
				$filter             = 'deregistered';
				require SOLEA_TEMPLATE_DIR . '/participants/list.php';
				break;

			case 'tab5':
				$groups                   = LocalGroup::all();
				$allowed_group_collection = $event->get_allowed_groups();
				$allowed_groups           = array();
				foreach ( $allowed_group_collection as $_group ) {
					$allowed_groups[ $_group->id ] = $_group->name;
				}
				require SOLEA_TEMPLATE_DIR . '/events/edit.php';
				break;

		}

		require SOLEA_TEMPLATE_DIR . '/participants/getdetailshandler.php';
	}
}
