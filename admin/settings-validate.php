<?php // Simple WPEngine Log - Validate Settings

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

// callback: validate options
function swl_callback_validate_options( $input ) {

	// aws reigon
	if ( isset( $input['aws_reigon'] ) ) {

		$input['aws_reigon'] = sanitize_text_field( $input['aws_reigon'] );

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

	return $input;

}
