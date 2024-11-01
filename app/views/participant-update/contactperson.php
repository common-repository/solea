<?php
/**
 * File: contactperson.php
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
<div class="solea-page" style="margin-bottom: 50px; 
<?php
if ( solea_is_fullaged( $participant->birthday ) ) {
	echo esc_html( 'display: none;' );}
?>
">
	<h3><?php echo esc_html__( 'Contact person', 'solea' ); ?></h3>
	<table>
		<tr>
			<td><?php echo esc_html__( 'Name', 'solea' ); ?></td>
			<td>
				<input style="width: 340px;" type="text" name="contact_person" value="<?php echo esc_html( $participant->contact_person ); ?>" />
			</td>
		</tr>

		<tr>
			<td><?php echo esc_html__( 'E-mail address', 'solea' ); ?></td>
			<td>
				<input style="width: 340px;" type="text" name="email_2" value="<?php echo esc_html( $participant->email_2 ); ?>" />
			</td>
		</tr>

		<tr>
			<td><?php echo esc_html__( 'Telephone', 'solea' ); ?></td>
			<td>
				<input style="width: 340px;" type="text" name="telefon_2" value="<?php echo esc_html( $participant->telefon_2 ); ?>" />
			</td>
		</tr>
		<tr>
			<td><?php echo esc_html__( 'Swimming permission', 'solea' ); ?>:</td>
			<td>
				<select style="width: 340px;" name="swimming_permission">
					<option value="none" 
					<?php
					if ( 'none' === $participant->swimming_permission ) {
						echo esc_html( 'selected' );}
					?>
					><?php echo esc_html__( 'No permission', 'solea' ); ?></option>
					<option value="partial" 
					<?php
					if ( 'partial' === $participant->swimming_permission ) {
						echo esc_html( 'selected' );}
					?>
					><?php echo esc_html__( 'My child is allowed to bathe but CANNOT SWIM', 'solea' ); ?></option>
					<option value="complete" 
					<?php
					if ( solea_is_fullaged( $participant->birthday ) || 'complete' === $participant->swimming_permission ) {
						echo esc_html( 'selected' );}
					?>
					><?php echo esc_html__( 'My child is allowed to bathe and can swim', 'solea' ); ?></option>
				</select>
			</td>
		</tr>
	</table>
</div>
