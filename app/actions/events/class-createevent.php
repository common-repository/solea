<?php
/**
 * File: class-createsevent.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package Solea/Actions/Events
 */

namespace solea\App\Actions\Events;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
/**
 * Class CreateEvent
 *
 * Provides methods to create classic and solidarity events, as well as related pages and cost units.
 */
class CreateEvent {
   /**
	 * Creates a classic event.
	 *
	 * @param string      $event_name The name of the event.
	 * @param string      $event_email The email associated with the event.
	 * @param string      $event_begin The start date of the event.
	 * @param string      $event_end The end date of the event.
	 * @param string      $registration_end The end date of the registration period.
	 * @param bool        $participants_pay_direct Whether participants pay directly.
	 * @param bool        $wekly_report Whether to send an email when a new participant registers.
	 * @param bool        $enable_all_eating Whether to enable eating for all participants.
	 * @param int         $age_alcoholics Minimum age from when participants may drink alcoholics.
	 * @param float|null  $amount_teamer The amount for team members.
	 * @param float|null  $amount_volunteer The amount for volunteers.
	 * @param float|null  $amount_participant The amount for participants.
	 * @param float|null  $amount_others The amount for other participants.
	 * @param float|null  $amount_online The amount for online participants.
	 * @param float       $amount_maximum The maximum amount for participants.
	 * @param string      $description_teamer The description for team members.
	 * @param string      $description_volunteers The description for volunteers.
	 * @param string      $description_participants The description for participants.
	 * @param string      $description_others The description for other participants.
	 * @param int         $last_minute_increase The increase in amount for last minute registrations.
	 * @param string      $last_minute_date The date from which last minute registration applies.
	 * @param string      $contributing_groups The groups contributing to the event.
	 * @param string|null $account_owner The owner of the account for payments.
	 * @param string|null $account_iban The IBAN of the account for payments.
	 * @param string|null $billing_deadline The billing deadline.
	 */
	public static function create_classic_event(
		string $event_name,
		string $event_email,
		string $event_begin,
		string $event_end,
		string $registration_end,
		bool $participants_pay_direct,
		bool $wekly_report,
		bool $enable_all_eating,
		int $age_alcoholics,
		?float $amount_teamer,
		?float $amount_volunteer,
		?float $amount_participant,
		?float $amount_others,
		?float $amount_online,
		float $amount_maximum,
		string $description_teamer,
		string $description_volunteers,
		string $description_participants,
		string $description_others,
		int $last_minute_increase,
		string $last_minute_date,
		string $contributing_groups,
		?string $account_owner = null,
		?string $account_iban = null,
		?string $billing_deadline = null
	) {
		$event_name = self::generate_event_name( $event_name, $event_begin );

		$event = Event::create(
			array(
				'event_name'                  => $event_name,
				'event_url'                   => site_url() . '/' . $event_name,
				'event_email'                 => $event_email,
				'date_begin'                  => $event_begin,
				'date_end'                    => $event_end,
				'amount_team'                 => $amount_teamer,
				'amount_volunteer'            => $amount_volunteer,
				'amount_participant'          => $amount_participant,
				'amount_online'               => $amount_online,
				'amount_other'                => $amount_others,
				'description_team'            => $description_teamer,
				'description_volunteer'       => $description_volunteers,
				'description_participant'     => $description_participants,
				'description_other'           => $description_others,
				'amount_max'                  => $amount_maximum,
				'increase_amount_last_minute' => $last_minute_increase,
				'weekly_report'               => $wekly_report,
				'enable_all_eating'           => $enable_all_eating,
				'age_alcoholics'              => $age_alcoholics,
				'last_minute_begin'           => $last_minute_date,
				'payment_direct'              => $participants_pay_direct,
				'account_iban'                => $account_iban,
				'account_owner'               => $account_owner,
				'registration_end'            => $registration_end,
				'contributing_groups'         => $contributing_groups,
				'registration_solidarity'     => false,
			)
		);

		if ( null !== $billing_deadline ) {
			self::create_cost_unit( $event_name, $event_email, $billing_deadline );
		}

		self::create_event_register_page( $event );
	}

