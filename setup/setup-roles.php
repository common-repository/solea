<?php
/**
 * File: setup-roles.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package solea/Setup
 */

/**
 * Installs the roles required
 *
 * @return void
 */
function solea_setup_roles(): void {

	$role = get_role( 'user' );
	if ( null === $role ) {
		add_role(
			'user',
			__( 'Default user', 'solea' ),
			solea_get_capabilities_user()
		);
	} else {
		foreach ( solea_get_capabilities_user() as $capability => $value ) {
			$role->add_cap( $capability );
		}
	}

	$role = get_role( 'director' );
	if ( null === $role ) {
		add_role(
			'director',
			true === (bool) get_option( 'page_used_for_state', false )
				? __( 'State director', 'solea' )
				: __( 'Club director', 'solea' ),
			solea_get_capabilities_director()
		);
	} else {
		$role = get_role( 'director' );
		foreach ( solea_get_capabilities_director() as $capability => $value ) {
			$role->add_cap( $capability );
		}
	}

	$role = get_role( 'administrator' );
	foreach ( solea_get_capabilities_director() as $capability => $value ) {
		$role->add_cap( $capability );
	}

	add_role( 'organisator', __( 'Event management', 'solea' ), solea_get_capabilities_organisator() );
}
