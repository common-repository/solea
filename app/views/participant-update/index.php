<?php
/**
 * File: index.php
 *
 * @since 2024-07-26
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/Participants
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=' . $slug . '&tab=' . $active_tab . '&action=edit-participant&participant-id=' . $participant->id ) ); ?>">
	<input type="hidden" name="save" value="1" />
	<?php
			require 'participation.php';
	require 'contactperson.php';
	?>
	<div class="solea-page">
		<h3><?php echo esc_html__( 'Personaldata', 'solea' ); ?></h3>
		<table>
			<tr style="vertical-align: top;">
				<td style="width: 50%;"><?php require 'contactdata.php'; ?></td>
				<td><?php require 'allergies.php'; ?></td>
			</tr>
		</table>
	</div>
</form>
