<?php // SCL - Admin Menu

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

// add sub-level administrative menu
function SCL_add_sublevel_menu() {

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
		'Simple Copy Log Settings',
		'Simple Copy Log',
		'manage_options',
		'simple_copy_log',
		'SCL_display_settings_page'
	);

}
add_action( 'admin_menu', 'SCL_add_sublevel_menu' );
