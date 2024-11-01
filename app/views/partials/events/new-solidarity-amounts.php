<?php
/**
 * File: new-solidarity-amounts.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/Partials/event
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<tr>
	<td>
		<?php echo esc_html__( 'Solidarity amount', 'solea' ); ?>:
	</td>
	<td>
		<input type="text" name="solidary_amount"
				placeholder="<?php echo esc_html__( 'Keep free to disable this option', 'solea' ); ?>"
		/> Euro
	</td>
</tr>

<tr>
	<td>
		<?php echo esc_html__( 'regular amount', 'solea' ); ?>:
	</td>
	<td>
		<input type="text" name="regular_amount" value="60,00" /> Euro
	</td>
</tr>

<tr>
	<td>
		<?php echo esc_html__( 'Reduced amount', 'solea' ); ?>:
	</td>
	<td>
		<input type="text" name="reduced_amount"
				placeholder="<?php echo esc_html__( 'Keep free to disable this option', 'solea' ); ?>"
		/> Euro
	</td>
</tr>
<tr>
	<td>
		<?php echo esc_html__( 'Increase amount by', 'solea' ); ?>:
	</td>
	<td>                    <input
			type="text"
			name="lastminute_amount"
			value="50" style="width: 50px;"/> %
	</td>
</tr>
<tr>
	<td style="text-align: right;">
		<?php echo esc_html__( 'For registrations from', 'solea' ); ?>:
	</td>
	<td><input type="date" name="last_minute_begin" id="last_minute_begin" /></td>
</tr>

<tr>
	<td colspan="2">
		<input type="submit" class="button" value="<?php echo esc_html__( 'Create event', 'solea' ); ?>" />
	</td>
</tr>
