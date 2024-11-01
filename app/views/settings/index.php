<?php
/**
 * File: index.php
 *
 * @since 2024-07-22
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/Settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="wrap">
	<hr class="wp-header-end">

	<h3><?php echo esc_html__( 'solea settings', 'solea' ); ?></h3>

	<h2 class="nav-tab-wrapper" >
		<a
			href="<?php echo esc_url( admin_url( 'options-general.php?page=' . $slug . '&tab=tab2' ) ); ?>"
			class="nav-tab <?php echo 'tab2' === $active_tab ? esc_html( 'nav-tab-active' ) : ''; ?> "
		>
			<?php echo esc_html__( 'Local groups', 'solea' ); ?>
		</a>

		<?php
		if ( current_user_can( 'manage_options' ) ) {
			?>
			<a
				href="<?php echo esc_url( admin_url( 'options-general.php?page=' . $slug . '&tab=tab1' ) ); ?>"
				class="nav-tab <?php echo 'tab1' === $active_tab ? esc_html( 'nav-tab-active' ) : ''; ?> "
			>
				<?php echo esc_html__( 'Options', 'solea' ); ?>
			</a>
		<?php } ?>
	</h2>
	<div class="tab-content">

