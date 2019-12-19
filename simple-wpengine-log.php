<?php
/*
Plugin Name: Simple WPEngine Log
Description: A plugin that copies over access and error log files to a designated AWS bucket on a weekly basis.
Plugin URI:  https://plugin-planet.com/
Author:      Guangrui Chen - Jerry
Author URI:  http://guangruichen.com
Version:     1.0
License:     GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.txt

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version
3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
with this program. If not, visit: https://www.gnu.org/licenses/
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// if admin area
if (is_admin()) {

    // include dependencies
    require_once plugin_dir_path(__FILE__) . 'admin/admin-menu.php';
    require_once plugin_dir_path(__FILE__) . 'admin/settings-page.php';
    require_once plugin_dir_path(__FILE__) . 'admin/settings-register.php';
    require_once plugin_dir_path(__FILE__) . 'admin/settings-callbacks.php';
    require_once plugin_dir_path(__FILE__) . 'admin/settings-validate.php';

}

// include dependencies: admin and public
require_once plugin_dir_path(__FILE__) . 'includes/core-functions.php';

// default plugin options
function swl_options_default()
{

    return array(
        // aws region
        'aws_region' => 'us-east-1',
        // correspoinding aws endpoint. Please visit https://docs.aws.amazon.com/general/latest/gr/rande.html for reference.
        'aws_endpoint' => 's3.amazonaws.com',
        // aws secrete access key id
        'aws_access_id' => '',
        // aws secrete access key
        'aws_access_key' => '',
        // name of your designated aws bucket
        'aws_bucket_name' => '',
        // location of WPEngine current access log
        'wpe_access_loc' => '',
        // location of WPEngine current error log
        'wpe_error_loc' => '',
        // the email that will be sent notifications to
        'swl_email' => '',
        // frequency that the plugin copies files
        'swl_frequency' => 'daily',

    );

}
