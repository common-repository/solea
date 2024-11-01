<?php
/**
 * File: arrival.php
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
	<tr style="vertical-align: top;">
		<td><?php echo esc_html__( 'Arrival:', 'solea' ); ?></td>
		<td>
			<input type="date" name="anreise" id="anreise" value="<?php echo esc_html( $event->date_begin ); ?>" /><br />
			<select name="anreise_essen">
				<option value="1" selected><?php echo esc_html__( 'Before dinner', 'solea' ); ?></option>
				<option value="2"><?php echo esc_html__( 'Before lunch', 'solea' ); ?></option>
				<option value="3"><?php echo esc_html__( 'Before breakfast', 'solea' ); ?></option>
				<option value="4"><?php echo esc_html__( 'For evening round / No meal on arrival day', 'solea' ); ?></option>
			</select>
		</td>
	</tr>

	<tr style="vertical-align: top;">
		<td><?php echo esc_html__( 'Departure:', 'solea' ); ?></td>
		<td>
			<input type="date" name="abreise" id="abreise" value="<?php echo esc_html( $event->date_end ); ?>" /><br />
			<select name="abreise_essen">
				<option value="1"><?php echo esc_html__( 'After breakfast', 'solea' ); ?></option>
				<option selected value="2"><?php echo esc_html__( 'After lunch', 'solea' ); ?></option>
				<option value="3"><?php echo esc_html__( 'After dinner', 'solea' ); ?></option>
				<option value="4"><?php echo esc_html__( 'Early morning / No meal on departure day', 'solea' ); ?></option>
			</select>
		</td>
	</tr>
</table>

<input type="hidden" id="solea_amount" name="solea_amount" value="<?php echo esc_html( $event->amount_participant ); ?>" />

<input type="button" value="<?php echo esc_html__( 'Previous', 'solea' ); ?>" onclick="showStep(4)" />
<input type="button" value="<?php echo esc_html__( 'Next', 'solea' ); ?>" onclick="checkAnreise()" />
