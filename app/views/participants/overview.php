<?php
/**
 * File: overview.php
 *
 * @since 2024-07-25
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/Participants
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\Requests\GetParticipationTypeName;
?>

<div style="display:flex; ">
	<div class="solea_event_overview">

			<h3><?php echo esc_html__( 'Participants', 'solea' ); ?></h3>
			<table>
				<?php
				foreach ( $event->get_participants_by_participation() as $group => $participants ) {
					?>
						<tr>
							<td style="font-weight: bold; padding-right: 15px;">
							<?php echo esc_html( GetParticipationTypeName::execute( $group ) ); ?>:
							</td>
							<td><?php echo esc_html( count( $participants ) ); ?></td>
						</tr>
						<?php
				}
				?>
				<tr>
					<td style="font-weight: bold; padding-right: 15px;">
						<?php echo esc_html__( 'Amount', 'solea' ); ?>:
					</td>
					<td>
						<?php echo esc_html( solea_format_amount( $amount['paid'] ) ); ?> /
						<?php echo esc_html( solea_format_amount( $amount['total'] ) ); ?>
					</td>
				</tr>

			</table>

		<p></p>

	</div>


	<div class="solea_event_overview"  style="padding: 10px;">
		<a href="#" onclick="solea_print_list('participantlist', <?php echo esc_html( $event->id ); ?>);" class="button solea-button solea-event-action-button"><?php echo esc_html__( 'Participant list', 'solea' ); ?> (PDF)</a>
		<a href="#" onclick="solea_print_list('participant-csvlist', <?php echo esc_html( $event->id ); ?>)" class="button solea-button solea-event-action-button"><?php echo esc_html__( 'Participant list', 'solea' ); ?> (CSV)</a>
		<a href="#" onclick="solea_print_list('kitchenoverview', <?php echo esc_html( $event->id ); ?>)" class="button solea-button solea-event-action-button"><?php echo esc_html__( 'Kitchen overview', 'solea' ); ?> (PDF)</a>
		<a href="#" onclick="solea_print_list('kitchenallergies', <?php echo esc_html( $event->id ); ?>)" class="button solea-button solea-event-action-button"><?php echo esc_html__( 'Kitchen list with allergies', 'solea' ); ?> (PDF)</a>
		<a href="#" onclick="solea_print_list('firstaid', <?php echo esc_html( $event->id ); ?>)" class="button solea-button solea-event-action-button"><?php echo esc_html__( 'First aid list', 'solea' ); ?> (PDF)</a>
		<a href="#" onclick="solea_print_list('amountlist', <?php echo esc_html( $event->id ); ?>)" class="button solea-button solea-event-action-button"><?php echo esc_html__( 'Amount list', 'solea' ); ?> (PDF)</a>
		<a href="#" onclick="solea_print_list('alcoholiclist', <?php echo esc_html( $event->id ); ?>)" class="button solea-button solea-event-action-button"><?php echo esc_html__( 'Drinking list (alcoholic)', 'solea' ); ?> (PDF)</a>
		<a href="#" onclick="solea_print_list('non-alcoholiclist, <?php echo esc_html( $event->id ); ?>')" class="button solea-button solea-event-action-button"><?php echo esc_html__( 'Drinking list (non-alcoholic)', 'solea' ); ?> (PDF)</a>
		<a href="#" onclick="solea_print_list('photopermission', <?php echo esc_html( $event->id ); ?>)" class="button solea-button solea-event-action-button"><?php echo esc_html__( 'Photo permission', 'solea' ); ?> (PDF)</a>
        <a href="#" onclick="solea_print_list('awarenesschecklist', <?php echo esc_html( $event->id ); ?>)" class="button solea-button solea-event-action-button"><?php echo esc_html__( 'Awareness checklist', 'solea' ); ?> (CSV)</a>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=' . $slug . '&tab=' . $active_tab . '&action=send-mail-to-group&group-type=all&group=event' ) ); ?>" class="button solea-button solea-event-action-button"><?php echo esc_html__( 'Send e-mail to all participants', 'solea' ); ?></a>
	</div>
</div>
