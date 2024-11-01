<?php
/**
 * File: index.php
 *
 * @since 2024-07-22
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/EventRegistration
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form id="registration_form" method="post" action="#" onsubmit="return solea_validationCheck()">
	<input type="hidden" name="event-id" value="<?php echo esc_html( $event->id ); ?>" />
	<input type="hidden" name="save" value="1" />
	<div class="step" id="step1">
		<?php
			require 'age.php';
		?>
	</div>

	<div class="step" id="step2">
		<h3><?php echo esc_html__( 'Personal data (parents)', 'solea' ); ?></h3>
		<?php
			require 'contactperson.php';
		?>
	</div>

	<div class="step" id="step3">
		<h3><?php echo esc_html__( 'Personal data (participant)', 'solea' ); ?></h3>
		<?php
			require 'contactdata.php';
		?>
	</div>

	<div class="step" id="step4">
		<h3>Deine Teilnahme</h3>
		<?php
		if ( $event->registration_solidarity ) {
			require 'group-easy.php';
		} else {
			require 'group-detailed.php';
		}
		?>
	</div>

	<div class="step" id="step5">
		<h3><?php echo esc_html__( 'Arrival and departure', 'solea' ); ?></h3>
		<?php
			require 'arrival.php';
		?>
	</div>

	<div class="step" id="step6">
		<h3><?php echo esc_html__( 'Amount', 'solea' ); ?></h3>
		<?php
			require 'amount.php';
		?>
	</div>

	<div class="step" id="step7">
		<h3><?php echo esc_html__( 'Photo permission', 'solea' ); ?></h3>
		<?php
			require 'photopermission.php';
		?>
	</div>

	<div class="step" id="step8">
		<h3><?php echo esc_html__( 'Special characteristics', 'solea' ); ?></h3>
		<?php
			require 'allergies.php';
		?>
	</div>
</form>

