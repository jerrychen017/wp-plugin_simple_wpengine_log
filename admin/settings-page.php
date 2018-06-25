<?php // Simple WPEngine Log - Settings

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// display the plugin settings page
function swl_display_settings_page() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;

	?>

	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">

			<?php

			// output security fields
			settings_fields( 'swl_options' );

			// output setting sections
			do_settings_sections( 'simple_wpengine_log' );

			// save changes button
			submit_button();

			?>

		</form>

		<form action="core-functions.php" method="copy_log">

			<?php
			// execute button
			submit_button('Execute', 'primary', 'execute');

			// schedule button
			submit_button('Schedule', 'primary', 'schedule');

			// unschedule button
			submit_button('Unschedule', 'primary', 'unschedule');
			
			?>
		</form>
	</div>

	<?php

}
