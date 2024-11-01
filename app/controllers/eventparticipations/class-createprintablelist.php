<?php
/**
 * File: class-createprintablelist.php
 *
 * @since 2024-07-25
 * @license GPL-3.0-or-later
 *
 * @package Solea/Controllers/EventParticipations
 */

namespace solea\App\Controllers\EventParticipations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\models\Event;
use Solea\PdfLists\AmountList;
use Solea\PdfLists\AwarenessCheckList;
use Solea\PdfLists\Drinking;
use Solea\PdfLists\DrinkingAlcoholic;
use Solea\PdfLists\FirstAidList;
use Solea\PdfLists\KitchenAllergies;
use Solea\PdfLists\KitchenOverview;
use Solea\PdfLists\ParticipantCSVList;
use Solea\PdfLists\ParticipantList;
use Solea\PdfLists\PhotoPermission;
/**
 * Class CreatePrintableList
 *
 * Handles the creation of various types of printable lists for an event.
 */
class CreatePrintableList {

	/**
	 * Executes the creation of a specified printable list for the given event.
	 *
	 * Depending on the `list_type`, a different type of list object is instantiated.
	 *
	 * @param Event  $event The event for which the printable list is being created.
	 * @param string $list_type The type of printable list to create possible values include.
	 *                          - 'participantlist'
	 *                          - 'kitchenoverview'
	 *                          - 'kitchenallergies'
	 *                          - 'firstaid'
	 *                          - 'amountlist'
	 *                          - 'alcoholiclist'
	 *                          - 'non-alcoholiclist'
	 *                          - 'photopermission'
	 *                          - 'participant-csvlist'.
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException If an invalid list type is provided.
	 */
	public static function execute( Event $event, string $list_type ) {
		switch ( $list_type ) {
			case 'participantlist':
				new ParticipantList( $event );
				break;

			case 'kitchenoverview':
				new KitchenOverview( $event );
				break;

			case 'kitchenallergies':
				new KitchenAllergies( $event );
				break;

			case 'firstaid':
				new FirstAidList( $event );
				break;

			case 'amountlist':
				new AmountList( $event );
				break;

			case 'alcoholiclist':
				new DrinkingAlcoholic( $event );
				break;

			case 'non-alcoholiclist':
				new Drinking( $event );
				break;

			case 'photopermission':
				new PhotoPermission( $event );
				break;

			case 'participant-csvlist':
				new ParticipantCSVList( $event );
				break;

            case 'awarenesschecklist':
                new AwarenessCheckList( $event );
                break;

			default:
				throw new InvalidArgumentException( 'Invalid list type provided.' );
		}
	}
}
