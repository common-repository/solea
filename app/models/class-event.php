<?php
/**
 * File: Event.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package solea/Models
 */

namespace Solea\App\models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Illuminate\Database\Eloquent\Collection;

/**
 * Class Event
 *
 * Represents an event.
 */
class Event extends MainModel {

	/**
	 * Fillable database fields.
	 *
	 * @var string[] Database keys you can use.
	 */
	protected $fillable = array(
		'event_name',
		'event_email',
		'event_organisator_id',
		'event_treasurer_id',
		'archived',
		'signup_allowed',
		'date_begin',
		'date_end',
		'last_minute_begin',
		'registration_end',
		'amount_team',
		'amount_volunteer',
		'amount_participant',
		'amount_online',
		'amount_other',
		'amount_reduced',
		'amount_social',
		'total_amount_max',
		'notices',
		'increase_amount_last_minute',
		'description_team',
		'description_volunteer',
		'description_participant',
		'description_other',
		'weekly_report',
		'enable_all_eating',
		'age_alcoholics',
		'contributing_groups',
		'payment_direct',
		'registration_solidarity',
		'account_iban',
		'account_owner',
		'event_url',
	);

	/**
	 * Constructor of class.
	 */
	public function __construct() {
		parent::__construct( get_class( $this ) );
	}

	/**
	 * Get participants by group.
	 *
	 * @return array Grouped participants.
	 */
	public function get_participants_by_group(): array {
		$participants = Participant::where(
			array(
				'event_id'        => $this->id,
				'date_unregister' => null,
			)
		)->get();

		$grouped_participants = array();

		foreach ( $participants as $participant ) {
			$grouped_participants[ $participant->local_group ][] = $participant;
		}

		return $grouped_participants;
	}

	/**
	 * Get total amount of payments.
	 *
	 * @return array Array with 'paid' and 'total' amounts.
	 */
	public function get_total_amount(): array {
		$amount       = array(
			'paid'  => 0,
			'total' => 0,
		);
		$participants = Participant::where(
			array(
				'event_id'        => $this->id,
				'date_unregister' => null,
			)
		)->get();

		foreach ( $participants as $participant ) {
			$amount['paid']  += $participant->amount_paid;
			$amount['total'] += $participant->amount;
		}

		return $amount;
	}

	/**
	 * Get all participants.
	 *
	 * @return Collection Participants.
	 */
	public function get_all_participants(): Collection {
		return Participant::where(
			array(
				'event_id'        => $this->id,
				'date_unregister' => null,
			)
		)->get();
	}

	/**
	 * Get participants by participation type.
	 *
	 * @return array Grouped participants by participation type.
	 */
	public function get_participants_by_participation(): array {
		$participants = Participant::where(
			array(
				'event_id'        => $this->id,
				'date_unregister' => null,
			)
		)->get();

		$grouped_participants = array();

		foreach ( $participants as $participant ) {
			$grouped_participants[ $participant->participant_group ][] = $participant;
		}

		return $grouped_participants;
	}

	/**
	 * Get unregistered participants.
	 *
	 * @return array Grouped unregistered participants.
	 */
	public function get_unregistered_participants(): array {
		$participants = Participant::where( array( 'event_id' => $this->id ) )
									->whereNotNull( 'date_unregister' )
									->get();

		$grouped_participants = array( __( 'Deregistered participants', 'solea' ) => array() );

		foreach ( $participants as $participant ) {
			$grouped_participants[ __( 'Deregistered participants', 'solea' ) ][] = $participant;
		}

		return $grouped_participants;
	}

	/**
	 * Get participation groups based on amounts.
	 *
	 * @return array Array of participation groups.
	 */
	public function get_participation_groups() {
		$groups = array();

		if ( null !== $this->amount_participant ) {
			$groups[] = Participant::PARTICIPATION_GROUP_PARTICIPANT;
		}
		if ( null !== $this->amount_volunteer ) {
			$groups[] = Participant::PARTICIPATION_GROUP_VOLUNTEER;
		}
		if ( null !== $this->amount_team ) {
			$groups[] = Participant::PARTICIPATION_GROUP_TEAM;
		}
		if ( null !== $this->amount_other ) {
			$groups[] = Participant::PARTICIPATION_GROUP_OTHER;
		}
		if ( null !== $this->amount_online ) {
			$groups[] = Participant::PARTICIPATION_GROUP_ONLINE;
		}

		return $groups;
	}

	/**
	 * Get organizer email addresses.
	 *
	 * @param bool $with_treasurer Whether to include the treasurer's email.
	 *
	 * @return array List of email addresses.
	 */
	public function get_organiser_mails( bool $with_treasurer = false ): array {
		$return = array( $this->event_email );
		if ( null !== $this->event_organisator_id ) {
			$additional_user = get_user_by( 'id', $this->event_organisator_id );
			$return[]        = $additional_user->user_email();
		}

		if ( $with_treasurer && null !== $this->event_treasurer_id ) {
			$additional_user_treasurer = get_user_by( 'id', $this->event_treasurer_id );
			$return[]                  = $additional_user_treasurer->user_email();
		}

		return $return;
	}

	/**
	 * Get allowed groups based on contributing groups.
	 *
	 * @return Collection Allowed local groups.
	 */
	public function get_allowed_groups(): Collection {
		$group_ids = explode( ',', $this->contributing_groups );
		return LocalGroup::whereIn( 'id', $group_ids )->get();
	}

	/**
	 * List events with permissions.
	 *
	 * @param bool $archived Whether to include archived events.
	 *
	 * @return Collection List of events.
	 */
	public static function list_with_permissions( bool $archived = false ): Collection {
		$user_id = get_current_user_id();
		if (
			current_user_can( 'edit_events' ) ||
			current_user_can( 'edit_invoices' )
		) {
			return self::where( 'archived', $archived )->get();
		}

		return self::where( 'archived', $archived )
					->where(
						function ( $query ) use ( $user_id ) {
							$query->where( 'event_organisator_id', $user_id )
								->orWhere( 'event_organisator_id', $user_id );
						}
					)
					->get();
	}

	/**
	 * Get event with permission check.
	 *
	 * @param int $id The event ID.
	 *
	 * @return Event The event object.
	 */
	public static function get_with_permission_check( int $id ): Event {
		if ( current_user_can( 'edit_events' ) || current_user_can( 'edit_invoices' ) ) {
			$object = self::where( 'id', $id )->first();
		} else {
			$user_id = get_current_user_id();
			$object  = self::where( 'id', $id )
							->where(
								function ( $query ) use ( $user_id ) {
									$query->where( 'event_organisator_id', $user_id )
										->orWhere( 'event_organisator_id', $user_id );
								}
							)
							->first();
		}

		if ( null === $object ) {
			wp_die( 'Event: No suitable event found.' );
		}

		return $object;
	}

	/**
	 * List closed events.
	 *
	 * @return Collection List of closed events.
	 */
	public static function list_closed_events(): Collection {
		return self::where(
			array(
				'archived'       => false,
				'signup_allowed' => false,
			)
		)->get();
	}

	/**
	 * List open events.
	 *
	 * @return Collection List of open events.
	 */
	public static function list_open_events(): Collection {
		return self::where(
			array(
				'archived'       => false,
				'signup_allowed' => true,
			)
		)->get();
	}
}
