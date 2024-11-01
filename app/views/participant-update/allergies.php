<?php
/**
 * File: allergies.php
 *
 * @since 2024-07-26
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/Participants
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\Requests\EatingHabit;

?>
<table>
	<tr>
		<td><?php echo esc_html__( 'Eating habits', 'solea' ); ?>:</td>
		<td>
			<select name="eating_habit" style="width: 340px;">
				<?php
				if ( $event->enable_all_eating ) {
					?>
					<option value="all"
					<?php
					if ( 'all' === $participant->eating_habit ) {
						echo esc_html( 'selected' );}
					?>
					><?php echo esc_html( EatingHabit::execute( 'all' ) ); ?></option>
				<?php } ?>
				<option value="vegetarian" 
				<?php
				if ( 'vegetarian' === $participant->eating_habit ) {
					echo esc_html( 'selected' );}
				?>
				><?php echo esc_html( EatingHabit::execute( 'vegetarian' ) ); ?></option>
				<option value="vegan" 
				<?php
				if ( 'vegan' === $participant->eating_habit ) {
					echo esc_html( 'selected' );}
				?>
				><?php echo esc_html( EatingHabit::execute( 'vegan' ) ); ?></option>
			</select>
		</td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'Allergies', 'solea' ); ?></td>
		<td><input style="width: 340px;" type="text" name="allergies" value="<?php echo esc_html( $participant->allergies ); ?>" /></td>
	</tr>

	<tr>
		<td><?php echo esc_html__( 'Food intolerances', 'solea' ); ?></td>
		<td><input style="width: 340px;" type="text" name="intolerances" value="<?php echo esc_html( $participant->intolerances ); ?>" /></td>
	</tr>


	<tr>
		<td><?php echo esc_html__( 'Medications', 'solea' ); ?>:</td>
		<td><input style="width: 340px;" type="text" name="medication" value="<?php echo esc_html( $participant->medication ); ?>" /></td>
	</tr>

	<tr style="vertical-align: top;">
		<td><?php echo esc_html__( 'Notices', 'solea' ); ?>:</td>
		<td><textarea style="width: 340px;" name="notices" rows="8"><?php echo esc_html( $participant->notices ); ?></textarea>
		</td>
	</tr>
</table>
