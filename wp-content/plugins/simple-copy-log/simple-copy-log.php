<?php
/*
Plugin Name: Simple Copy Log Plugin
Description: A plugin that copies over access and error log files to a designated AWS bucket on a weekly basis.
Plugin URI:  https://plugin-planet.com/
Author:      Guangrui Chen - Jerry
Version:     1.0
License:     GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.txt

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version
2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
with this program. If not, visit: https://www.gnu.org/licenses/
*/

// a function that calls activation actions
function myplugin_on_activation() {

    if ( ! current_user_can( 'activate_plugins' ) ) return;

    add_option( 'myplugin_posts_per_page', 10 );
    add_option( 'myplugin_show_welcome_page', true );

}
register_activation_hook( __FILE__, 'myplugin_on_activation' );