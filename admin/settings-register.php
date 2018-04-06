<?php // Simple WPEngine Log - Register Settings

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// register plugin settings
function swl_register_settings() {

	register_setting(
		'swl_options',
		'swl_options',
		'swl_callback_validate_options'
	);

	add_settings_section(
		'swl_section_bucket',
		'Set AWS Bucket',
		'swl_callback_section_bucket',
		'simple_wpengine_log'
	);

add_settings_field(
		'aws_reigon',
		'Reigon',
		'swl_callback_field_select',
		'simple_wpengine_log',
		'swl_section_bucket',
		[ 'id' => 'aws_reigon', 'label' => 'Your AWS Reigon' ]
	);

add_settings_field(
  'aws_access_id',
  'AWS Access Key ID',
  'swl_callback_field_text',
  'simple_wpengine_log',
  'swl_section_bucket',
  [ 'id' => 'aws_access_id', 'label' => 'Your AWS Access Key ID' ]
);

add_settings_field(
  'aws_access_key',
  'AWS Secret Access Key',
  'swl_callback_field_text',
  'simple_wpengine_log',
  'swl_section_bucket',
  [ 'id' => 'aws_access_key', 'label' => 'Your AWS Secret Access Key' ]
);

add_settings_field(
  'aws_bucket_name',
  'AWS Bucket Name',
  'swl_callback_field_text',
  'simple_wpengine_log',
  'swl_section_bucket',
  [ 'id' => 'aws_bucket_name', 'label' => 'Your Desinated AWS Bucket Name' ]
);

}
add_action( 'admin_init', 'swl_register_settings' );
