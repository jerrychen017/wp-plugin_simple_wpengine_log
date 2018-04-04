<?php // SCL - Settings Callbacks

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

// callback: validate plugin settings
function SCL_callback_validate_options($input) {

	// todo: add validation functionality..

	return $input;

}

// callback: bucket section
function SCL_callback_section_bucket() {

	echo '<p>These settings enable you to specify the target AWS bucket.</p>';

}


// callback: text field
function SCL_callback_field_text( $args ) {

	$options = get_option( 'SCL_options', SCL_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$value = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

	echo '<input id="SCL_options_'. $id .'" name="SCL_options['. $id .']" type="text" size="40" value="'. $value .'"><br />';
	echo '<label for="SCL_options_'. $id .'">'. $label .'</label>';

}
