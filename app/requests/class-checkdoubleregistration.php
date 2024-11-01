<?php
/**
 * File: class-checkdoublieregistration.php
 *
 * @since 2024-07-23
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
 * Class CheckDoubleRegistration
 *
 * Executes a search query for a participant in the database based on the provided parameters.
 *
 * @package Solea\App\Requests
 */
class CheckDoubleRegistration {
	/**
	 * Executes a search query for a participant in the database based on the provided parameters.
	 *
	 * @param int    $event_id The ID of the event the participant is associated with.
	 * @param string $firstname The participant's first name.
	 * @param string $lastname The participant's last name.
	 * @param string $email The participant's email address.
	 * @param string $birthday The participant's birthday.
	 *
	 * @return bool Returns true if a participant is found in the database with the provided parameters, false otherwise.
	 */
	public static function execute( int $event_id, string $firstname, string $lastname, string $email, string $birthday ): bool {
		return count(
			Participant::where(
				array(
					'event_id'  => $event_id,
					'firstname' => $firstname,
					'lastname'  => $lastname,
					'email_1'   => $email,
					'birthday'  => $birthday,
				)
			)->get()
		) > 0;
	}
}
