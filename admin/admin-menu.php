<?php // Simple WPEngine - Admin Menu

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// add sub-level administrative menu
function swl_add_sublevel_menu() {

	/*

	add_submenu_page(
		string   $parent_slug,
		string   $page_title,
		string   $menu_title,
		string   $capability,
		string   $menu_slug,
		callable $function = ''
	);

	*/

	add_submenu_page(
		'options-general.php',
		'WPE Log Copier Settings',
		'WPE Log Copier',
		'manage_options',
		'simple_wpengine_log',
		'swl_display_settings_page'
	);

}
add_action( 'admin_menu', 'swl_add_sublevel_menu' );
