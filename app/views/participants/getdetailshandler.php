<?php
/**
 * File: getdetailshandler.php
 *
 * @since 2024-07-26
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/Participants
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tmpstmp = new \DateTime();
$now     = $tmpstmp->format( 'Y-m-d' );
?>

<div id="solea_hider" onclick="solea_hide();"></div>
<div id="solea-participant-box">
	<div id="solea-participant-box-header">
		<span id="solea-participant-box-header-text">
			<?php echo esc_html__( 'Participant details', 'solea' ); ?>
		</span>
	</div>
	<div id="solea-participant-box-content"></div>
</div>

<div id="solea-update_amount-box">
	<div id="solea-update_amount-box-header">
		<span id="solea-update_amount-box-box-header">
			<?php echo esc_html__( 'Participant amount details', 'solea' ); ?>
		</span>
	</div>

	<div id="solea-update_amount-box-content">
		<h2><?php echo esc_html__( 'Register payment', 'solea' ); ?></h2>
		<form method="post" action="
		<?php
		echo esc_url( admin_url( 'admin.php?page=' . $slug . '&tab=' . $active_tab . '&action=update-payment' ) );
		?>
				">
			<p><?php echo esc_html__( 'Please enter the total amount paid for the event so far:', 'solea' ); ?></p>
			<input type="text" name="amount_paid" id="amount_paid" /> Euro
			<input type="hidden" id="participant_id" name="participant-id"><br><br>
			<input type="submit" value="Speichern" class="button solea-button" style="background-color: #ef4d4d !important; color: #ffffff !important;">
			<input type="button" value="Abbrechen" onclick="solea_hide();" class="button solea-button">
		</form>
	</div>
</div>

<div id="solea-unregister_participant-box">
	<div id="solea-unregister_participant-box-header">
		<span id="solea-unregister_participant-box-box-header">
			<?php echo esc_html__( 'Unregister participant', 'solea' ); ?>
		</span>
	</div>

	<div id="solea-unregister_participant-box-content">
		<h2><?php echo esc_html__( 'Unregister participant', 'solea' ); ?></h2>
		<form method="post" action="
		<?php
		echo esc_url(
			admin_url(
				'admin.php?page=' . $slug .
				'&tab=' . $active_tab .
				'&action=signoff-participant'
			)
		);
		?>
			">
			<p><?php echo esc_html__( 'Please enter the date when the unregister request was received:', 'solea' ); ?></p>
			<input type="date" name="date_unregister" value="<?php echo esc_html( $now ); ?>" />
			<input type="hidden" id="participant_id_signoff" name="participant-id"><br><br>
			<input type="submit" value="Speichern" class="button solea-button" style="background-color: #ef4d4d !important; color: #ffffff !important;">
			<input type="button" value="Abbrechen" onclick="solea_hide();" class="button solea-button">
		</form>
	</div>
</div>
