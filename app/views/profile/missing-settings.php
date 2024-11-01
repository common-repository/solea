<?php
/**
 * File missing-settings.php
 *
 * Template to diplay that axditional data are missing
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package solea/views/Profile
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div style="padding: 10px 10px; font-size: 15pt; margin-top: 20px; line-height: 30px; background-color: #f0f0f0; border-left: #f10905 10px solid;">
	<p>
		<?php echo esc_html__( 'Your profile is not complete.', 'solea' ); ?><br />
		<?php echo esc_html__( 'Please complete', 'solea' ); ?>
		<a href="<?php echo esc_url( admin_url( 'users.php?page=solea-profile' ) ); ?>">
			<?php echo esc_html__( 'your profile', 'solea' ); ?>
		</a>
		<?php echo esc_html__( 'to be able to use all comfort functions.', 'solea' ); ?><br />
	</p>
</div>
