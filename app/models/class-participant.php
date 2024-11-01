<?php
/**
 * File: class-participant.php
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

/**
 * Class Participant
 *
 * Represents a participant in an event.
 */
class Participant extends MainModel {

	public const PARTICIPATION_GROUP_PARTICIPANT = 'participant';
	public const PARTICIPATION_GROUP_VOLUNTEER   = 'volunteer';
	public const PARTICIPATION_GROUP_TEAM        = 'team';
	public const PARTICIPATION_GROUP_OTHER       = 'other';
	public const PARTICIPATION_GROUP_ONLINE      = 'online';

	/**
	 * Fillable database fields.
	 *
	 * @var string[] Database keys you can use.
	 */
	protected $fillable = array(
		'event_id',
		'participant_group',
		'firstname',
		'lastname',
		'nickname',
		'local_group',
		'birthday',
		'contact_person',
		'street',
		'number',
		'zip',
		'city',
		'email_1',
		'email_2',
		'telefon_1',
		'telefon_2',
		'swimming_permission',
		'allergies',
		'intolerances',
		'medication',
		'eating_habit',
		'foto_socialmedia',
		'foto_print',
		'foto_webseite',
		'foto_partner',
		'foto_intern',
		'notices',
		'amount',
		'amount_paid',
		'arrival',
		'arrival_eating',
		'departure',
		'departure_eating',
		'date_unregister',
	);

	/**
	 * Constructor of the class.
	 */
	public function __construct() {
		parent::__construct( get_class( $this ) );
	}

	/**
	 * Get a participant with permission check.
	 *
	 * @param int $id The ID of the participant.
	 * @return Participant The participant instance.
	 */
	public static function get_with_permission_check( int $id ): Participant {
		$participant = self::where( 'id', $id )->first();
		if ( null === $participant ) {
			wp_die( 'Participant: No suitable object found.' );
		}

		Event::get_with_permission_check( $participant->event_id );
		return $participant;
	}

	/**
	 * Get the email address of the local group.
	 *
	 * @return string The email address of the local group.
	 */
	public function get_local_group_mail(): string {
		$local_group = LocalGroup::where( 'id', $this->local_group )->first();
		return $local_group->email;
	}

	/**
	 * Retrieves the email address of the member management of the local group associated with this instance.
	 *
	 * @return string The email address of the member management of the local group.
	 */
	public function get_local_group_membermanagement_mail(): string {
		$local_group = LocalGroup::where( 'id', $this->local_group )->first();
		return $local_group->members_email;
	}
}
