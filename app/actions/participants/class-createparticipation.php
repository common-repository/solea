<?php
/**
 * File: class-createparticipation.php
 *
 * @since 2024-07-23
 * @license GPL-3.0-or-later
 *
 * @package Solea/Actions/Participants
 */

namespace solea\App\Actions\Participants;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\App\models\Participant;
use Solea\Libs\MailLibrary;

/**
 * Class CreateParticipation
 *
 * Handles the creation of a participant registration for a specific event.
 */
class CreateParticipation {

	/**
	 * Creates a participant record for the specified event with the provided details.
	 *
	 * @param Event  $event The event object containing details about the event.
	 * @param string $participant_group The group the participant belongs to.
	 * @param string $firstname The first name of the participant.
	 * @param string $lastname The last name of the participant.
	 * @param string $nickname The nickname of the participant.
	 * @param string $birthday The birthday of the participant in 'Y-m-d' format.
	 * @param int    $local_group The ID of the local group the participant is associated with.
	 * @param string $contact_person The name of the contact person for the participant.
	 * @param string $street The street address of the participant.
	 * @param string $number The street number of the participant.
	 * @param string $zip The ZIP code of the participant's address.
	 * @param string $city The city of the participant's address.
	 * @param string $email_1 The primary email address of the participant.
	 * @param string $email_2 The secondary email address of the participant (optional).
	 * @param string $telefon_1 The primary telephone number of the participant.
	 * @param string $telefon_2 The secondary telephone number of the participant (optional).
	 * @param string $eating_habit The eating habit of the participant.
	 * @param string $swimming_permission Indicates if the participant has swimming permission.
	 * @param string $allergies Any allergies the participant has.
     * @param string $intolerances Any food intolerances the participant has.
	 * @param string $medication Any medication the participant is taking.
	 * @param string $notices Any additional notices or special requirements for the participant.
	 * @param float  $amount The amount paid by the participant.
	 * @param string $arrival The arrival time of the participant.
	 * @param int    $arrival_eating Indicates the meal preference upon arrival.
	 * @param string $departure The departure time of the participant.
	 * @param int    $departure_eating Indicates the meal preference upon departure.
	 * @param bool   $foto_socialmedia Whether to use participant's photo on social media.
	 * @param bool   $foto_print Whether to use participant's photo in print media.
	 * @param bool   $foto_webseite Whether to use participant's photo on the website.
	 * @param bool   $foto_partner Whether to use participant's photo for partner organizations.
	 * @param bool   $foto_intern Whether to use participant's photo internally.
	 * @return Participant|null The created participant object if successful, or null if the creation fails.
	 */
	public static function execute(
		Event $event,
		string $participant_group,
		string $firstname,
		string $lastname,
		string $nickname,
		string $birthday,
		int $local_group,
		string $contact_person,
		string $street,
		string $number,
		string $zip,
		string $city,
		string $email_1,
		string $email_2,
		string $telefon_1,
		string $telefon_2,
		string $eating_habit,
		string $swimming_permission,
		string $allergies,
        string $intolerances,
		string $medication,
		string $notices,
		float $amount,
		string $arrival,
		int $arrival_eating,
		string $departure,
		int $departure_eating,
		bool $foto_socialmedia,
		bool $foto_print,
		bool $foto_webseite,
		bool $foto_partner,
		bool $foto_intern
	): ?Participant {

		$creation_data = array(
			'event_id'            => $event->id,
			'participant_group'   => $participant_group,
			'firstname'           => $firstname,
			'lastname'            => $lastname,
			'nickname'            => $nickname,
			'birthday'            => $birthday,
			'local_group'         => $local_group,
			'contact_person'      => $contact_person,
			'street'              => $street,
			'number'              => $number,
			'zip'                 => $zip,
			'city'                => $city,
			'email_1'             => $email_1,
			'email_2'             => $email_2,
			'telefon_1'           => $telefon_1,
			'telefon_2'           => $telefon_2,
			'swimming_permission' => $swimming_permission,
			'allergies'           => $allergies,
			'medication'          => $medication,
            'intolerances'        => $intolerances,
			'notices'             => $notices,
			'amount'              => $amount,
			'arrival'             => $arrival,
			'arrival_eating'      => $arrival_eating,
			'departure'           => $departure,
			'departure_eating'    => $departure_eating,
			'foto_socialmedia'    => $foto_socialmedia,
			'foto_print'          => $foto_print,
			'foto_webseite'       => $foto_webseite,
			'foto_partner'        => $foto_partner,
			'foto_intern'         => $foto_intern,
			'eating_habit'        => $eating_habit,
		);

		try {
			$participant = Participant::create( $creation_data );
			return $participant;
		} catch ( Exception $ex ) {
			$mail = new MailLibrary();
			$mail->set_message( print_r( $creation_data, true ) );
			$mail->set_recipients( $event->get_organiser_mails() );
			$mail->set_subject(
				'[solea] ' . wp_sprintf(
					/* Translators: %s is the name of the event */
					__( 'Registration for event "%s" has failed', 'solea' ),
					$event->event_name
				)
			);
			return null;
		}
	}
}
