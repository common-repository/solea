<?php
/**
 * File: uninstall.php
 *
 * DESCRIPTION
 *
 * @since 2024-07-19
 * @license GPL-3.0-or-later
 *
 * @package solea/
 */

use Solea\App\models\Event;
use Solea\App\models\LocalGroup;
use Solea\App\models\Participant;

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

global $wpdb;

$options = array(
	'solea_icon_children',
	'solea_icon_adults',
);

$event = new Event();
$event->uninstall();

$participant = new Participant();
$participant->setup();

$local_group = new LocalGroup();
$local_group->setup();

$user_meta_keys = array(
	'telephone',
	'localgroup',
	'street',
	'housenumber',
	'zipcode',
	'city',
	'allergies',
	'medication',
	'birthday',
	'solea_nickname',
);

foreach ( $options as $option ) {
	delete_option( $option );
}

$user_ids = get_users( array( 'fields' => 'ID' ) );
foreach ( $user_ids as $user_id ) {
	foreach ( $user_meta_keys as $meta_key ) {
		delete_user_meta( $user_id, $meta_key );
	}
}
