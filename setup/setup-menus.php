<?php
/**
 * Contains the setup for menu structure
 *
 * @package solea/Setup
 */

use Solea\App\Controllers\profile\CheckProfile;
use Solea\App\models\Event;

/**
 * Adds a submenu page to the WordPress settings menu.
 *
 * This method adds a new submenu page to the "settings.php" menu in the WordPress admin dashboard.
 * The submenu page will be titled "Local groups" and can be accessed by users with the capability "edit_solea_settings".
 * The menu page will be located as a submenu item under the "settings.php" menu.
 *
 * @return void
 */
function solea_network_add_menu() {
	add_submenu_page(
		'settings.php',
		__( 'Local groups', 'solea' ),
		__( 'Local groups', 'solea' ),
		'edit_solea_settings',
		'solea-localgroups',
		array( 'Solea\App\Routers\DashboardRouter', 'execute' ),
	);
}

/**
 * Adds the menu structure in dashboard
 *
 * @return void
 */
function solea_add_menu() {
	solea_setup_objects();

	CheckProfile::execute();

	$_SESSION['solea_nonce'] = esc_html( wp_create_nonce() );
	add_submenu_page(
		'users.php',
		__( 'Participation information', 'solea' ),
		__( 'Participation information', 'solea' ),
		'read',
		'solea-profile',
		array( 'Solea\App\Routers\DashboardRouter', 'execute' ),
	);

	add_submenu_page(
		'options-general.php',
		__( 'solea settings', 'solea' ),
		__( 'solea settings', 'solea' ),
		'manage_options',
		'solea-settings',
		array( 'Solea\App\Routers\DashboardRouter', 'execute' ),
	);

	if ( ! is_multisite() ) {
		add_submenu_page(
			'options-general.php',
			__( 'Local groups', 'solea' ),
			__( 'Local groups', 'solea' ),
			'edit_solea_settings',
			'solea-localgroups',
			array( 'Solea\App\Routers\DashboardRouter', 'execute' ),
		);
	}

	add_menu_page(
		__( 'Signup for event', 'solea' ),
		__( 'Signup for event', 'solea' ),
		'read',
		'solea-signupp-for-event',
		array( 'Solea\App\Routers\DashboardRouter', 'execute' ),
		'dashicons-tickets',
		3
	);

	add_menu_page(
		__( 'Events', 'solea' ),
		__( 'Events', 'solea' ),
		'edit_events',
		'solea-list-events',
		array( 'Solea\App\Routers\DashboardRouter', 'execute' ),
		'dashicons-tickets-alt',
		3
	);

	foreach ( Event::list_with_permissions( false ) as $current_event ) {
		add_submenu_page(
			'solea-list-events',
			esc_html( $current_event->event_name ),
			esc_html( $current_event->event_name ),
			'edit_events',
			'solea-show-event_' . $current_event->id,
			array( 'Solea\App\Routers\DashboardRouter', 'execute' )
		);
	}

	add_submenu_page(
		'solea-list-events',
		__( 'New event', 'solea' ),
		__( 'New event', 'solea' ),
		'edit_events',
		'solea-add-event',
		array( 'Solea\App\Routers\DashboardRouter', 'execute' ),
	);
}
