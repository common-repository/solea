<?php
/**
 * File: setup-objects.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package solea/Setup
 */

use Solea\App\models\Event;
use Solea\App\models\LocalGroup;
use Solea\App\models\Participant;

/**
 * Installs (if required) the objects as database
 *
 * @return void
 */
function solea_setup_objects() {
    $event = new Event();
    $event->setup();

    $participant = new Participant();
    $participant->setup();

    $local_group = new LocalGroup();
    $local_group->setup();

	if ( is_multisite() ) {
		$sites = get_sites();


		foreach ( $sites as $site ) {
			$current_blog_id = $site->blog_id;
			switch_to_blog( $current_blog_id );

			$event = new Event();
			$event->setup();

			$participant = new Participant();
			$participant->setup();

			$local_group = new LocalGroup();
			$local_group->setup();

			restore_current_blog();
		}
	}
}
