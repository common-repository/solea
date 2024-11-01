<?php
/**
 * File: add-group-form.php
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
	<h3><?php echo esc_html__( 'Add local group', 'solea' ); ?></h3>
	<form method="post"
			action="<?php echo esc_url( admin_url( $page . '?page=' . $slug ) ); ?>">
		<input type="hidden" name="save-option" value="new-group" />
		<table>
			<tr>
				<td><?php echo esc_html__( 'Group name', 'solea' ); ?>:</td>
				<td><input type="text" name="group_name" required /></td>
			</tr>

			<tr>
				<td><?php echo esc_html__( 'E-mail address', 'solea' ); ?>:</td>
				<td><input type="text" name="group_email" required /></td>
			</tr>

			<tr>
				<td><?php echo esc_html__( 'E-mail address (member management)', 'solea' ); ?>:</td>
				<td><input type="email" name="group_members_email" required /></td>
			</tr>

			<tr>
				<td><?php echo esc_html__( 'ZIP code', 'solea' ); ?>:</td>
				<td><input type="text" name="group_zip" required /></td>

			</tr>

			<tr>
				<td><?php echo esc_html__( 'City', 'solea' ); ?>:</td>
				<td><input type="text" name="group_city" required /></td>

			</tr>

			<tr>
				<td colspan="2">
					<input type="submit" class="button" value="<?php echo esc_html__( 'Add local group', 'solea' ); ?>" />
				</td>
			</tr>
		</table>
	</form>
</div>
