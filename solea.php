<?php
/**
 * Plugin Name:  solea
 * Description: A tool for organisating events and keep participants in mind.
 * Version: 2.2
 * Tags: solea, events, management, budgeting
 * Requires at least: 6.0
 * Requires PHP: 8.2
 * Author: Thomas Günther
 * Author URI: https://www.contelli.de
 * Text Domain: solea
 *  License: GPLv3
 *  License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package solea
 *
 *  Copyright  2024 by Thomas Günther (tidschi)
 *
 *  Licenced under the GNU GPL:
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'core/init.php';

add_shortcode( 'solea-list-events', array( 'Solea\App\Routers\FrontendRouter', 'execute' ) );
add_action( 'after_setup_theme', 'solea_setup_roles' );
add_action( 'admin_enqueue_scripts', 'solea_admin_setup' );
add_action( 'admin_menu', 'solea_add_menu' );
add_action( 'wp_ajax_solea_show_ajax', 'solea_load_ajax_content' );
add_action( 'wp_ajax_nopriv_solea_show_ajax', 'solea_load_ajax_content' );
add_action( 'network_admin_menu', 'solea_network_add_menu' );
add_action( 'wp_initialize_site', 'solea_new_blog_setup', 10, 2 );
add_action( 'plugins_loaded', 'solea_localization_setup' );
add_filter( 'admin_enqueue_scripts', 'solea_enqueue_custom_scripts', 10 );
