<?php
/**
 * File: local-groups.php
 *
 * @since 2024-07-22
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/Partials/settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="solea-page">
	<h3>
		<?php echo esc_html__( 'Local groups', 'solea' ); ?>
	</h3>
	<table class="wp-list-table widefat fixed striped table-view-list solea-table">
		<tr>
			<th><?php echo esc_html__( 'Group name', 'solea' ); ?></th>
			<th><?php echo esc_html__( 'E-mail address', 'solea' ); ?></th>
			<th><?php echo esc_html__( 'E-mail address (member management)', 'solea' ); ?></th>
			<th><?php echo esc_html__( 'City', 'solea' ); ?></th>
			<th><?php echo esc_html__( 'Actions', 'solea' ); ?></th>
		</tr>
		<?php
		foreach ( $all_groups as $group ) {
			?>
				<tr>
					<td>
					<?php echo esc_html( $group->name ); ?>
					</td>
					<td>
					<?php echo esc_html( $group->email ); ?>
					</td>
					<td>
						<?php echo esc_html( $group->members_email ); ?>
					</td>
					<td>
					<?php echo esc_html( $group->zip ); ?>
					<?php echo esc_html( $group->city ); ?>
					</td>

					<td>
						<a href="
						<?php
						echo esc_url( admin_url( $page . '?page=' . $slug . '&mode=edit-group-form&group-id=' . $group->id ) );
						?>
						">
							<?php echo esc_html__( 'Edit' ); ?>
					</td>
				</tr>
				<?php
		}

		?>
	</table><br /><br />
	<a href="<?php echo esc_url( admin_url( $page . '?page=' . $slug . '&mode=add-group-form' ) ); ?>"
		class="button"><?php echo esc_html__( 'Add new Group', 'solea' ); ?></a>
</div>
