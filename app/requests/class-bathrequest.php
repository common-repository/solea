<?php
/**
 * File: class-bathrequest.php
 *
 * @since 2024-07-25
 * @license GPL-3.0-or-later
 *
 * @package Solae/Requests
 */

namespace Solea\App\Requests;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class BathRequest
 *
 * Represents a request for bathing information.
 *
 * @package Solae\Requests
 */
class BathRequest {
	/**
	 * Executes the bathing logic based on the bathing name.
	 *
	 * @param string $bathing_name The name of the bathing type.
	 *
	 * @return string|null The result of the bathing logic, or null if no match found.
	 */
	public static function execute( string $bathing_name ): ?string {
		switch ( $bathing_name ) {
			case 'complete':
				return __( 'Swimmer', 'solea' );

			case 'partial':
				return __( 'Non-Swimmer', 'solea' );

			case 'none':
				return __( 'No bath permission', 'solea' );
		}

		return null;
	}
}
