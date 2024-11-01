<?php
/**
 * File: group-easy.php
 *
 * @since 2024-07-22
 * @license GPL-3.0-or-later
 *
 * @package Solea/Views/Registration/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<table>
	<tr style="vertical-align: top;">
		<td><?php echo esc_html__( 'On the event', 'solea' ); ?>...</td>
		<td>
			<input style="width: 20px;" type="radio" name="participant_group" value="team" id="gruppe_2" />
			<label for="gruppe_2">... <?php echo esc_html__( 'I mainly take on tasks and support the team', 'solea' ); ?></label><br />
			<input style="width: 20px;" type="radio" name="participant_group" value="volunteer" id="gruppe_3" checked />
			<label for="gruppe_3">... <?php echo esc_html__( 'I mainly look after my group', 'solea' ); ?></label><br />
			<input style="width: 20px;" type="radio" name="participant_group" value="participant" id="gruppe_1" checked />
			<label for="gruppe_1">... <?php echo esc_html__( 'I would like to participate in the program mainly', 'solea' ); ?></label><br />
		</td>
	</tr>
</table>
<input type="button" value="<?php echo esc_html__( 'Previous', 'solea' ); ?>" onclick="showStep(3)" />
<input type="button" value="<?php echo esc_html__( 'Next', 'solea' ); ?>" onclick="showStep(5)" />
