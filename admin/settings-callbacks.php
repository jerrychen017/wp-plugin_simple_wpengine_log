<?php // Simple WPEngine Log - Settings Callbacks

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

// callback: bucket section
function swl_callback_section_bucket() {

	echo '<p>These settings enable you to specify the target AWS bucket.</p>';

}


// callback: text field
function swl_callback_field_text( $args ) {

	$options = get_option( 'swl_options', swl_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$value = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

	echo '<input id="swl_options_'. $id .'" name="swl_options['. $id .']" type="text" size="40" value="'. $value .'"><br />';
	echo '<label for="swl_options_'. $id .'">'. $label .'</label>';

}
