<?php
/**
 * File: success.php
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
echo /* Translators: %s is name of the participant */
	esc_html( wp_sprintf( __( 'Hello %s,', 'solea' ), $nicename ) );
?>
	</h3>
<p>
	<?php
	echo esc_html(
		wp_sprintf(
		/* Translators: %s is the name of the event */
			__(
				'Your registration for the event "%s" was successful. We have recorded the following data:',
				'solea'
			),
			$event->event_name
		)
	);
	?>
<table>
	<tr><td><?php echo esc_html__( 'Arrival', 'solea' ); ?>:</td><td><?php echo esc_html( $arrival ); ?></td></tr>
	<tr><td><?php echo esc_html__( 'Departure', 'solea' ); ?>:</td><td><?php echo esc_html( $departure ); ?></td></tr>
	<tr><td><?php echo esc_html__( 'Eating habit', 'solea' ); ?>:</td><td><?php echo esc_html( $eating_habit ); ?></td></tr>
</table>

<?php echo esc_html__( 'If this is not correct, or if you have urgent questions, please contact', 'solea' ); ?> &nbsp;
<a href="mailto:<?php echo esc_html( $event->event_email ); ?>"><?php echo esc_html__( 'The event management crew', 'solea' ); ?></a>
( <?php echo esc_html( $event->event_email ); ?> )
</p>
<p>
	<?php echo esc_html__( 'Please also contact us if you have not received a confirmation email within 3 days.', 'solea' ); ?>
</p>


<?php
if ( $event->payment_direct && 0 <= $participant->amount ) {
	?>
	<p>
		<?php echo esc_html__( 'To complete your registration, please transfer the registration amount immediately to the following bank account:', 'solea' ); ?>
		<table>
			<tr><td><?php echo esc_html__( 'Account owner', 'solea' ); ?>:</td><td><?php echo esc_html( $event->account_owner ); ?></td>
				<td rowspan="4">
					<?php
					$amount = str_replace( ',', '.', solea_format_amount( $participant->amount, '' ) );

					$qrcode = admin_url(
						'admin-ajax.php?action=solea_show_ajax&&method=generate-payment-link&amount=' . $amount .
						'&recipient=' . $event->account_owner .
						'&iban=' . $event->account_iban .
						'&subject=' . $payment_purpose
					);
					?>


					<img style="padding-left: 20px; padding-bottom: 0; width: 150px; height: 150px;" src="<?php echo esc_url( $qrcode ); ?>" />
					<p style="font-size: 8pt; width: 100%; text-align: center; margin-top: -20px;">
					<?php echo esc_html__( 'Giro-Code', 'solea' ); ?></p>
				</td>
			</tr>

			<tr><td><?php echo esc_html__( 'IBAN', 'solea' ); ?>:</td><td><?php echo esc_html( $event->account_iban ); ?></td></tr>
			<tr><td><?php echo esc_html__( 'Purpose', 'solea' ); ?>:</td><td><?php echo esc_html( $payment_purpose ); ?></td></tr>
			<tr style="font-weight: bold;"><td><?php echo esc_html__( 'Total amount', 'solea' ); ?>:</td><td><?php echo esc_html( solea_format_amount( $participant->amount ) ); ?></td></tr>
		</table><br /><br />
		<?php
		/* Translators: %s is registration end date */
		echo esc_html( wp_sprintf( __( 'Please note that your registration may be cancelled if payment is not received in the specified account by %s.', 'solea' ), $registration_end ) );
		?>
	<br />
		<?php echo esc_html__( 'If payment is not possible or only partially possible within this period, please contact the event management.', 'solea' ); ?>

		</p>
	</p>

	<?php
} else {
	?>
	<p>
		<?php echo esc_html__( 'You do not have to pay the registration fee. This is the case if participation is supported, billing is done through your local group, or there are other decisions.', 'solea' ); ?><br />
		<?php echo esc_html__( 'Your registration is complete now.', 'solea' ); ?>
	</p>
	<?php


}
