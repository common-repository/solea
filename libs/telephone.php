<?php
/**
 * File: telephone.php
 *
 * @since 2024-07-25
 * @license GPL-3.0-or-later
 *
 * @package solea/
 */

/**
 * Generates a telephone link.
 *
 * @param string $telephonnumber The telephone number to be linked.
 * @param bool   $do_print Whether to directly print the link (default: false).
 *
 * @return string|null The HTML string for the telephone link if $print is false, otherwise null.
 */
function solea_get_telephone_link( string $telephonnumber, bool $do_print = false ): ?string {
	$number_international = $telephonnumber;
	if ( str_starts_with( $number_international, '0' ) ) {
		$number_international = '+49' . substr( $number_international, 1 );
	}
	if ( ! $do_print ) {
		return '<a href="tel:' . $number_international . '">' . $telephonnumber . '</a>';
	}

	?>
	<a href="tel:<?php echo esc_html( $number_international ); ?>"><?php echo esc_html( $telephonnumber ); ?></a>
	<?php
	return null;
}
