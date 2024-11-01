<?php
/**
 * File: composer.php
 *
 * @since 2024-07-27
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/Mails
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$send_url = admin_url( 'admin.php?page=' . $slug . '&active-tab=' . $tab . '&action=send-mail' );
?>

<div class="solea-page">
	<form method="post" action="<?php echo esc_url( $send_url ); ?>">
		<input type="hidden" name="sendmail" value="1" />
		<h3><?php echo esc_html__( 'Send mass mail', 'solea' ); ?></h3>



		<table>
			<tr style="vertical-align: top;">
				<td><?php echo esc_html__( 'Recipient(s)', 'solea' ); ?></td>
				<td>
					<textarea name="recipient" rows="12" style="width: 768px;"><?php echo esc_html( implode( ', ', $recipients ) ); ?></textarea>
				</td>
			</tr>


			<tr>
				<td><?php echo esc_html__( 'Send copy', 'solea' ); ?></td>
				<td>
					<input type="checkbox" checked name="send_copy" id="send_copy" />
					<label for="send_copy" style="cursor: pointer;"><?php echo esc_html__( 'Send copy to event management', 'solea' ); ?></label>
				</td>
			</tr>

			<tr>
				<td><?php echo esc_html__( 'Subject', 'solea' ); ?></td>
				<td><input type="text" name="subject" value="[solea] " style="width: 768px;"/></td>
			</tr>

			<tr style="vertical-align: top">
				<td><?php echo esc_html__( 'Message', 'solea' ); ?></td>
				<td style="padding-top: 0 !important;">
				<?php
					wp_editor(
						'',
						'mycustomeditor',
						array(
							'textarea_name' => 'mail-text',
							'media_buttons' => true,
							'tinymce'       => array( 'content_style' => 'html{ background: none !important; margin-top: 0 !important; }' ),

						)
					);
					?>
					</td>
			</tr>

			<tr>
				<td colspan="2">
					<input type="submit" class="button solea-button" value="<?php echo esc_html__( 'Submit' ); ?>" />
				</td>
			</tr>
		</table>
	</form>
</div>
