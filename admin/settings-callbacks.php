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
// TODO: use aws function call instead
function swl_options_select() {

	return array(

		'default'   => 'Please select your AWS region',
		'us-east-1'     => 'us-east-1 US East (N. Virginia)',
		'us-east-2'      => 'us-east-2 US East (Ohio)',
		'us-west-1'    => 'us-west-1 US West (N. California)',
		'us-west-2' => 'us-west-2 US West (Oregon)',
		'ca-central-1'  => 'ca-central-1 Canada (Central)',
		'eu-central-1'     => 'eu-central-1 EU (Frankfurt)',
		'eu-west-1'   => 'eu-west-1 EU (Ireland)',
		'eu-west-2'   => 'eu-west-2 EU (London)',
		'eu-west-3'   => 'eu-west-3 EU (Paris)',
		'ap-northeast-1'   => 'ap-northeast-1 Asia Pacific (Tokyo)',
		'ap-northeast-2'   => 'ap-northeast-2 Asia Pacific (Seoul)',
		'ap-northeast-3'   => 'ap-northeast-3 Asia Pacific (Osaka-Local)',
		'ap-southeast-1'   => 'ap-southeast-1 Asia Pacific (Singapore)',
		'ap-southeast-2'   => 'ap-southeast-2 Asia Pacific (Sydney)',
		'ap-south-1'   => 'ap-south-1 Asia Pacific (Mumbai)',
		'sa-east-1'   => 'sa-east-1 South America (São Paulo)',
	);

}

// callback: select field
function swl_callback_field_select( $args ) {

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
