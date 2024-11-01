<?php
/**
 * File: class-getparticipationtype.php
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

use Solea\App\models\Participant;

/**
 * Class GetParticipationTypeName
 *
 * Executes the specified participation group and returns the corresponding label.
 */
class GetParticipationTypeName {
	/**
	 * Executes the specified participation group and returns the corresponding label.
	 *
	 * @param string $participationgroup The participation group to execute.
	 *
	 * @return string|null The label corresponding to the specified participation group,
	 *                    or null if the participation group is not recognized.
	 */
	public static function execute( string $participationgroup ): ?string {
		switch ( $participationgroup ) {
			case Participant::PARTICIPATION_GROUP_PARTICIPANT:
				return __( 'Participant', 'solea' );

			case Participant::PARTICIPATION_GROUP_ONLINE:
				return __( 'Online participant', 'solea' );

			case Participant::PARTICIPATION_GROUP_OTHER:
				return __( 'Other', 'solea' );

			case Participant::PARTICIPATION_GROUP_TEAM:
				return __( 'Teamer', 'solea' );

			case Participant::PARTICIPATION_GROUP_VOLUNTEER:
				return __( 'Volunteer', 'solea' );
		}

		return null;
	}
}
