<?php
/**
 * File: allergies.php
 *
 * @since 2024-07-22
 * @license GPL-3.0-or-later
 *
 * @package Solea/Views/Registration/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<table>
	<tr>
		<td><?php echo esc_html__( 'Allergies', 'solea' ); ?>:</td>
		<td><input value="<?php echo esc_html( $allergies ); ?>" type="text" name="allergien" /></td>
	</tr>
	<tr>
		<td><?php echo esc_html__( 'Food intolerances', 'solea' ); ?>:</td>
		<td><input value="<?php echo esc_html( $intolerances ); ?>" type="text" name="intolerances" /></td>
	</tr>
	<tr>
		<td><?php echo esc_html__( 'Medications', 'solea' ); ?>:</td>
		<td>
			<input value="<?php echo esc_html( $medication ); ?>" type="text" name="medikamente" />*<br />
			<?php echo esc_html__( 'You must bring sufficient quantities of medication with you.', 'solea' ); ?>
		</td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'Eating habits', 'solea' ); ?>:</td>
		<td>
			<select name="essgewohnheit">
				<?php
				if ( $event->enable_all_eating ) {
					?>
						<option value="all"><?php echo esc_html__( 'I also eat meat', 'solea' ); ?></option>
						<?php
				}
				?>
				<option value="vegetarian"><?php echo esc_html__( 'Vegetarian', 'solea' ); ?></option>
				<option value="vegan"><?php echo esc_html__( 'Vegan', 'solea' ); ?></option>
			</select>
		</td>
	</tr>

	<tr style="vertical-align: top;">
		<td><?php echo esc_html__( 'What else would you like to tell us', 'solea' ); ?>:</td>
		<td><textarea rows=15 name="anmerkungen"></textarea></td>
	</tr>
</table>
<input type="checkbox" name="amount_accept" id="amount_accept" />
<label for="amount_accept" id="amount_text">

	<?php echo esc_html__( 'I would like to register for the event', 'solea' ); ?>&nbsp;
	<?php
	$registration_url = get_option( 'solea_registration_order_url', '' );
	if ( trim( $registration_url ) !== '' ) {
		echo esc_html__( 'and have been informed about the cancellation conditions.', 'solea' );
		?>
			<a href="<?php echo esc_url( $registration_url ); ?>" target="_blank">
				<?php echo esc_html__( 'Registration and Cancellation order', 'solea' ); ?>
				<span class="dashicons dashicons-migrate"></span>
			</a>
		<?php
	} else {
		?>
		.
		<?php
	}
	?>
	<br />
	<?php echo esc_html__( 'I will pay the total amount of', 'solea' ); ?> <label style="font-weight: bold;" id="total_amount">
		<?php
		echo esc_html( solea_format_amount( $amount ) );
		?>
		</label>
	<?php echo esc_html__( 'in accordance with the information provided in the incoming email.', 'solea' ); ?>
</label>
<br />
<input type="checkbox" name="_dsgvo_accept" id="dsgvo_accept" />
<label for="dsgvo_accept" id="dsgvo_text">
	<?php echo esc_html__( 'I agree that the data I have entered here will be transmitted and stored electronically for the purpose of event registration and billing.', 'solea' ); ?>
</label>
<br /><br />
<input type="button" value="<?php echo esc_html__( 'Previous', 'solea' ); ?>" onclick="showStep(7)" />
<input type="submit" value="Anmeldung durchführen" style="width: 200px;"/>
