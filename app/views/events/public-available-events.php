<?php
/**
 * File: public-available-events.php
 *
 * @since 2024-07-28
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/event
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<h2><?php echo esc_html__( 'Available events', 'solea' ); ?></h2>

<?php
if ( count( $events ) === 0 ) {
	?>
	<p><?php echo esc_html__( 'There is currently no event, where you can register for.', 'solea' ); ?></p>
	<?php
	return;
}

foreach ( $events as $event ) {
	$event_start      = \DateTime::createFromFormat( 'Y-m-d', $event->date_begin )->format( 'd.m.Y' );
	$event_end        = \DateTime::createFromFormat( 'Y-m-d', $event->date_end )->format( 'd.m.Y' );
	$registration_end = \DateTime::createFromFormat( 'Y-m-d', $event->registration_end )->format( 'd.m.Y' );
	?>
	<table style="margin-bottom: 50px; padding: 10px; border-color: #c0c0c0; border-radius: 10px; box-shadow: 10px 10px 10px #c0c0c0; width: 768px; border-style: solid; border-width: 1px;">
		<tr><td colspan="2"><h3><?php echo esc_html( $event->event_name ); ?></h3></td></tr>
		<tr>
			<td><?php echo esc_html__( 'Event date', 'solea' ); ?></td>
			<td>
				<?php echo esc_html( $event_start . ' - ' . $event_end ); ?>
			</td>
		</tr>
		<tr>
			<td><?php echo esc_html__( 'Registration until', 'solea' ); ?></td>
			<td>
				<?php echo esc_html( $registration_end ); ?>
			</td>
		</tr>

		<tr>
			<td colspan="2">
				<a style="text-decoration: none; color: #7a7aff; font-weight: bold;"
					href="<?php echo esc_url( $event->event_url ); ?>"><?php echo esc_html__( 'Register now', 'solea' ); ?>
				</a>
			</td>
		</tr>
	</table>
	<?php
}
