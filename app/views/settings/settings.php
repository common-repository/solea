<?php
/**
 * File: settings.php
 *
 * @since 2024-07-30
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/Settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=solea-settings' ) ); ?>">
	<input type="hidden" name="save-option" value="settings" />
	<table style="margin-top: 50px; border-spacing: 10px;">
		<tr>
			<td style="padding-right: 20px; font-weight: bold"><?php echo esc_html__( 'Icon for children', 'solea' ); ?>:</td>
			<td><input type="text" style="width: 650px;" name="icon_children" value="<?php echo esc_url( get_option( 'solea_icon_children', SOLEA_PLUGIN_URL . '/assets/images/children.svg' ) ); ?>" </td>
		</tr>


		<tr>
			<td style="padding-right: 20px; font-weight: bold"><?php echo esc_html__( 'Icon for adults', 'solea' ); ?>:</td>
			<td><input type="text" style="width: 650px;" name="icon_adults" value="<?php echo esc_url( get_option( 'solea_icon_adults', SOLEA_PLUGIN_URL . '/assets/images/adults.svg' ) ); ?>" </td>
		</tr>

		<tr>
			<td style="padding-right: 20px; font-weight: bold"><?php echo esc_html__( 'URL to the registration order', 'solea' ); ?>:</td>
			<td><input type="text" style="width: 650px;" placeholder="<?php echo esc_html__( 'Keep free if no document exists', 'solea' ); ?>" name="registration_order_url" value="<?php echo esc_url( get_option( 'solea_registration_order_url', '' ) ); ?>" </td>
		</tr>

		<tr>
			<td style="padding-right: 20px; font-weight: bold"><?php echo esc_html__( 'Account owner', 'solea' ); ?>:</td>
			<td><input type="text" style="width: 650px;" name="account_owner" value="<?php echo esc_html( get_option( 'solea_account_owner', '' ) ); ?>" </td>
		</tr>

		<tr>
			<td style="padding-right: 20px; font-weight: bold"><?php echo esc_html__( 'IBAN', 'solea' ); ?>:</td>
			<td><input type="text" style="width: 650px;" name="account_iban" value="<?php echo esc_html( get_option( 'solea_account_iban', '' ) ); ?>" </td>
		</tr>

		<tr>
			<td style="padding-right: 20px; font-weight: bold"><?php echo esc_html__( 'E-Mail (Central member management)', 'solea' ); ?>:</td>
			<td><input type="text" style="width: 650px;" name="central_member_management" value="<?php echo esc_html( get_option( 'solea_central_member_management', '' ) ); ?>" </td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" class="button-primary" value="<?php echo esc_html__( 'Save' ); ?>" /></td>
		</tr>
	</table>
</form>
