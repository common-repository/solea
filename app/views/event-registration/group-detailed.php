<?php
/**
 * File: group-detailed.php
 *
 * @since 2024-07-22
 * @license GPL-3.0-or-later
 *
 * @package Solea/Views/Registration/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Participant;

?>

<table>
	<tr>
		<td colspan="2"><?php echo esc_html__( 'I participate as a', 'solea' ); ?>:</td>
	</tr>


	<?php
	foreach ( $groups as $group ) {
		$description_text = 'description_' . $group;
		?>
			<tr>
				<td colspan="2" style="text-align: left !important;">
					<input onchange="solea_calc_total_amount('<?php echo esc_html( $group ); ?>');"
							type="radio"
						<?php
						if ( Participant::PARTICIPATION_GROUP_PARTICIPANT === $group ) {
							echo ' checked ';}
						?>
							style="margin: 5px !important;"
							name="participant_group"
							value="<?php echo esc_html( $group ); ?>"
							id="solea_participant_group_ . <?php echo esc_html( $group ); ?>" />

					<label for="solea_participant_group_ . <?php echo esc_html( $group ); ?>">
					<?php
					switch ( $group ) {
						case Participant::PARTICIPATION_GROUP_PARTICIPANT:
							echo esc_html__( 'Participant', 'solea' );
							break;

						case Participant::PARTICIPATION_GROUP_TEAM:
							echo esc_html__( 'Team member', 'solea' );
							break;

						case Participant::PARTICIPATION_GROUP_VOLUNTEER:
							echo esc_html__( 'Volunteer', 'solea' );
							break;

						case Participant::PARTICIPATION_GROUP_OTHER:
							echo esc_html__( 'Other participant', 'solea' );
							break;

						case Participant::PARTICIPATION_GROUP_ONLINE:
							echo esc_html__( 'Online participant', 'solea' );
							break;
					}
					?>
						<solea-info-icon value="<?php echo esc_html( $event->$description_text ); ?>"></solea-info-icon>
					</label>
					</td>
				</tr>
			<?php
	}
	?>
		</table>
<input type="button" value="<?php echo esc_html__( 'Previous', 'solea' ); ?>" onclick="showStep(3)" />
<input type="button" value="<?php echo esc_html__( 'Next', 'solea' ); ?>" onclick="showStep(5)" />




