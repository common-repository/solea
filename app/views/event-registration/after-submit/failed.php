<?php
/**
 * File: failed.php
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
/* Translators: %s is the name of the participant */
	echo esc_html( wp_sprintf( __( 'Hello %s,', 'solea' ), $name ) );
?>
	</h3>
<p>
<?php echo esc_html__( 'Unfortunately, your registration could not be processed automatically. This is usually the case if the form contains data that cannot be processed automatically.', 'solea' ); ?><br />
	<?php echo esc_html__( 'The event management has already been informed and is attempting to complete the registration manually. You will be contacted by email afterwards or if you have any further questions.', 'solea' ); ?><br /><br />
	<?php echo esc_html__( 'If this does not happen within 5 days, please contact us by email:', 'solea' ); ?>
	<a href="mailto:<?php echo esc_html( $event->event_email ); ?>"><?php echo esc_html( $event->event_email ); ?></a>
	<br /><br /><br />
	<?php echo esc_html__( 'Please apologize for the inconvenience caused.', 'solea' ); ?>
</p>
