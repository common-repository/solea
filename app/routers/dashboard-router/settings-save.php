<?php
/**
 * File: settings-save.php
 *
 * @since 2024-07-30
 * @license GPL-3.0-or-later
 *
 * @package solea/Routers/Partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $_SESSION['solea_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['solea_nonce'] ) ) ) ) {
	wp_die( 'Invalid Router call' );
}

if ( ! isset( $_REQUEST['icon_children'] ) ||
	! isset( $_REQUEST['icon_adults'] ) ||
	! isset( $_REQUEST['registration_order_url'] ) ||
	! isset( $_REQUEST['central_member_management'] ) ||
	! isset( $_REQUEST['account_owner'] ) ||
	! isset( $_REQUEST['account_iban'] )
) {
	wp_die( 'Missing form params for updating.' );
}

update_option( 'solea_icon_children', sanitize_url( wp_unslash( $_REQUEST['icon_children'] ) ) );
update_option( 'solea_icon_adults', sanitize_url( wp_unslash( $_REQUEST['icon_adults'] ) ) );
update_option( 'solea_registration_order_url', sanitize_url( wp_unslash( $_REQUEST['registration_order_url'] ) ) );
update_option( 'solea_account_owner', sanitize_text_field( wp_unslash( $_REQUEST['account_owner'] ) ) );
update_option( 'solea_account_iban', sanitize_text_field( wp_unslash( $_REQUEST['account_iban'] ) ) );
update_option( 'solea_central_member_management', sanitize_email( wp_unslash( $_REQUEST['central_member_management'] ) ) );


solea_show_message( __( 'The settings are saved', 'solea' ) );
