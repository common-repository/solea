<?php
/**
 * File: contactdata.php
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
		<td><?php echo esc_html__( 'First Name:', 'solea' ); ?></td>
		<td><input value="<?php echo esc_html( $firstname ); ?>" type="text" name="vorname" id="vorname" /></td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'Last Name:', 'solea' ); ?></td>
		<td><input value="<?php echo esc_html( $lastname ); ?>" type="text" name="nachname" id="nachname" /></td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'Nickname:', 'solea' ); ?></td>
		<td><input value="<?php echo esc_html( $nickname ); ?>" type="text" name="pfadiname" id="pfadiname" /></td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'Local Group:', 'solea' ); ?></td>
		<td>
			<select name="localgroup" required placeholder="<?php echo esc_html__( 'Please select', 'solea' ); ?>">
				<?php
				foreach ( $local_groups as $group ) {
					?>
						<option 
						<?php
						if ( '' !== $localgroup && (int) $localgroup === $group->id ) {
							echo esc_html( ' selected ' );}
						?>
								value="<?php echo esc_html( $group->id ); ?>">
						<?php echo esc_html( $group->name ); ?>
						</option>
						<?php
				}
				?>
			</select>
		</td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'Date of Birth:', 'solea' ); ?></td>
		<td><input value="<?php echo esc_html( $birthday ); ?>"t type="date" name="geburtsdatum" id="geburtsdatum" /></td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'Street, House Number:', 'solea' ); ?></td>
		<td>
			<input type="text" value="<?php echo esc_html( $street ); ?>" name="strasse" id="strasse" />
			<input type="text" value="<?php echo esc_html( $number ); ?>" name="hausnummer" id="hausnummer" />
		</td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'Postal Code, City:', 'solea' ); ?></td>
		<td>
			<input type="text" value="<?php echo esc_html( $zipcode ); ?>" name="plz" id="plz" />
			<input type="text" value="<?php echo esc_html( $city ); ?>" name="ort" id="ort"  />
		</td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'Phone:', 'solea' ); ?></td>
		<td><input value="<?php echo esc_html( $phone ); ?>" type="text" name="telefon_1" id="telefon_1" /></td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'E-mail address:', 'solea' ); ?></td>
		<td><input value="<?php echo esc_html( $email ); ?>" type="text" name="email_1" id="email_1" /></td>
	</tr>
</table>

<input type="button" value="<?php echo esc_html__( 'Next', 'solea' ); ?>" onclick="checkAddress();" />
