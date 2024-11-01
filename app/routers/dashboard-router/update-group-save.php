<?php
/**
 * File: update-group-save.php
 *
 * @since 2024-07-22
 * @license GPL-3.0-or-later
 *
 * @package package solea/Routers/Partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\LocalGroup;

if ( ! isset( $_SESSION['solea_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['solea_nonce'] ) ) ) ) {
	wp_die( 'Invalid Router call' );
}

if (
	! isset( $_REQUEST['group-id'] ) ||
	! isset( $_REQUEST['group_name'] ) ||
	! isset( $_REQUEST['group_email'] ) ||
	! isset( $_REQUEST['group_members_email'] ) ||
	! isset( $_REQUEST['group_zip'] ) ||
	! isset( $_REQUEST['group_city'] )
) {
	wp_die( 'Missing form params for creating a group.' );
}


if ( is_multisite() ) {
	$sites = get_sites();

	foreach ( $sites as $site ) {
		$current_blog_id = $site->blog_id;
		switch_to_blog( $current_blog_id );
		$group = LocalGroup::where( 'id', (int) sanitize_key( wp_unslash( $_REQUEST['group-id'] ) ) )->first();

		$group->name          = sanitize_text_field( wp_unslash( $_REQUEST['group_name'] ) );
		$group->email         = sanitize_email( wp_unslash( $_REQUEST['group_email'] ) );
		$group->members_email = sanitize_email( wp_unslash( $_REQUEST['group_members_email'] ) );
		$group->zip           = sanitize_text_field( wp_unslash( $_REQUEST['group_zip'] ) );
		$group->city          = sanitize_text_field( wp_unslash( $_REQUEST['group_city'] ) );

		$group->save();
		restore_current_blog();
	}
} else {
	$group = LocalGroup::where( 'id', (int) sanitize_key( wp_unslash( $_REQUEST['group-id'] ) ) )->first();

	$group->name          = sanitize_text_field( wp_unslash( $_REQUEST['group_name'] ) );
	$group->email         = sanitize_email( wp_unslash( $_REQUEST['group_email'] ) );
	$group->members_email = sanitize_email( wp_unslash( $_REQUEST['group_members_email'] ) );
	$group->zip           = sanitize_text_field( wp_unslash( $_REQUEST['group_zip'] ) );
	$group->city          = sanitize_text_field( wp_unslash( $_REQUEST['group_city'] ) );

	$group->save();
}

solea_show_message( __( 'The local group was updated', 'solea' ) );
