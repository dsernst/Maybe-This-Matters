<?php

function mc4wp_get_options($key = null) {
	static $options;

	if(!$options) {
		$defaults = array(
			'general' => array(
				'api_key' => ''
			),
			'checkbox' => array(
				'label' => 'Sign me up for the newsletter!',
				'precheck' => 1,
				'css' => 1,
				'show_at_comment_form' => 0,
				'show_at_registration_form' => 0,
				'show_at_multisite_form' => 0,
				'show_at_buddypress_form' => 0,
				'show_at_bbpress_forms' => 0,
				'lists' => array(),
				'double_optin' => 1
			),
			'form' => array(
				'css' => 'default',
				'markup' => "<p>\n\t<label for=\"mc4wp_email\">Email address: </label>\n\t<input type=\"email\" id=\"mc4wp_email\" name=\"EMAIL\" required placeholder=\"Your email address\" />\n</p>\n\n<p>\n\t<input type=\"submit\" value=\"Sign up\" />\n</p>",
				'text_success' => 'Thank you, your sign-up request was successful! Please check your e-mail inbox.',
				'text_error' => 'Oops. Something went wrong. Please try again later.',
				'text_invalid_email' => 'Please provide a valid email address.',
				'text_already_subscribed' => "Given email address is already subscribed, thank you!",
				'redirect' => '',
				'lists' => array(),
				'double_optin' => 1,
				'hide_after_success' => 0
			)
		);

		$db_keys_option_keys = array(
			'mc4wp_lite' => 'general',
			'mc4wp_lite_checkbox' => 'checkbox',
			'mc4wp_lite_form' => 'form'
		);

		$options = array();
		foreach ( $db_keys_option_keys as $db_key => $option_key ) {
			$option = get_option( $db_key );

			// add option to database to prevent query on every pageload
			if ( $option == false ) { add_option( $db_key, $defaults[$option_key] ); }

			$options[$option_key] = array_merge( $defaults[$option_key], (array) $option );
		}
	}

	if($key) {
		return $options[$key];
	}

	return $options;
}

function mc4wp_get_api() {
	static $api;

	if(!$api) {
		require_once MC4WP_LITE_PLUGIN_DIR . 'includes/class-api.php';
		$opts = mc4wp_get_options();
		$api = new MC4WP_Lite_API( $opts['general']['api_key'] );
	}

	return $api;
}