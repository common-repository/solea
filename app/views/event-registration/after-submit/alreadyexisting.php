<?php
/**
 * File: alreadyexisting.php
 *
 * @since 2024-07-24
 * @license GPL-3.0-or-later
 *
 * @package Solea/Views/Registration
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<h3>
<?php
	/* Translators: %s Name of participant */
	echo esc_html( wp_sprintf( __( 'Hello %s,', 'solea' ), $name ) );
?>
	</h3>
<p>
	<?php echo esc_html__( 'Unfortunately, your registration could not be processed because you are already registered for this event.', 'solea' ); ?><br />
		<?php echo esc_html__( 'If you were unregistered and want to register again or have any questions, please contact the event management by email:', 'solea' ); ?>
	<a href="mailto:<?php echo esc_html( $event->event_email ); ?>"><?php echo esc_html( $event->event_email ); ?></a>
</p>
