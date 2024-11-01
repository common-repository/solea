<?php
/**
 * File: amount.php
 *
 * @since 2024-07-22
 * @license GPL-3.0-or-later
 *
 * @package solea/Libs/
 */

/**
 * Formats a float number to an amount
 *
 * @param float  $value The value of the new amount.
 * @param string $currency The currency that should be appended the amount.
 *
 * @return string
 */
function solea_format_amount( float $value, string $currency = ' Euro' ): string {
	$value = number_format( round( $value, 2 ), 2, ',', '.' );
	return (string) $value . $currency;
}
