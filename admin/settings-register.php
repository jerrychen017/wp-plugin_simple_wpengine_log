<?php // Simple WPEngine Log - Register Settings

// exit if file is called directly
if (!defined('ABSPATH')) {

    exit;

}

// register plugin settings
function swl_register_settings()
{

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

// aws region
    add_settings_field(
        'aws_region',
        'Region',
        'swl_callback_field_text',
        'simple_wpengine_log',
        'swl_section_bucket',
        ['id' => 'aws_region', 'label' => 'Your AWS Region']
    );

// aws endpoint
    add_settings_field(
        'aws_endpoint',
        'AWS Endpoint',
        'swl_callback_field_text',
        'simple_wpengine_log',
        'swl_section_bucket',
        ['id' => 'aws_endpoint', 'label' => 'Your AWS Endpoint']
    );

// aws access key id
    add_settings_field(
        'aws_access_id',
        'AWS Access ID',
        'swl_callback_field_text',
        'simple_wpengine_log',
        'swl_section_bucket',
        ['id' => 'aws_access_id', 'label' => 'Your AWS Access ID']
    );

// aws secrete access key
    add_settings_field(
        'aws_access_key',
        'AWS Access Key',
        'swl_callback_field_text',
        'simple_wpengine_log',
        'swl_section_bucket',
        ['id' => 'aws_access_key', 'label' => 'Your AWS Access Key']
    );

// desinated aws bucket name
    add_settings_field(
        'aws_bucket_name',
        'AWS Bucket Name',
        'swl_callback_field_text',
        'simple_wpengine_log',
        'swl_section_bucket',
        ['id' => 'aws_bucket_name', 'label' => 'Your Desinated AWS Bucket Name']
    );

// WPE access log location
    add_settings_field(
        'wpe_access_loc',
        'WPEngine Current Access Log Location',
        'swl_callback_field_text',
        'simple_wpengine_log',
        'swl_section_bucket',
        ['id' => 'wpe_access_loc', 'label' => 'Your WPEngine Current Access Log Location']
    );

// WPE error log location
    add_settings_field(
        'wpe_error_loc',
        'WPEngine Current Error Log Location',
        'swl_callback_field_text',
        'simple_wpengine_log',
        'swl_section_bucket',
        ['id' => 'wpe_error_loc', 'label' => 'Your WPEngine Current Error Log Location']
    );

// email that will be sent notifications to
    add_settings_field(
        'swl_email',
        'Email Notifications',
        'swl_callback_field_text',
        'simple_wpengine_log',
        'swl_section_bucket',
        ['id' => 'swl_email', 'label' => 'Email Notifications After Each Successful Upload']
    );

// frequency
    add_settings_field(
        'swl_frequency',
        esc_html__('Frequency', 'swl'),
        'swl_callback_field_select',
        'simple_wpengine_log',
        'swl_section_bucket',
        ['id' => 'swl_frequency', 'label' => esc_html__('Choose frequency for copying log files', 'simple_wpengine_log')]
    );

}

add_action('admin_init', 'swl_register_settings');
