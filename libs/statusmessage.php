<?php
/**
 * Conatins function for displaying the status box
 *
 * @package Solea/Core
 */

/**
 * Function to display status message box
 *
 * @param string $message   The message to display.
 * @param bool   $succeeded   Show if a success message (error message otherwise).
 *
 * @return void
 */
function solea_show_message( string $message, bool $succeeded = true ) {
	echo '<div class="notice notice-' . ( $succeeded ? 'success' : 'error' ) . '" style="padding: 5px 10px;">';
	echo nl2br( esc_html( $message ) );
	echo '</div>';
}
