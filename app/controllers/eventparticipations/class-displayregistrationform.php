<?php
/**
 * File: class-displayregistrationform.php
 *
 * @since 2024-07-22
 * @license GPL-3.0-or-later
 *
 * @package solea/Controllers/EventParticipations
 */

namespace solea\App\Controllers\EventParticipations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;

/**
 * Class DisplayRegistrationForm
 *
 * Handles the display and initialization of the registration form for an event.
 * This includes setting up form data, enqueuing necessary scripts and styles,
 * and providing default values based on user data if available.
 */
class DisplayRegistrationForm {

	/**
	 * Executes the display logic for the registration form of a specific event.
	 *
	 * Initializes necessary data and enqueues scripts and styles for the registration form.
	 * It also handles user-specific data if the user is logged in and adjusts registration amounts
	 * based on the current date and event settings.
	 *
	 * @param int $event_id The ID of the event for which the registration form is to be displayed.
	 *
	 * @return void
	 *
	 * @throws \Exception If there is an issue with date formatting or any other unexpected errors occur.
	 */
	public static function execute( int $event_id ) {
		$plugin_data = get_plugin_data( SOLEA_PLUGIN_STARTUP_FILE );

		$event        = Event::where( 'id', $event_id )->first();
		$local_groups = $event->get_allowed_groups();

		$_SESSION['solea_nonce'] = esc_html( wp_create_nonce() );

		$today             = new \DateTime();
		$last_minute_start = \DateTime::createFromFormat( 'Y-m-d', $event->last_minute_begin );
		$registration_end  = \DateTime::createFromFormat( 'Y-m-d', $event->registration_end );

		if ( ! $event->signup_allowed ) {
			require SOLEA_TEMPLATE_DIR . '/event-registration/not-active.php';
			return;
		}

		$amount_factor = 1;
		if ( $today->getTimestamp() >= $last_minute_start->getTimestamp() ) {
			$amount_factor += (int) $event->increase_amount_last_minute / 100;
		}

		$event_start = \DateTime::createFromFormat( 'Y-m-d', $event->date_begin );
		$event_end   = \DateTime::createFromFormat( 'Y-m-d', $event->date_end );
		$interval    = $event_end->diff( $event_start );
		$days        = $interval->days;

		if ( null !== $event->amount_team ) {
			$event->amount_team *= $amount_factor;
		}
		if ( null !== $event->amount_volunteer ) {
			$event->amount_volunteer *= $amount_factor;
		}
		if ( null !== $event->amount_participant ) {
			$event->amount_participant *= $amount_factor;
		}
		if ( null !== $event->amount_online ) {
			$event->amount_online *= $amount_factor;
		}
		if ( null !== $event->amount_other ) {
			$event->amount_other *= $amount_factor;
		}
		if ( null !== $event->amount_reduced ) {
			$event->amount_reduced *= $amount_factor;
		}
		if ( null !== $event->amount_social ) {
			$event->amount_social *= $amount_factor;
		}
		if ( null !== $event->total_amount_max ) {
			$event->total_amount_max *= $amount_factor;
		}

		$amount = $event->amount_participant;
		$groups = array();

		if ( ! $event->registration_solidarity ) {
			$amount = $days * $event->amount_participant;
			$groups = $event->get_participation_groups();
		}

		wp_enqueue_script(
			'solea-particpant-registration',
			SOLEA_PLUGIN_URL . '/assets/javascripts/event-participant-registration.js',
			array(),
			$plugin_data['Version'],
			array( 'in_footer' => false )
		);

		wp_enqueue_style(
			'solea-public-css',
			SOLEA_PLUGIN_URL . '/assets/stylesheets/infoicon.css',
			array(),
			$plugin_data['Version']
		);

		wp_enqueue_script(
			'solea-infoicon',
			SOLEA_PLUGIN_URL . '/assets/javascripts/infoicon.js',
			array(),
			$plugin_data['Version'],
			array( 'in_footer' => false )
		);

		wp_enqueue_style(
			'solea-participant-registration-style',
			SOLEA_PLUGIN_URL . '/assets/stylesheets/participant-registration.css',
			array(),
			$plugin_data['Version']
		);

		wp_localize_script(
			'solea-particpant-registration',
			'solea_event',
			array(
				'solidarity_event'   => $event->registration_solidarity,
				'amount_team'        => $event->amount_team,
				'amount_volunteer'   => $event->amount_volunteer,
				'amount_participant' => $event->amount_participant,
				'amount_online'      => $event->amount_online,
				'amount_other'       => $event->amount_other,
				'amount_reduced'     => $event->amount_reduced,
				'amount_social'      => $event->amount_social,
				'total_amount_max'   => $event->total_amount_max,
				'days'               => $days,
				'event_start'        => $event->date_begin,
				'event_end'          => $event->date_end,
			)
		);

		$firstname    = '';
		$lastname     = '';
		$nickname     = '';
		$email        = '';
		$localgroup   = '';
		$birthday     = '';
		$street       = '';
		$number       = '';
		$zipcode      = '';
		$city         = '';
		$phone        = '';
		$allergies    = '';
		$intolerances = '';
		$medication   = '';

		if ( is_user_logged_in() ) {
			$user         = wp_get_current_user();
			$firstname    = $user->first_name;
			$lastname     = $user->last_name;
			$email        = $user->user_email;
			$nickname     = get_the_author_meta( 'solea_nickname', $user->ID );
			$localgroup   = (int) get_the_author_meta( 'localgroup', $user->ID );
			$birthday     = get_the_author_meta( 'birthday', $user->ID );
			$street       = get_the_author_meta( 'street', $user->ID );
			$number       = get_the_author_meta( 'housenumber', $user->ID );
			$zipcode      = get_the_author_meta( 'zipcode', $user->ID );
			$city         = get_the_author_meta( 'city', $user->ID );
			$phone        = get_the_author_meta( 'telephone', $user->ID );
			$allergies    = get_the_author_meta( 'allergies', $user->ID );
			$intolerances = get_the_author_meta( 'intolerances', $user->ID );
			$medication   = get_the_author_meta( 'medication', $user->ID );
		}

		require SOLEA_TEMPLATE_DIR . '/event-registration/index.php';
	}
}
