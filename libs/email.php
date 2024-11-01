<?php
/**
 * File: email.php
 *
 * @since 2024-07-26
 * @license GPL-3.0-or-later
 *
 * @package solea/
 */

/**
 * Generates an email link.
 *
 * @param string $email The email address to be linked.
 * @param bool   $doprint Whether to directly print the link (default: false).
 *
 * @return string|null The HTML string for the email link if $print is false, otherwise null.
 */
function solea_get_email_link( string $email, bool $doprint = false ): ?string {
	if ( ! $doprint ) {
		return '<a href="mailto:' . $email . '">' . $email . '</a>';
	} else {
		?>
		<a href="mailto:<?php echo esc_html( $email ); ?>"><?php echo esc_html( $email ); ?></a>
		<?php
	}
	return null;
}
