<?php
/**
 * File: multisite.php
 *
 * @since 2024-08-23
 * @license GPL-3.0-or-later
 *
 * @package solea/Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\models\LocalGroup;
use Solea\App\models\Participant;

/**
 * Sets up a new blog with necessary configurations and data.
 *
 * @param object $new_site The new site object.
 * @param array  $args Additional arguments (optional).
 *
 * @return void
 */
function solea_new_blog_setup( $new_site, $args ) {
	$blog_id = $new_site->id;

	$icon_children = get_option( 'solea_icon_children', SOLEA_PLUGIN_URL . '/assets/images/children.svg' );
	$icon_audlt    = get_option( 'solea_icon_adults', SOLEA_PLUGIN_URL . '/assets/images/adults.svg' );
	$all_groups    = LocalGroup::all();

	switch_to_blog( $blog_id );
	$event = new Event();
	$event->setup();

	$participant = new Participant();
	$participant->setup();

	$local_group = new LocalGroup();
	$local_group->setup();

	update_option( 'solea_icon_children', $icon_children );
	update_option( 'solea_icon_adults', $icon_audlt );

	foreach ( $all_groups as $current_group ) {
		LocalGroup::create(
			array(
				'name'          => $current_group->name,
				'email'         => $current_group->email,
				'zip'           => $current_group->zip,
				'city'          => $current_group->city,
				'members_email' => $current_group->members_email,
			)
		);
	}

	restore_current_blog();
}
