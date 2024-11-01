<?php
/**
 * File: class-eatinghabit.php
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

/**
 * Class EatingHabit
 *
 * Executes eating habits based on the given habit name.
 */
class EatingHabit {
	/**
	 * Executes the given habit name and returns the corresponding string.
	 *
	 * @param string $habit_name The name of the habit to execute. Possible values: "all", "vegetarian", "vegan".
	 *
	 * @return string|null The corresponding string value for the given habit name. Returns null if the habit name is invalid.
	 */
	public static function execute( string $habit_name ): ?string {
		switch ( $habit_name ) {
			case 'all':
				return __( 'Meat', 'solea' );
			case 'vegetarian':
				return __( 'Vegetarian', 'solea' );
			case 'vegan':
				return __( 'Vegan', 'solea' );
		}
		return null;
	}
}
