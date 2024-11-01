<?php
/**
 * File: cronjob.php
 *
 * @since 2024-07-29
 * @license GPL-3.0-or-later
 *
 * @package Solea/core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'cron_schedules', 'solea_add_cron_intervals' );

/**
 * Adds a cron interval every 24 hours
 *
 * @param array $schedules already existing schedules.
 *
 * @return mixed
 */
function solea_add_cron_intervals( $schedules ) {
	$schedules['solea_daily'] = array(
		'interval' => 86400,
		'display'  => esc_html__( 'Every 24 hours', 'solea' ),
	);

	$schedules['solea_every_sunday'] = array(
		'interval' => WEEK_IN_SECONDS,
		'display'  => esc_html__( 'Weekly', 'solea' ),
	);

	return $schedules;
}

/**
 * Registers the cronjobs for solea
 *
 * @return void
 */
function solea_register_cron() {
	if ( ! wp_next_scheduled( 'solea/daily/maintenance' ) ) {
		$timestamp = strtotime( 'Tomorrow 02:15' );
		wp_schedule_event( $timestamp, 'solea_daily', 'solea/daily/maintenance' );
	}

	if ( ! wp_next_scheduled( 'solea/daily/informmangement' ) ) {
		$timestamp = strtotime( 'Tomorrow 07:00' );
		wp_schedule_event( $timestamp, 'solea_daily', 'solea/daily/informmangement' );
	}

	if ( ! wp_next_scheduled( 'solea/sunday/information' ) ) {
		$timestamp = strtotime( 'next Sunday 20:00' );
		wp_schedule_event( $timestamp, 'weekly', 'solea/sunday/information' );
	}
}

solea_register_cron();

add_action( 'solea/sunday/information', array( '\Solea\App\Tasks\WeeklyInformManagement', 'execute' ) );
add_action( 'solea/daily/maintenance', array( '\Solea\App\Tasks\DailyMaintenance', 'execute' ) );
add_action( 'solea/daily/informmangement', array( '\Solea\App\Tasks\RemindEventManagement', 'execute' ) );
