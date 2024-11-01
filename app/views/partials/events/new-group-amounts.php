<?php
/**
 * File: new-group-amounts.php
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
		<?php echo esc_html__( 'Amount for teamer', 'solea' ); ?>:
	</td>
	<td>
		<input
			type="text"
			name="amount_teamer"
			placeholder="<?php echo esc_html__( 'Keep free to disable this group', 'solea' ); ?>"
			/> Euro / <?php echo esc_html__( 'day', 'solea' ); ?>
	</td>
</tr>
<tr>
	<td style="text-align: right;">
		<?php echo esc_html__( 'Description for group', 'solea' ); ?>:
	</td>
	<td><input type="text" name="description_teamer" /></td>
</tr>

<tr>
	<td>
		<?php echo esc_html__( 'Amount for volunteers', 'solea' ); ?>:
	</td>
	<td>                    <input
				type="text"
				name="amount_volunteer"
				placeholder="<?php echo esc_html__( 'Keep free to disable this group', 'solea' ); ?>"
		/> Euro / <?php echo esc_html__( 'day', 'solea' ); ?>
	</td>
</tr>
<tr>
	<td style="text-align: right;">
		<?php echo esc_html__( 'Description for group', 'solea' ); ?>:
	</td>
	<td><input type="text" name="description_volunteers" /></td>
</tr>

<tr>
	<td>
		<?php echo esc_html__( 'Amount for participant', 'solea' ); ?>:
	</td>
	<td>                    <input
				type="text"
				name="amount_participant"
				value="15,00"
		/> Euro / <?php echo esc_html__( 'day', 'solea' ); ?>
	</td>
</tr>
<tr>
	<td style="text-align: right;">
		<?php echo esc_html__( 'Description for group', 'solea' ); ?>:
	</td>
	<td><input type="text" name="description_participants" /></td>
</tr>

<tr>
	<td>
		<?php echo esc_html__( 'Amount for others', 'solea' ); ?>:
	</td>
	<td>                    <input
			type="text"
			name="amount_others"
			placeholder="<?php echo esc_html__( 'Keep free to disable this group', 'solea' ); ?>"
		/> Euro / <?php echo esc_html__( 'day', 'solea' ); ?>
	</td>
</tr>
<tr>
	<td style="text-align: right;">
		<?php echo esc_html__( 'Description for group', 'solea' ); ?>:
	</td>
	<td><input type="text" name="description_others" /></td>
</tr>

<tr>
	<td>
		<?php echo esc_html__( 'Amount for Online participants', 'solea' ); ?>:
	</td>
	<td>                    <input
				type="text"
				name="amount_online"
				placeholder="<?php echo esc_html__( 'Keep free to disable this group', 'solea' ); ?>"
		/> Euro / <?php echo esc_html__( 'day', 'solea' ); ?>
	</td>
</tr>

<tr>
	<td>
		<?php echo esc_html__( 'Maximum amount for event', 'solea' ); ?>:
	</td>
	<td><input type="text" name="amount_maximum" /> Euro
	</td>
</tr>

<tr>
	<td>
		<?php echo esc_html__( 'Increase amount by', 'solea' ); ?>:
	</td>
	<td>                    <input
				type="text"
				name="lastminute_amount_group"
				value="50" style="width: 50px;"/> %
	</td>
</tr>
<tr>
	<td style="text-align: right;">
		<?php echo esc_html__( 'For registrations from', 'solea' ); ?>:
	</td>
	<td><input type="date" name="last_minute_begin_group"  id="last_minute_begin_group" /></td>
</tr>
<tr>
	<td colspan="2">
		<input type="submit" class="button" value="<?php echo esc_html__( 'Create event', 'solea' ); ?>" />
	</td>
</tr>
