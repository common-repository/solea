<?php
/**
 * File: participation.php
 *
 * @since 2024-07-26
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/Participants
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Participant;
use Solea\App\Requests\GetParticipationTypeName;

?>
<div class="solea-page" style="margin-bottom: 50px;">
	<h3><?php echo esc_html__( 'Participant data', 'solea' ); ?></h3>

	<table>
		<tr>
			<td><?php echo esc_html__( 'Name', 'solea' ); ?></td>
			<td>
				<input type="text" name="firstname"  style="width: 200px;" value="<?php echo esc_html( $participant->firstname ); ?>" />
				(
				<input type="text" name="nickname"  style="width: 100px;" placeholder="<?php echo esc_html__( 'Nickname', 'solea' ); ?>" value="<?php echo esc_html( $participant->nickname ); ?>" />
				)
				<input type="text" name="lastname"  style="width: 200px;" value="<?php echo esc_html( $participant->lastname ); ?>" />
			</td>
		</tr>

		<tr>
			<td><?php echo esc_html__( 'Arrival', 'solea' ); ?>:</td>
			<td>
				<input type="date" style="width: 200px;" name="arrival" value="<?php echo esc_html( $participant->arrival ); ?>" />
				<select name="arrival_eating" style="width: 325px">
					<option <?php echo esc_html( 1 === (int) $participant->arrival_eating ? 'selected' : '' ); ?> value="1"><?php echo esc_html__( 'Before dinner', 'solea' ); ?></option>
					<option <?php echo esc_html( 2 === (int) $participant->arrival_eating ? 'selected' : '' ); ?> value="2"><?php echo esc_html__( 'Before lunch', 'solea' ); ?></option>
					<option <?php echo esc_html( 3 === (int) $participant->arrival_eating ? 'selected' : '' ); ?> value="3"><?php echo esc_html__( 'Before breakfast', 'solea' ); ?></option>
					<option <?php echo esc_html( 4 === (int) $participant->arrival_eating ? 'selected' : '' ); ?> value="4"><?php echo esc_html__( 'For evening round / No meal on arrival day', 'solea' ); ?></option>
				</select>
			</td>
		</tr>

		<tr>
			<td><?php echo esc_html__( 'Departure', 'solea' ); ?>:</td>
			<td>
				<input type="date" name="departure"  style="width: 200px;" value="<?php echo esc_html( $participant->departure ); ?>" />
				<select name="departure_eating" style="width: 325px;">
					<option <?php echo esc_html( 1 === (int) $participant->departure_eating ? 'selected' : '' ); ?> value="1"><?php echo esc_html__( 'After breakfast', 'solea' ); ?></option>
					<option <?php echo esc_html( 2 === (int) $participant->departure_eating ? 'selected' : '' ); ?> value="2"><?php echo esc_html__( 'After lunch', 'solea' ); ?></option>
					<option <?php echo esc_html( 3 === (int) $participant->departure_eating ? 'selected' : '' ); ?> value="3"><?php echo esc_html__( 'After dinner', 'solea' ); ?></option>
					<option <?php echo esc_html( 4 === (int) $participant->departure_eating ? 'selected' : '' ); ?> value="4"><?php echo esc_html__( 'Early morning / No meal on departure day', 'solea' ); ?></option>
				</select>
			</td>
		</tr>

		<tr>
			<td><?php echo esc_html__( 'Participation group', 'solea' ); ?>:</td>
			<td>
				<select name="participant_group"  style="width: 300px;">
					<?php
					foreach ( array(
						Participant::PARTICIPATION_GROUP_PARTICIPANT,
						Participant::PARTICIPATION_GROUP_VOLUNTEER,
						Participant::PARTICIPATION_GROUP_TEAM,
						Participant::PARTICIPATION_GROUP_OTHER,
						Participant::PARTICIPATION_GROUP_ONLINE,
					) as $current_group ) {
						?>
							<option
								value="<?php echo esc_html( $current_group ); ?>"
							<?php echo esc_html( $current_group === $participant->participant_group ? 'selected' : '' ); ?>>
								<?php echo esc_html( GetParticipationTypeName::execute( $current_group ) ); ?>
							</option>
							<?php
					}
					?>
				</select>
			</td>
		</tr>

		<tr>
			<td><?php echo esc_html__( 'Amount', 'solea' ); ?>:</td>
			<td>
				<input type="text"  style="width: 100px;" name="amount_paid" value="<?php echo esc_html( $participant->amount_paid ); ?>" />
				Euro /
				<input type="text"  style="width: 100px;" name="amount" value="<?php echo esc_html( $participant->amount ); ?>" /> Euro
			</td>
		</tr>

	</table>
</div>
