<?php // SCL - Register Settings

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

// register plugin settings
function SCL_register_settings() {

	/*

	register_setting(
		string   $option_group,
		string   $option_name,
		callable $sanitize_callback
	);

	*/

	register_setting(
		'SCL_options',
		'SCL_options',
		'SCL_callback_validate_options'
	);

  /*

	add_settings_section(
		string   $id,
		string   $title,
		callable $callback,
		string   $page
	);

	*/

	add_settings_section(
		'SCL_section_bucket',
		'Set AWS Bucket',
		'SCL_callback_section_bucket',
		'simple_copy_log'
	);

  /*

add_settings_field(
    string   $id,
  string   $title,
  callable $callback,
  string   $page,
  string   $section = 'default',
  array    $args = []
);

*/

add_settings_field(
  'aws_reigon',
  'Reigon',
  'SCL_callback_field_text',
  'simple_copy_log',
  'SCL_section_bucket',
  [ 'id' => 'aws_reigon', 'label' => 'Your AWS Access Key' ]
);

add_settings_field(
  'aws_access_id',
  'AWS Access ID',
  'SCL_callback_field_text',
  'simple_copy_log',
  'SCL_section_bucket',
  [ 'id' => 'aws_access_id', 'label' => 'Your AWS Access ID' ]
);

add_settings_field(
  'aws_access_key',
  'AWS Access Key',
  'SCL_callback_field_text',
  'simple_copy_log',
  'SCL_section_bucket',
  [ 'id' => 'aws_access_key', 'label' => 'Your AWS Access Key' ]
);

}
add_action( 'admin_init', 'SCL_register_settings' );
