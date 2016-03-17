<?php
/**
 * @author James Lafferty
 * @since 0.1
 */

class NS_Widget_MailChimp extends WP_Widget {
	private $default_failure_message;
	private $default_loader_graphic = CORTEX_WIDGETS_IMAGES_URL . '/ajax-loader.gif';
	private $default_signup_text;
	private $default_success_message;
	private $default_title;
	private $successful_signup = false;
	private $subscribe_errors;
	private $ns_mc_plugin;

	/**
	 * @author James Lafferty
	 * @since 0.1
	 */
	public function __construct() {
		$this->default_failure_message = __('There was a problem processing your submission.', 'cortex-widgets');
		$this->default_signup_text = __('Subscribe', 'cortex-widgets');
		$this->default_success_message = __('Thank you for joining our mailing list. Please check your email for a confirmation link.', 'cortex-widgets');
		$this->default_title = __('Sign up for our mailing list.', 'cortex-widgets');
		$widget_options = array('classname' => 'widget-cortex-mailchimp', 'description' => __( "Displays a sign-up form for a MailChimp mailing list.", 'cortex-widgets'));
		parent::__construct('widget_cortex_mailchimp', __('Cortex MailChimp', 'cortex-widgets'), $widget_options);
		$this->ns_mc_plugin = NS_MC_Plugin::get_instance();
		$this->default_loader_graphic = CORTEX_WIDGETS_IMAGES_URL . '/ajax-loader.gif';
		add_action('init', array(&$this, 'add_scripts'));
		add_action('parse_request', array(&$this, 'process_submission'));
	}

	/**
	 * @author James Lafferty
	 * @since 0.1
	 */

	public function add_scripts () {
		wp_enqueue_script('ns-mc-widget', CORTEX_WIDGETS_JS_URL . '/mailchimp-widget-min.js', array('jquery'), false);
	}

	/**
	 * @author James Lafferty
	 * @since 0.1
	 */

	public function form ($instance) {
		$mcapi = $this->ns_mc_plugin->get_mcapi();
		if (false == $mcapi) {
			echo $this->ns_mc_plugin->get_admin_notices();
		} else {
			$this->lists = $mcapi->lists();
			$defaults = array(
				'failure_message' => $this->default_failure_message,
				'title' => $this->default_title,
				'signup_text' => $this->default_signup_text,
				'success_message' => $this->default_success_message,
				'collect_first' => false,
				'collect_last' => false,
				'old_markup' => false
			);
			$vars = wp_parse_args($instance, $defaults);
			extract($vars);
			?>
					<h3><?php echo  __('General Settings', 'cortex-widgets'); ?></h3>
					<p>
						<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo  __('Title:', 'cortex-widgets'); ?></label>
						<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
					</p>
					<p>
						<label for="<?php echo $this->get_field_id('current_mailing_list'); ?>"><?php echo __('Select a Mailing List:', 'cortex-widgets'); ?></label>
						<select class="widefat" id="<?php echo $this->get_field_id('current_mailing_list');?>" name="<?php echo $this->get_field_name('current_mailing_list'); ?>">
			<?php
			foreach ($this->lists['data'] as $key => $value) {
				$selected = (isset($current_mailing_list) && $current_mailing_list == $value['id']) ? ' selected="selected" ' : '';
				?>
						<option <?php echo $selected; ?>value="<?php echo $value['id']; ?>"><?php echo __($value['name'], 'cortex-widgets'); ?></option>
				<?php
			}
			?>
						</select>
					</p>
					<p><strong>N.B.</strong><?php echo  __('This is the list your users will be signing up for in your sidebar.', 'cortex-widgets'); ?></p>
					<p>
						<label for="<?php echo $this->get_field_id('signup_text'); ?>"><?php echo __('Sign Up Button Text:', 'cortex-widgets'); ?></label>
						<input class="widefat" id="<?php echo $this->get_field_id('signup_text'); ?>" name="<?php echo $this->get_field_name('signup_text'); ?>" value="<?php echo $signup_text; ?>" />
					</p>
					<h3><?php echo __('Personal Information', 'cortex-widgets'); ?></h3>
					<p><?php echo __("These fields won't (and shouldn't) be required. Should the widget form collect users' first and last names?", 'cortex-widgets'); ?></p>
					<p>
						<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('collect_first'); ?>" name="<?php echo $this->get_field_name('collect_first'); ?>" <?php echo  checked($collect_first, true, false); ?> />
						<label for="<?php echo $this->get_field_id('collect_first'); ?>"><?php echo  __('Collect first name.', 'cortex-widgets'); ?></label>
						<br />
						<input type="checkbox" class="checkbox" id="<?php echo  $this->get_field_id('collect_last'); ?>" name="<?php echo $this->get_field_name('collect_last'); ?>" <?php echo checked($collect_last, true, false); ?> />
						<label><?php echo __('Collect last name.', 'cortex-widgets'); ?></label>
					</p>
					<h3><?php echo __('Notifications', 'cortex-widgets'); ?></h3>
					<p><?php echo  __('Use these fields to customize what your visitors see after they submit the form', 'cortex-widgets'); ?></p>
					<p>
						<label for="<?php echo $this->get_field_id('success_message'); ?>"><?php echo __('Success :', 'cortex-widgets'); ?></label>
						<textarea class="widefat" id="<?php echo $this->get_field_id('success_message'); ?>" name="<?php echo $this->get_field_name('success_message'); ?>"><?php echo $success_message; ?></textarea>
					</p>
					<p>
						<label for="<?php echo $this->get_field_id('failure_message'); ?>"><?php echo __('Failure :', 'cortex-widgets'); ?></label>
						<textarea class="widefat" id="<?php echo $this->get_field_id('failure_message'); ?>" name="<?php echo $this->get_field_name('failure_message'); ?>"><?php echo $failure_message; ?></textarea>
					</p>
			<?php

		}
	}

