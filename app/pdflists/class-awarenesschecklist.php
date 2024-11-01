<?php
/**
 * File: class-awarenesschecklist.php
 *
 * @since 2024-10-28
 * @license GPL-3.0-or-later
 *
 * @package
 */

namespace Solea\PdfLists;

use Solea\App\models\Event;
use Solea\App\Requests\GetLocalGroupName;
use Solea\App\Requests\GetLocalGroupZip;
use Solea\App\Requests\GetParticipationTypeName;
use Solea\Libs\FileAccess;

class AwarenessCheckList
{
    /**
     * This method returns the table header for the given event name.
     *
     * @return string The table header as a string.
     */
    private function get_table_header(): string {
        return '"' . __( 'First name', 'solea' ) . '",' .
            '"' . __( 'Last name', 'solea' ) . '",' .
            '"' . __( 'Participant group', 'solea' ) . '",' .
            '"' . __( 'Local group', 'solea' ) . '",' .
            '"' . __( 'Birthday', 'solea' ) . '",' .
            '"' . __( 'Age', 'solea' ) . '",' .
            '"' . __( 'E-mail address', 'solea' ) . '",' .
            '"' . __( 'Street, House Number:', 'solea' ) . '",' .
            '"' . __( 'Postal Code, City:', 'solea' ) . '",' .
            '"' . __( 'Extended police clearance certificate', 'solea' ) . ' ' . __('existence checked', 'solea') . '",' .
            '"' . __( 'Extended police clearance certificate', 'solea' ) . ' ' . __('existing', 'solea') . '"';
    }

    /**
     * Class constructor
     *
     * @param Event $event The event object.
     *
     * @return void
     */
    public function __construct( Event $event ) {
        $output = $this->get_table_header() . PHP_EOL;

        foreach ( $event->get_participants_by_group() as $group => $participants ) {
            foreach ( $participants as $participant ) {
                if (!solea_is_fullaged($participant->birthday)) {
                    continue;
                }

                $output .= '"' . $participant->firstname . '",' .
                    '"' . $participant->lastname . '",' .
                    '"' . GetParticipationTypeName::execute( $participant->participant_group ) . '",' .
                    '"' . GetLocalGroupName::execute( $participant->local_group ) . '",' .
                    '"' . \DateTime::createFromFormat( 'Y-m-d', $participant->birthday )->format( 'd.m.Y' ) . '",' .
                    '"' . solea_get_age( $participant->birthday ) . '",' .
                    '"' . $participant->email_1 . '",' .
                    '"' . $participant->street . ' ' . $participant->number . '",' .
                    '"' . $participant->zip . ' ' . $participant->city . '",' .
                    '"' . __('No', 'solea') . '",' .
                    '""' . PHP_EOL;
            }
        }

        $filename = $event->event_name . '_' . __( 'Participant list', 'solea' ) . '.csv';

        header( 'Content-Type: text/csv' );
        header( 'Content-Disposition: attachment; filename="' . $filename );

        $file_access = new FileAccess();
        $dir         = wp_upload_dir();

        $file_access->put_contents( $dir['path'] . '/export.csv', $output, SOLEA_WP_FS_CHMOD_FILE );
        $file_access->output_file( $dir['path'] . '/export.csv' );
        $file_access->delete( $dir['path'] . '/export.csv' );

        exit;
    }
}