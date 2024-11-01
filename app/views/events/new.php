<?php
/**
 * File: new.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/event
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$user = wp_get_current_user();
?>
<form onsubmit="return solea_new_event_form_validator();" method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=solea-add-event&create=true' ) ); ?>">
	<input type="hidden" name="registration_mode" id="registration_mode" />
	<div class="solea-page">
		<h3>
			<?php echo esc_html__( 'Add new event', 'solea' ); ?>
		</h3>
		<table>
			<tr>
				<td>
					<?php echo esc_html__( 'Event name', 'solea' ); ?>:
				</td>
				<td>
					<input type="text" name="event_name" />
				</td>
			</tr>

			<tr>
				<td>
					<?php echo esc_html__( 'Organizer E-mail address', 'solea' ); ?>:
				</td>
				<td>
					<input type="text" name="event_email" id="email" value="<?php echo esc_html( $user->user_email ); ?>" />
				</td>
			</tr>

			<tr>
				<td>
					<?php echo esc_html__( 'Event begin', 'solea' ); ?>:
				</td>
				<td>
					<input type="date" name="event_begin" id="event_begin" />
				</td>
			</tr>

			<tr>
				<td>
					<?php echo esc_html__( 'Event end', 'solea' ); ?>:
				</td>
				<td>
					<input type="date" name="event_end" id="event_end" />
				</td>
			</tr>

			<tr>
				<td>
					<?php echo esc_html__( 'Registration end', 'solea' ); ?>:
				</td>
				<td>
					<input type="date" name="registration_end" id="registration_end" />
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<input type="checkbox" name="payment_direct" id="payment_direct" value="1" />
					<label for="payment_direct">
						<?php echo esc_html__( 'Participants pay direct to event account', 'solea' ); ?>
					</label>
				</td>
			</tr>

			<tr id="account_owner" style="display: none;">
				<td>
					<?php echo esc_html__( 'Event account owner', 'solea' ); ?>:
				</td>
				<td>
					<input type="text" name="account_owner" value="<?php echo esc_html( get_option( 'solea_account_owner', '' ) ); ?>" />
				</td>
			</tr>

			<tr id="account_iban" style="display: none">
				<td>
					<?php echo esc_html__( 'Event account IBAN', 'solea' ); ?>:
				</td>
				<td>
					<input type="text" name="account_iban" id="iban_field" value="<?php echo esc_html( get_option( 'solea_account_iban', '' ) ); ?>" />
				</td>
			</tr>
			<tr id="solea-payment-change">
				<td colspan="2">
					<input
						type="button"
						class="button solea-button"
						onclick="solea_solidarity_creation();"
						value="<?php echo esc_html__( 'Registration by solidarity principle', 'solea' ); ?>" />
					<input
							type="button"
							class="button solea-button"
							onclick="solea_classic_creation();"
							value="<?php echo esc_html__( 'Classic registration', 'solea' ); ?>" />
				</td>
			</tr>
		</table>
	</div>

	<div class="solea-page" id="solea-event_data-registration" style="display: none;">
		<h3>
			<?php echo esc_html__( 'Event details', 'solea' ); ?>
		</h3>
		<table>
			<?php
			require SOLEA_TEMPLATE_DIR . '/partials/events/new-details.php';
			?>
		</table>
	</div>


	<div class="solea-page" id="solea-solidarity-registration" style="display: none;">
		<h3>
			<?php echo esc_html__( 'Event amounts', 'solea' ); ?>
		</h3>
		<table>
			<?php
				require SOLEA_TEMPLATE_DIR . '/partials/events/new-solidarity-amounts.php';
			?>
		</table>
	</div>


	<div class="solea-page" id="solea-classic-registration" style="display: none;">
		<h3>
			<?php echo esc_html__( 'Group_amounts', 'solea' ); ?>
		</h3>
		<table>
			<?php
			require SOLEA_TEMPLATE_DIR . '/partials/events/new-group-amounts.php';
			?>
		</table>
	</div>
</form>


