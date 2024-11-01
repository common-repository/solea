<?php
/**
 * File: new-group-save.php
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
		LocalGroup::create(
			array(
				'name'          => sanitize_text_field( wp_unslash( $_REQUEST['group_name'] ) ),
				'email'         => sanitize_email( wp_unslash( $_REQUEST['group_email'] ) ),
				'members_email' => sanitize_email( wp_unslash( $_REQUEST['group_members_email'] ) ),
				'zip'           => sanitize_text_field( wp_unslash( $_REQUEST['group_zip'] ) ),
				'city'          => sanitize_text_field( wp_unslash( $_REQUEST['group_city'] ) ),
			)
		);
		restore_current_blog();
	}
} else {
	LocalGroup::create(
		array(
			'name'          => sanitize_text_field( wp_unslash( $_REQUEST['group_name'] ) ),
			'email'         => sanitize_email( wp_unslash( $_REQUEST['group_email'] ) ),
			'members_email' => sanitize_email( wp_unslash( $_REQUEST['group_members_email'] ) ),
			'zip'           => sanitize_text_field( wp_unslash( $_REQUEST['group_zip'] ) ),
			'city'          => sanitize_text_field( wp_unslash( $_REQUEST['group_city'] ) ),
		)
	);
}




solea_show_message( __( 'The local group was created', 'solea' ) );
