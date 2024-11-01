<?php
/**
 * File class-fileaccess.php
 *
 * Helper Class for file access
 *
 * @since 2024-07-16
 * @license GPL-3.0-or-later
 *
 * @package solea/Libs
 */

declare(strict_types=1);

namespace Solea\Libs;

/**
 * Helper Class for file access
 */
class FileAccess extends \WP_Filesystem_Direct {

	/**
	 * Constructor of class
	 *
	 * @param array $arg Permissions for new files  / directories.
	 */
	public function __construct( $arg = null ) {
	}

	/**
	 * Displays the content of a file for downloading
	 *
	 * @param string $filename Filename to download.
	 *
	 * @return void
	 */
	public function output_file( string $filename ) {
		print_r( $this->get_contents( $filename ) );
	}
}
