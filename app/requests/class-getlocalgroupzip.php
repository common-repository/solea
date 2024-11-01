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
 * Class to get ZipCode of a local group
 */
class GetLocalGroupZip {
	/**
	 * Executes the execute method.
	 *
	 * @param int $localgroup_id Id of local group.
	 */
	public static function execute( int $localgroup_id ): ?string {
		$group = LocalGroup::where( 'id', $localgroup_id )->first();
		if ( null === $group ) {
			return null;
		}
		return $group->zip;
	}
}