	/**
	 * Creates a solidarity event.
	 *
	 * @param string      $event_name The name of the event.
	 * @param string      $event_email The email associated with the event.
	 * @param string      $event_begin The start date of the event.
	 * @param string      $event_end The end date of the event.
	 * @param string      $registration_end The end date of the registration period.
	 * @param bool        $participants_pay_direct Whether participants pay directly.
	 * @param bool        $wekly_report Whether to send an email when a new participant registers.
	 * @param bool        $enable_all_eating Whether to enable eating for all participants.
	 * @param int         $age_alcoholics Minimum age from when participants may drink alcoholics.
	 * @param float       $regular_amount The regular amount for participants.
	 * @param int         $last_minute_increase The increase in amount for last minute registrations.
	 * @param string      $last_minute_date The date from which last minute registration applies.
	 * @param string      $contributing_groups The groups contributing to the event.
	 * @param float|null  $solidarity_amount The solidarity amount for participants.
	 * @param float|null  $reduced_amount The reduced amount for participants.
	 * @param string|null $account_owner The owner of the account for payments.
	 * @param string|null $account_iban The IBAN of the account for payments.
	 * @param string|null $billing_deadline The billing deadline.
	 */
	public static function create_solidarity_event(
		string $event_name,
		string $event_email,
		string $event_begin,
		string $event_end,
		string $registration_end,
		bool $participants_pay_direct,
		bool $wekly_report,
		bool $enable_all_eating,
		int $age_alcoholics,
		float $regular_amount,
		int $last_minute_increase,
		string $last_minute_date,
		string $contributing_groups,
		?float $solidarity_amount = null,
		?float $reduced_amount = null,
		?string $account_owner = null,
		?string $account_iban = null,
		?string $billing_deadline = null
	) {
		$event_name = self::generate_event_name( $event_name, $event_begin );

		$event = Event::create(
			array(
				'event_name'                  => $event_name,
				'event_url'                   => site_url() . '/' . $event_name,
				'event_email'                 => $event_email,
				'date_begin'                  => $event_begin,
				'date_end'                    => $event_end,
				'amount_participant'          => $regular_amount,
				'amount_reduced'              => $reduced_amount,
				'amount_social'               => $solidarity_amount,
				'increase_amount_last_minute' => $last_minute_increase,
				'weekly_report'               => $wekly_report,
				'enable_all_eating'           => $enable_all_eating,
				'age_alcoholics'              => $age_alcoholics,
				'last_minute_begin'           => $last_minute_date,
				'payment_direct'              => $participants_pay_direct,
				'account_iban'                => $account_iban,
				'account_owner'               => $account_owner,
				'registration_end'            => $registration_end,
				'contributing_groups'         => $contributing_groups,
				'registration_solidarity'     => true,
			)
		);

		if ( null !== $billing_deadline ) {
			self::create_cost_unit( $event_name, $event_email, $billing_deadline );
		}

		self::create_event_register_page( $event );
	}

	/**
	 * Creates a registration page for the event.
	 *
	 * @param Event $event The event object.
	 */
	public static function create_event_register_page( Event $event ) {
		$page_name = $event->event_name . ' - ' . __( 'Registration', 'solea' );
		$page_id   = wp_insert_post(
			array(
				'post_title'   => $page_name,
				'post_content' =>
					'<!-- wp:shortcode -->' . PHP_EOL .
					'[solea-list-events event-id=' . $event->id . ']' . PHP_EOL .
					'<!-- /wp:shortcode -->',
				'post_status'  => 'publish',
				'post_type'    => 'page',
			)
		);
	}

	/**
	 * Creates a cost unit for the event.
	 *
	 * @param string $event_name The name of the event.
	 * @param string $event_email The email associated with the event.
	 * @param string $billing_deadline The billing deadline.
	 */
	public static function create_cost_unit( string $event_name, string $event_email, string $billing_deadline ) {
		apply_filters(
			'mareike_add_cost_center',
			$event_name,
			1,
			$event_email,
			0.25,
			false,
			$billing_deadline,
			get_current_user_id()
		);
	}

	/**
	 * Generates an event name based on the plain event name and the event start date.
	 *
	 * @param string $plain_event_name The plain name of the event.
	 * @param string $event_begin The start date of the event.
	 * @return string The generated event name.
	 */
	public static function generate_event_name( string $plain_event_name, string $event_begin ): string {
		$date = explode( '-', $event_begin );
		return $date[0] . '-' . $date[1] . '_' . $plain_event_name;
	}
}
