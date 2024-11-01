<?php
/**
 * File: showdetails.php
 *
 * @since 2024-07-26
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/Participants
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Solea\App\Requests\BathRequest;
use Solea\App\Requests\EatingHabit;
use Solea\App\Requests\GetLocalGroupName;

?>
<div>
	<table style="width:100%;" class="solea-participant-details">
		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Full aged', 'solea' ); ?>
			</td>
			<td>
				<?php echo solea_is_fullaged( $participant->birthday ) ? esc_html__( 'Yes' ) : esc_html__( 'No' ); ?><br />
				<?php echo esc_html( \DateTime::createFromFormat( 'Y-m-d', $participant->birthday )->format( 'd.m.Y' ) ); ?>
				(<?php echo esc_html( solea_get_age( $participant->birthday ) . ' ' . esc_html__( 'Years', 'solea' ) ); ?>)
			</td>
		</tr>
		<?php
		if ( ! solea_is_fullaged( $participant->birthday ) ) {
			?>
			<tr>
				<td><?php echo esc_html__( 'Name of contact person', 'solea' ); ?>:</td>
				<td><?php echo esc_html( $participant->contact_person ); ?></td>
			</tr>

			<?php
		}
		?>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Address', 'solea' ); ?>:
			</td>
			<td>
				<?php echo esc_html( $participant->street . ' ' . $participant->number ); ?><br />
				<?php echo esc_html( $participant->zip . ' ' . $participant->city ); ?>
			</td>
		</tr>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Local group', 'solea' ); ?>:
			</td>
			<td>
				<?php echo esc_html( GetLocalGroupName::execute( $participant->local_group ) ); ?>
			</td>
		</tr>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Arrival', 'solea' ); ?>:
			</td>
			<td>
				<?php echo esc_html( \DateTime::createFromFormat( 'Y-m-d', $participant->arrival )->format( 'd.m.Y' ) ); ?>
			</td>
		</tr>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Departure', 'solea' ); ?>:
			</td>
			<td>
				<?php echo esc_html( \DateTime::createFromFormat( 'Y-m-d', $participant->departure )->format( 'd.m.Y' ) ); ?>
			</td>
		</tr>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'E-mail address', 'solea' ); ?>:
			</td>
			<td>
				<?php
				solea_get_email_link( $participant->email_1, true );
				if ( ! solea_is_fullaged( $participant->birthday ) ) {
					echo esc_html( ' / ' );
					solea_get_email_link( $participant->email_2, true );
				}
				?>
			</td>
		</tr>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Telephone', 'solea' ); ?>:
			</td>
			<td>
				<?php
				solea_get_telephone_link( $participant->telefon_1, true );
				if ( ! solea_is_fullaged( $participant->birthday ) ) {
					echo esc_html( ' / ' );
					solea_get_telephone_link( $participant->telefon_2, true );
				}
				?>
			</td>
		</tr>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Photo Permission Social Media', 'solea' ); ?>:
			</td>
			<td>
				<?php echo $participant->foto_socialmedia ? esc_html__( 'Yes' ) : esc_html__( 'No' ); ?>
			</td>
		</tr>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Photo Permission Print Media', 'solea' ); ?>:
			</td>
			<td>
				<?php echo $participant->foto_print ? esc_html__( 'Yes' ) : esc_html__( 'No' ); ?>
			</td>
		</tr>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Photo Permission Websites', 'solea' ); ?>:
			</td>
			<td>
				<?php echo $participant->foto_webseite ? esc_html__( 'Yes' ) : esc_html__( 'No' ); ?>
			</td>
		</tr>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Photo Permission Partner Mailings', 'solea' ); ?>:
			</td>
			<td>
				<?php echo $participant->foto_partner ? esc_html__( 'Yes' ) : esc_html__( 'No' ); ?>
			</td>
		</tr>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Photo Permission Internal Archives', 'solea' ); ?>:
			</td>
			<td>
				<?php echo $participant->foto_intern ? esc_html__( 'Yes' ) : esc_html__( 'No' ); ?>
			</td>
		</tr>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Swimming permission', 'solea' ); ?>:
			</td>
			<td>
				<?php echo esc_html( BathRequest::execute( $participant->swimming_permission ) ); ?>
			</td>
		</tr>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Eating habits', 'solea' ); ?>:
			</td>
			<td>
				<?php echo esc_html( EatingHabit::execute( $participant->eating_habit ) ); ?>
			</td>
		</tr>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Allergies', 'solea' ); ?>:
			</td>
			<td>
				<?php echo esc_html( $participant->allergies ); ?>
			</td>
		</tr>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Medication', 'solea' ); ?>:
			</td>
			<td>
				<?php echo esc_html( $participant->medication ); ?>
			</td>
		</tr>

		<tr style="vertical-align: top;">
			<td style="width: 300px;">
				<?php echo esc_html__( 'Notices', 'solea' ); ?>:
			</td>
			<td>
				<?php echo nl2br( esc_html( $participant->notices ) ); ?>
			</td>
		</tr>
	</table>
</div>
