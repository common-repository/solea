<?php
/**
 * File: contactperson.php
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
		<td><?php echo esc_html__( 'Name', 'solea' ); ?>,
			<?php echo esc_html__( 'First name', 'solea' ); ?>
		</td>
		<td><input type="text" name="ansprechpartner" id="ansprechpartner" /></td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'Telephone', 'solea' ); ?>:</td>
		<td><input type="text" name="telefon_2" id="telefon_2" /></td>
	</tr>
	<tr>
		<td><?php echo esc_html__( 'E-mail address', 'solea' ); ?>:</td>
		<td><input type="text" name="email_2" id="email_2"/></td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'Swimming permission', 'solea' ); ?>:</td>
		<td>
			<select name="badeerlaubnis">
				<option value="none"><?php echo esc_html__( 'No permission', 'solea' ); ?></option>
				<option value="partial"><?php echo esc_html__( 'My child is allowed to bathe but CANNOT SWIM', 'solea' ); ?></option>
				<option value="complete"><?php echo esc_html__( 'My child is allowed to bathe and can swim', 'solea' ); ?></option>
			</select>

		</td>
	</tr>
</table>

<input type="button" value="<?php echo esc_html__( 'Next', 'solea' ); ?>" onclick="checkAnsprechpartner()" />
