<?php
/**
 * File: capabilities.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package solea/
 */

/**
 * Returns the capabilites for role default user
 *
 * @return array
 */
function solea_get_capabilities_user(): array {
	return array(
		'add_invoice'  => true,
		'edit_profile' => true,
		'read'         => true,
	);
}

/**
 * Returns the capabilites for role director
 *
 * @return array
 */
function solea_get_capabilities_director(): array {
	return array_merge(
		array(
			'edit_solea_settings' => true,
			'create_users'        => true,
			'edit_users'          => true,
			'delete_users'        => true,
		),
		solea_get_capabilities_organisator()
	);
}

/**
 * Returns the capabilites for role organisator
 *
 * @return array
 */
function solea_get_capabilities_organisator(): array {
	return array_merge(
		array(
			'edit_events' => true,
		),
		solea_get_capabilities_user()
	);
}
