<?php
/**
 * File: new-details.php
 *
 * @since 2024-07-22
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/Partials/event
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<tr>


<tr>
	<td colspan="2">
		<input type="checkbox" name="enable_all_eating" id="enable_all_eating" value="1" />
		<label for="enable_all_eating">
			<?php echo esc_html__( 'Meat will be offered at the event.', 'solea' ); ?>
		</label>
	</td>
</tr>

<tr>
	<td colspan="2">
		<input type="checkbox" name="weekly_report" id="weekly_report" value="1" checked />
		<label for="weekly_report">
			<?php echo esc_html__( 'Send a participant list every Sunday to event management and local groups', 'solea' ); ?>
		</label>
	</td>
</tr>

<tr>
	<td>
		<?php echo esc_html__( 'Minimum age for alcoholics', 'solea' ); ?>
	</td>
	<td>
		<input type="number" name="age_alcoholic" value="16" required style="width: 75px;">
	</td>
</tr>


<tr>
	<td colspan="2">
		<b><?php echo esc_html__( 'Allow following local groups to participate', 'solea' ); ?></b><br />
		<?php




		$all_groups_array = array();
		foreach ( $groups as $group ) {
			$all_groups_array[] = $group->id;
			?>
			<input

				<?php
				if ( isset( $allowed_groups[ $group->id ] ) ) {
					echo esc_html( 'checked' );}
				?>
					type="checkbox"
					name="group[<?php echo esc_html( $group->id ); ?>]"
					value="active"
					id="group_<?php echo esc_html( $group->id ); ?>" />
			<label for="group_<?php echo esc_html( $group->id ); ?>">
				<?php echo esc_html( $group->name ); ?>
			</label><br />
			<?php
		}
		?>
	<input type="hidden" name="all_groups" value="<?php echo esc_html( implode( ',', $all_groups_array ) ); ?>" />
