<?php
/**
 * File: age.php
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
<div onclick="showStep(2)" class="solea_age_selector">

			<div>
				<h3><?php echo esc_html__( 'Register my child', 'solea' ); ?></h3>
				<?php echo esc_html__( 'My child is not yet of full-aged, I would like to register my child for the event.', 'solea' ); ?>
			</div>
			<p class="solea_emblems_selection">
			<img src="<?php echo esc_url( get_option( 'solea_icon_children', SOLEA_PLUGIN_URL . '/assets/images/children.svg' ) ); ?>" style="width: 150px; height: 75px;" />

			</p>
		</div>

<div onclick="showStep(3)"  class="solea_age_selector">
	<div>
			<h3><?php echo esc_html__( 'Register myself', 'solea' ); ?></h3>
			<?php echo esc_html__( 'I am full-aged and would like to register for the event.', 'solea' ); ?>
			</div>
			<p class="solea_emblems_selection">
				<img src="<?php echo esc_url( get_option( 'solea_icon_adults', SOLEA_PLUGIN_URL . '/assets/images/adults.svg' ) ); ?>" style="width: 150px; height: 75px;" />
			</p>
		</div>
