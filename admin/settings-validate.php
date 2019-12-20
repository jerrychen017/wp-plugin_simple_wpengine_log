<?php // WPE Log Copier - Validate Settings

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// callback: validate options
function swl_callback_validate_options( $input ) {

	// aws region
	if ( isset( $input['aws_region'] ) ) {

		$input['aws_region'] = sanitize_text_field( $input['aws_region'] );

	}

	// aws endpoint
	if ( isset( $input['aws_endpoint'] ) ) {

		$input['aws_endpoint'] = sanitize_text_field( $input['aws_endpoint'] );

	}

	// aws access id
	if ( isset( $input['aws_access_id'] ) ) {

		$input['aws_access_id'] = sanitize_text_field( $input['aws_access_id'] );

	}

  // aws access key
	if ( isset( $input['aws_access_key'] ) ) {

		$input['aws_access_key'] = sanitize_text_field( $input['aws_access_key'] );

	}

  // aws bucket name
	if ( isset( $input['aws_bucket_name'] ) ) {

		$input['aws_bucket_name'] = sanitize_text_field( $input['aws_bucket_name'] );

	}

	// WPEngine current access log location
	if ( isset( $input['wpe_access_loc'] ) ) {

		$input['wpe_access_loc'] = sanitize_text_field( $input['wpe_access_loc'] );

	}

	// WPEngine current error log location
	if ( isset( $input['wpe_error_loc'] ) ) {

		$input['wpe_error_loc'] = sanitize_text_field( $input['wpe_error_loc'] );
	}

	// Email
	if ( isset( $input['swl_email'] ) ) {

		$input['swl_email'] = sanitize_text_field( $input['swl_email'] );
	}

	// frequency
$select_options = swl_options_select();

if ( ! isset( $input['swl_frequency'] ) ) {

	$input['swl_frequency'] = null;

}

if ( ! array_key_exists( $input['swl_frequency'], $select_options ) ) {

	$input['swl_frequency'] = null;

}

	return $input;

}
