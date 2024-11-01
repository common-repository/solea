<?php
/**
 * File: edit.php
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

<div class="solea-page">
	<h3><?php echo esc_html__( 'Edit event settings', 'solea' ); ?></h3>
	<form method="post" action="<?php esc_url( admin_url( 'admin.php?page=' . $slug . '&tab=' . $active_tab ) ); ?>">
		<input type="hidden" name="action" value="update-event" />
		<table>
			<tr>
				<td><?php echo esc_html__( 'Event name', 'solea' ); ?>:</td>
				<td>
					<input type="text" name="event_name" value="<?php echo esc_html( $event->event_name ); ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Registration URL', 'solea' ); ?>:</td>
				<td>
					<input type="text" name="event_url" value="<?php echo esc_html( $event->event_url ); ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Organizer E-mail address', 'solea' ); ?>:</td>
				<td>
					<input type="email" name="event_email" value="<?php echo esc_html( $event->event_email ); ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Registration end', 'solea' ); ?>:</td>
				<td>
					<input type="date" name="registration_end" value="<?php echo esc_html( $event->registration_end ); ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="checkbox" name="signup_allowed" id="signup_allowed" value="1"
						<?php
						if ( $event->signup_allowed ) {
							echo esc_html( 'checked' );}
						?>
						/>
					<label for="signup_allowed">
						<?php echo esc_html__( 'Event is open for signups.', 'solea' ); ?>
					</label>
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<input type="checkbox" name="weekly_report" id="weekly_report" value="1"
						<?php
						if ( $event->weekly_report ) {
							echo esc_html( 'checked' );}
						?>
						/>
					<label for="weekly_report">
						<?php echo esc_html__( 'Send a participant list every Sunday to event management and local groups', 'solea' ); ?>
					</label>
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<input type="checkbox" name="enable_all_eating" id="enable_all_eating" value="1"
						<?php
						if ( $event->enable_all_eating ) {
							echo esc_html( 'checked' );}
						?>
						/>
					<label for="enable_all_eating">
						<?php echo esc_html__( 'Meat will be offered at the event.', 'solea' ); ?>
					</label>
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
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" class="button solea-button" value="<?php echo esc_html__( 'Save' ); ?>"></td>
			</tr>
		</table>
	</form>
</div>