	/**
	 * @author James Lafferty
	 * @since 0.1
	 */

	public function process_submission () {

		if (isset($_GET[$this->id_base . '_email'])) {

			header("Content-Type: application/json");

			//Assume the worst.
			$response = '';
			$result = array('success' => false, 'error' => $this->get_failure_message($_GET['ns_mc_number']));

			$merge_vars = array();

			if (! is_email($_GET[$this->id_base . '_email'])) { //Use WordPress's built-in is_email function to validate input.

				$response = json_encode($result); //If it's not a valid email address, just encode the defaults.

			} else {

				$mcapi = $this->ns_mc_plugin->get_mcapi();

				if (false == $this->ns_mc_plugin) {

					$response = json_encode($result);

				} else {

					if (isset($_GET[$this->id_base . '_first_name']) && is_string($_GET[$this->id_base . '_first_name'])) {

						$merge_vars['FNAME'] = $_GET[$this->id_base . '_first_name'];

					}

					if (isset($_GET[$this->id_base . '_last_name']) && is_string($_GET[$this->id_base . '_last_name'])) {

						$merge_vars['LNAME'] = $_GET[$this->id_base . '_last_name'];

					}

					$subscribed = $mcapi->listSubscribe($this->get_current_mailing_list_id($_GET['ns_mc_number']), $_GET[$this->id_base . '_email'], $merge_vars);

					if (false == $subscribed) {

						$response = json_encode($result);

					} else {

						$result['success'] = true;
						$result['error'] = '';
						$result['success_message'] =  $this->get_success_message($_GET['ns_mc_number']);
						$response = json_encode($result);

					}

				}

			}

			exit($response);

		} elseif (isset($_POST[$this->id_base . '_email'])) {

			$this->subscribe_errors = '<div class="error">'  . $this->get_failure_message($_POST['ns_mc_number']) .  '</div>';

			if (! is_email($_POST[$this->id_base . '_email'])) {

				return false;

			}

			$mcapi = $this->ns_mc_plugin->get_mcapi();

			if (false == $mcapi) {

				return false;

			}

			if (is_string($_POST[$this->id_base . '_first_name'])  && '' != $_POST[$this->id_base . '_first_name']) {

				$merge_vars['FNAME'] = strip_tags($_POST[$this->id_base . '_first_name']);

			}

			if (is_string($_POST[$this->id_base . '_last_name']) && '' != $_POST[$this->id_base . '_last_name']) {

				$merge_vars['LNAME'] = strip_tags($_POST[$this->id_base . '_last_name']);

			}

			$subscribed = $mcapi->listSubscribe($this->get_current_mailing_list_id($_POST['ns_mc_number']), $_POST[$this->id_base . '_email'], $merge_vars);

			if (false == $subscribed) {

				return false;

			} else {

				$this->subscribe_errors = '';

				setcookie($this->id_base . '-' . $this->number, $this->hash_mailing_list_id(), time() + 31556926);

				$this->successful_signup = true;

				$this->signup_success_message = '<p>' . $this->get_success_message($_POST['ns_mc_number']) . '</p>';

				return true;

			}

		}

	}

	/**
	 * @author James Lafferty
	 * @since 0.1
	 */

	public function update ($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['collect_first'] = ! empty($new_instance['collect_first']);

		$instance['collect_last'] = ! empty($new_instance['collect_last']);

		$instance['current_mailing_list'] = esc_attr($new_instance['current_mailing_list']);

		$instance['failure_message'] = esc_attr($new_instance['failure_message']);

		$instance['signup_text'] = esc_attr($new_instance['signup_text']);

		$instance['success_message'] = esc_attr($new_instance['success_message']);

		$instance['title'] = esc_attr($new_instance['title']);

		return $instance;

	}

	/**
	 * @author James Lafferty
	 * @since 0.1
	 */

	public function widget ($args, $instance) {

		extract($args);

		if ((isset($_COOKIE[$this->id_base . '-' . $this->number]) && $this->hash_mailing_list_id($this->number) == $_COOKIE[$this->id_base . '-' . $this->number]) || false == $this->ns_mc_plugin->get_mcapi()) {

			return 0;

		} else {

			echo $before_widget . $before_title . $instance['title'] . $after_title;

			if ($this->successful_signup) {
				echo $this->signup_success_message;
			} else {

					// check for template in active theme
					$template = cortex_widget_get_template('widget-mailchimp-template.php');

					// if none found use the default template
					if ( $template == '' ) $template = CORTEX_WIDGETS_PATH . '/widget-templates/widget-mailchimp-template.php';

					include ( $template );


			}
			echo $after_widget;
		}

	}

	/**
	 * @author James Lafferty
	 * @since 0.1
	 */

	private function hash_mailing_list_id () {

		$options = get_option($this->option_name);

		$hash = md5($options[$this->number]['current_mailing_list']);

		return $hash;

	}

	/**
	 * @author James Lafferty
	 * @since 0.1
	 */

	private function get_current_mailing_list_id ($number = null) {

		$options = get_option($this->option_name);

		return $options[$number]['current_mailing_list'];

	}

	/**
	 * @author James Lafferty
	 * @since 0.5
	 */

	private function get_failure_message ($number = null) {

		$options = get_option($this->option_name);

		return $options[$number]['failure_message'];

	}

	/**
	 * @author James Lafferty
	 * @since 0.5
	 */

	private function get_success_message ($number = null) {

		$options = get_option($this->option_name);

		return $options[$number]['success_message'];

	}

}

?>
