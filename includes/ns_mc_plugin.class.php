<?php

class NS_MC_Plugin {
	private $options;
	private static $instance;
	private static $mcapi;
	private static $name = 'NS_MC_Plugin';
	private static $prefix = 'ns_mc';
	private static $public_option = 'no';
	private static $textdomain = 'cortex-widgets';

	private function __construct () {

		//requires pluggable to check if this is a logged in user
		require( ABSPATH . WPINC . '/pluggable.php' );

		//pulls in ACF functions for getting theme options
		require( get_template_directory() . '/admin/acf/acf.php' );

		//set the mailchimp api key to the current options
		$mailchimp_api_key = get_field('mailchimp_api_key', 'option');

		$current_user = wp_get_current_user();

		//after getting current user info, check to see if they have entered in a mailchimp key, if they haven't show notice
		if ( empty($mailchimp_api_key) ) {
			$c9_notice_set = get_user_meta($current_user->ID, 'cortex_mailchimp_ignore_notice');
			if ( empty($c9_notice_set) ) {
				add_action('admin_notices', array(&$this, 'admin_notices'));
			}
		}

		 // Add our widget when widgets get intialized.
		add_action('widgets_init', create_function('', 'return register_widget("NS_Widget_MailChimp");'));

	}

	public static function get_instance () {
		if (empty(self::$instance)) {
			self::$instance = new self::$name;
		}
		return self::$instance;
	}

	public function admin_notices () {
		echo '<div id="mailchimp-api-needed" class="error fade notice is-dismissible">' . $this->get_admin_notices() . '</div>';
	}

	public function get_admin_notices () {
		global $blog_id;
		$notice = '<p>';
		$notice .= __('You\'ll need to set up the MailChimp signup widget options before using it. ', 'cortex-widgets') . __('You can make your changes', 'cortex-widgets') . ' <a href="' . get_admin_url($blog_id) . 'admin.php?page=cortex-options">' . __('here', 'cortex-widgets') . '.</a>';
		$notice .= '</p>';
		return $notice;
	}

	public function get_mcapi () {
		$api_key = $this->get_api_key();
		if (false == $api_key) {
			return false;
		} else {
			if (empty(self::$mcapi)) {
				self::$mcapi = new MCAPI($api_key);
			}
			return self::$mcapi;
		}
	}

	private function get_api_key () {

		$mailchimp_api_key = get_field('mailchimp_api_key', 'option');

		if ( !empty($mailchimp_api_key) ) {
			return $mailchimp_api_key;
		} else {
			return false;
		}
	}


}
?>
