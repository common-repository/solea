<?php
/**
 * File: age.php
 *
 * @since 2024-07-23
 * @license GPL-3.0-or-later
 *
 * @package Solea/libs
 */

/**
 * Checks if a person is 18 years or older based on their birthday.
 *
 * @param string $birthday The person's birthday in 'Y-m-d' format.
 * @return bool True if the person is 18 years or older, false otherwise.
 */
function solea_is_fullaged( string $birthday ): bool {
	$obj_birthday = \DateTime::createFromFormat( 'Y-m-d', $birthday );
	$today        = new DateTime();
	$compare      = date_diff( $today, $obj_birthday );
	return $compare->y >= 18;
}

/**
 * Determines if a person is old enough to drink alcohol based on their birthday and the event's age limit.
 *
 * @param Event  $event An Event object containing the required age limit for drinking alcohol.
 * @param string $birthday The person's birthday in 'Y-m-d' format.
 * @return bool Returns true if the person is old enough to drink alcohol based on the event's age limit,
 *              otherwise returns false.
 */
function solea_can_drink_alcoholics( Event $event, string $birthday ): bool {
	$obj_birthday = \DateTime::createFromFormat( 'Y-m-d', $birthday );
	$today        = new DateTime();
	$compare      = date_diff( $today, $obj_birthday );
	return $compare->y >= (int) $event->age_alcoholics;
}

/**
 * Calculates the age of a person based on their birthday.
 *
 * @param string $birthday The person's birthday in 'Y-m-d' format.
 * @return int The age of the person.
 */
function solea_get_age( string $birthday ): int {
	$obj_birthday = \DateTime::createFromFormat( 'Y-m-d', $birthday );
	$today        = new DateTime();
	$compare      = date_diff( $today, $obj_birthday );
	return $compare->y;
}
