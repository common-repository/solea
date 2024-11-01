<?php
/**
 * File: list.php
 *
 * @since 2024-07-25
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/Participants
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\Requests\GetLocalGroupName;
use Solea\App\Requests\GetParticipationTypeName;

foreach ( $participant_groups as $group => $participants ) {
	?>
		<div  class="solea-page" style="margin-bottom: 00100px;">
	<h3>
		<?php
		if ( 'localgroup' === $filter ) {
			echo esc_html( GetLocalGroupName::execute( $group ) );
		} elseif ( 'participation_group' === $filter ) {
			echo esc_html( GetParticipationTypeName::execute( $group ) );
		} else {
			echo esc_html__( 'Deregistered participants', 'solea' );
		}
		?>
		(
		<?php
			echo esc_html( count( $participants ) . ' ' );
			echo esc_html__( 'participants', 'solea' );
		?>
		)
	</h3>

	<p style="width: 100%; text-align: right">
		<input type="text" id="searchInput"
				onkeyup="searchTable('gruppe_<?php echo esc_html( $group ); ?>', this)"
				placeholder="<?php echo esc_html__( 'Filter participant', 'solea' ); ?>">
	</p>
<table class="wp-list-table widefat fixed striped table-view-list solea_participant_group" id="gruppe_<?php echo esc_html( $group ); ?>">
	<thead>
	<tr>
		<th style="padding-right: 10px;" scope="col" class="manage-column column-name"><?php echo esc_html__( 'Name', 'solea' ); ?></th>
		<th class="manage-column column-name"><?php echo esc_html__( 'Presence days', 'solea' ); ?></th>
		<th class="manage-column column-name"><?php echo esc_html__( 'Local group', 'solea' ); ?></th>
		<th class="manage-column column-name"><?php echo esc_html__( 'Amount', 'solea' ); ?></th>
		<th class="manage-column column-name"><?php echo esc_html__( 'E-mail address', 'solea' ); ?></th>
		<th class="manage-column column-name"><?php echo esc_html__( 'Telephone', 'solea' ); ?></th>
		<th class="manage-column column-name"><?php echo esc_html__( 'Actions', 'solea' ); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ( $participants as $participant ) {
        $amount_left = $participant->amount - $participant->amount_paid;
		?>
		<tr>
			<td>
				<a href="#" onclick="solea_load_participant_data('<?php echo esc_html( $participant->id ); ?>');"><?php echo esc_html( $participant->firstname ); ?>
					<?php echo esc_html( $participant->lastname . ( '' !== $participant->nickname ? ' (' . $participant->nickname . ')' : '' ) ); ?></a><br />
				<?php echo esc_html( solea_get_age( $participant->birthday ) ); ?> Jahre
			</td>
			<td>
				<?php echo esc_html( \DateTime::createFromFormat( 'Y-m-d', $participant->arrival )->format( 'd.m.Y' ) ); ?> -
				<?php echo esc_html( \DateTime::createFromFormat( 'Y-m-d', $participant->departure )->format( 'd.m.Y' ) ); ?>
			</td>
			<td><?php echo esc_html( GetLocalGroupName::execute( $participant->local_group ) ); ?></td>

			<td style="<?php echo esc_html( $amount_left !== 0 ? 'background-color: #f2dada; color: #ff0000;' : '' ); ?>">
				<?php echo esc_html( $participant->amount_paid ); ?> Euro / <?php echo esc_html( $participant->amount ); ?> Euro
				<?php if ( 'deregistered' === $filter ) { ?>
					<br /><?php echo esc_html__( 'Date of deregistration', 'solea' ); ?>:
					<?php echo esc_html( \DateTime::createFromFormat( 'Y-m-d H:i:s', $participant->date_unregister )->format( 'd.m.Y' ) ); } ?>
			</td>
			<td><?php echo esc_html( $participant->email_1 ); ?><br /><?php echo esc_html( $participant->email_2 ); ?></td>
			<td>
				<?php solea_get_telephone_link( $participant->telefon_1, true ); ?>
				<?php if ( null !== $participant->telefon_2 ) { ?>
				<br />
				<?php solea_get_telephone_link( $participant->telefon_2, true ); } ?>
			</td>
			<td>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=' . $slug . '&tab=' . $active_tab . '&action=send-mail-to-group&group-type=singlemail&group=' . $participant->id ) ); ?>"><?php echo esc_html__( 'Send email to', 'solea' ); ?></a><br />
				<?php if ( 'deregistered' !== $filter ) { ?>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=' . $slug . '&tab=' . $active_tab . '&action=edit-participant&participant-id=' . $participant->id ) ); ?>"><?php echo esc_html__( 'Edit' ); ?></a><br />
					<a href="#" style="color: #72b752" onclick="solea_update_amount(<?php echo esc_html( $participant->id ); ?>, '<?php echo esc_html( $participant->amount ); ?>');"><?php echo esc_html__( 'Confirm payment', 'solea' ); ?> </a><br />
					<a href="#" onclick="solea_unregister_participant(<?php echo esc_html( $participant->id ); ?>, '<?php echo esc_html( $participant->amount ); ?>');" style="color: #ff0000;"><?php echo esc_html__( 'Unregister', 'solea' ); ?></a>
				<?php } else { ?>
					<a style="color: #72b752" href="<?php echo esc_url( admin_url( 'admin.php?page=' . $slug . '&tab=' . $active_tab . '&action=resignon&participant-id=' . $participant->id ) ); ?>"><?php echo esc_html__( 'Re-Register', 'solea' ); ?></a><br />
				<?php } ?>
			</td>
		</tr>
		<?php
	}
	?>
	</tbody>
</table><br /><br />
			<?php
			if ( 'deregistered' !== $filter ) {

				?>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=' . $slug . '&tab=' . $active_tab . '&action=send-mail-to-group&group-type=' . $filter . '&group=' . $group ) ); ?>" class="button"><?php echo esc_html__( 'Send e-mail to group', 'solea' ); ?></a>
			<?php } ?>
		</div>


	<?php
}
?>
