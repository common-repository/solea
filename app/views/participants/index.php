<?php
/**
 * File: index.php
 *
 * @since 2024-07-25
 * @license GPL-3.0-or-later
 *
 * @package solea/Views/Participants
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="wrap">
	<hr class="wp-header-end">

	<h3>
		<?php echo esc_html( $event->event_name ); ?>
		(<?php echo esc_html( \DateTime::createFromFormat( 'Y-m-d', $event->date_begin )->format( 'd.m.Y' ) ); ?> -
		<?php echo esc_html( \DateTime::createFromFormat( 'Y-m-d', $event->date_end )->format( 'd.m.Y' ) ); ?>)
	</h3>

	<div class="solea_overlay" id="kompasss_participant_details" >
		<div class="solea-overlay-content"  onclick="document.getElementById('kompasss_participant_details').style.display='block';">
			<div id="kompass_participant_data"  onclick="document.getElementById('kompasss_participant_details').style.display='block';" ></div>
		</div>
	</div>

	<h2 class="nav-tab-wrapper solea-events" >
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=' . $slug . '&tab=tab1' ) ); ?>"
			class="nav-tab <?php echo 'tab1' === $active_tab ? esc_html( 'nav-tab-active' ) : ''; ?> ">
			<?php echo esc_html__( 'Event overview', 'solea' ); ?>
		</a>

		<a href="<?php echo esc_url( admin_url( 'admin.php?page=' . $slug . '&tab=tab2' ) ); ?>"
			class="nav-tab <?php echo 'tab2' === $active_tab ? esc_html( 'nav-tab-active' ) : ''; ?> ">
			<?php echo esc_html__( 'Participants by local group', 'solea' ); ?>
		</a>

		<a href="<?php echo esc_url( admin_url( 'admin.php?page=' . $slug . '&tab=tab3' ) ); ?>"
			class="nav-tab <?php echo 'tab3' === $active_tab ? esc_html( 'nav-tab-active' ) : ''; ?> ">
			<?php echo esc_html__( 'Participants by participation group', 'solea' ); ?>
		</a>

		<a href="<?php echo esc_url( admin_url( 'admin.php?page=' . $slug . '&tab=tab4' ) ); ?>"
			class="nav-tab <?php echo 'tab4' === $active_tab ? esc_html( 'nav-tab-active' ) : ''; ?> ">
			<?php echo esc_html__( 'Deregistered participants', 'solea' ); ?>
		</a>

		<a href="<?php echo esc_url( admin_url( 'admin.php?page=' . $slug . '&tab=tab5' ) ); ?>"
			class="nav-tab <?php echo 'tab5' === $active_tab ? esc_html( 'nav-tab-active' ) : ''; ?> ">
			<?php echo esc_html__( 'Event settings', 'solea' ); ?>
		</a>
	</h2>
	<div class="tab-content">
