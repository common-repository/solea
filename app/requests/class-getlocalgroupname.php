<?php
/**
 * File: class-getlocalgroupname.php
 *
 * @since 2024-07-25
 * @license GPL-3.0-or-later
 *
 * @package Solae/Requests/
 */

namespace Solea\App\Requests;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\LocalGroup;

/**
 * Class GetLocalGroupName
 *
 * A class for getting the name of a local group by its ID.
 */
class GetLocalGroupName {
	/**
	 * Execute the method.
	 *
	 * @param int $localgroup_id The ID of the local group.
	 *
	 * @return string|null The name of the local group if found, or null if not found.
	 */
	public static function execute( int $localgroup_id ): ?string {
		$group = LocalGroup::where( 'id', $localgroup_id )->first();
		if ( null === $group ) {
			return null;
		}
		return $group->name;
	}
}
