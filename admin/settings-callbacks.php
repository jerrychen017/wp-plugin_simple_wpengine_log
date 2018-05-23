<?php // Simple WPEngine Log - Settings Callbacks

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

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


// select field options
function swl_options_select() {
	return array(
		'default'   => esc_html__('Default',   'swl'),
		'hourly'     => esc_html__('Hourly',     'swl'),
		'twicedaily'      => esc_html__('Twice Daily',      'swl'),
		'daily'    => esc_html__('Daily',    'swl'),

	);

}

// callback: select field
function myplugin_callback_field_select( $args ) {

	$options = get_option( 'swl_options', swl_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$selected_option = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

	$select_options = swl_options_select();

	echo '<select id="swl_options_'. $id .'" name="swl_options['. $id .']">';

	foreach ( $select_options as $value => $option ) {

		$selected = selected( $selected_option === $value, true, false );

		echo '<option value="'. $value .'"'. $selected .'>'. $option .'</option>';
		
	}

	echo '</select> <label for="swl_options_'. $id .'">'. $label .'</label>';

}
