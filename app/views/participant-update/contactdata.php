<?php
/**
 * File: contactdata.php
 *
 * @since 2024-07-26
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/Participants
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<table>
	<tr>
		<td><?php echo esc_html__( 'Birthday', 'solea' ); ?></td>
		<td><input style="width: 340px;" type="date" name="birthday" value="<?php echo esc_html( $participant->birthday ); ?>" /></td>
	</tr>
	<tr>
		<td><?php echo esc_html__( 'Address', 'solea' ); ?></td>
		<td>
			<input value="<?php echo esc_html( $participant->street ); ?>" type="text" name="street" id="strasse" style="width: 285px;" />
			<input value="<?php echo esc_html( $participant->number ); ?>" type="text" name="number" id="hausnummer" style="width: 50px;" /><br />
			<input value="<?php echo esc_html( $participant->zip ); ?>" type="text" name="zip" id="plz" style="width: 80px;" />
			<input value="<?php echo esc_html( $participant->city ); ?>" type="text" name="city" id="ort" style="width: 255px;" />
		</td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'Local group', 'solea' ); ?></td>
		<td>
			<select name="local_group"  style="width: 340px;">
				<?php
				foreach ( $event->get_allowed_groups() as $group ) {
					?>
						<option value="<?php echo esc_html( $group->id ); ?>"
						<?php
						if ( $participant->local_group === $group->id ) {
							echo esc_html( 'selected' );}
						?>
						>
						<?php echo esc_html( $group->name ); ?></option>
						<?php
				}
				?>
			</select>
		</td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'E-mail address', 'solea' ); ?></td>
		<td>
			<input style="width: 340px;" type="text" name="email_1" value="<?php echo esc_html( $participant->email_1 ); ?>" />
		</td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'Telephone', 'solea' ); ?></td>
		<td>
			<input style="width: 340px;" type="text" name="telefon_1" value="<?php echo esc_html( $participant->telefon_1 ); ?>" />
		</td>
	</tr>

	<tr><td colspan="2" style="padding-left: 510px;"><input type="submit" class="button solea-button" value="<?php echo esc_html__( 'Save' ); ?>"></td></tr>
</table>
