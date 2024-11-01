<?php
/**
 * File: amount.php
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
		<td>Beitrag:</td>
		<td style="text-align: left;">
			<input checked onchange="solea_calc_total_amount('regular');" style="width: 20px !important;" type="radio"  name="beitrag" value="regular" id="amount_regular">
			<label for="amount_regular">
				<?php echo esc_html__( 'Regular amount', 'solea' ); ?>
				<?php echo esc_html( solea_format_amount( $event->amount_participant ) ); ?>
			</label><br />

			<?php
			if ( null !== $event->amount_reduced ) {
				?>
					<input onchange="solea_calc_total_amount('reduced');" style="width: 20px !important;" type="radio" name="beitrag" value="reduced" id="amount_reduced">
					<label for="amount_reduced">
					<?php echo esc_html__( 'Funded amount', 'solea' ); ?>
					<?php echo esc_html( solea_format_amount( $event->amount_reduced ) ); ?>
						<span style="font-size: 10pt; font-weight: bold;">(<?php echo esc_html__( 'depending on availability', 'solea' ); ?>)</span>
					</label><br />
					<?php
			}
			?>

			<?php
			if ( null !== $event->amount_social ) {
				?>
				<input onchange="solea_calc_total_amount('social');" style="width: 20px !important;" type="radio" name="beitrag" value="social" id="amount_social">
				<label for="amount_social">
					<?php echo esc_html__( 'Social contribution', 'solea' ); ?>
					<?php echo esc_html( solea_format_amount( $event->amount_social ) ); ?>
				</label><br />
				<?php
			}
			?>
		</td>
	</tr>
</table>
<input type="button" value="<?php echo esc_html__( 'Previous', 'solea' ); ?>" onclick="showStep(5)" />
<input type="button" value="<?php echo esc_html__( 'Next', 'solea' ); ?>" onclick="showStep(7);" />
