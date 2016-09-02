<?php
// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

add_action( 'init', 'cortex_twitter_api' );

add_action( 'widgets_init', function(){
	register_widget('Cortex_Twitter_Widget');
});

function cortex_twitter_api() {

	global $cb;

	//include custom fields for grabbing theme options
	global $cortex_options;

	//set keys for access to twitter API
	$consumer_key		 = $cortex_options['c9-consumer-key'];
	$consumer_secret	 = $cortex_options['c9-consumer-secret'];
	$access_token		 = $cortex_options['c9-access-token'];
	$access_secret		 = $cortex_options['c9-access-token-secret'];
	$c9_twitter_keys	 = array($consumer_key, $consumer_secret, $access_token, $access_secret);

	include( CORTEX_WIDGETS_INCLUDES_PATH . '/codebird.php');

	Codebird\Codebird::setConsumerKey( $consumer_key, $consumer_secret );
	$cb = Codebird\Codebird::getInstance();
	$cb->setToken( $access_token, $access_secret );
}

class Cortex_Twitter_Widget extends WP_Widget {

	/** Widget setup **/
	function __construct() {
		parent::__construct(
		  false, __( 'Cortex Twitter', 'cortex-widgets' ),
		  array('description' => __( 'Displays a list of tweets or a single tweet from a specified user name', 'cortex-widgets' ))
		);
	}

	/** The back-end form **/
	function form( $instance ) {

		global $cortex_options;

		//set keys for access to twitter API
		$consumer_key		 = $cortex_options['c9-consumer-key'];
		$consumer_secret	 = $cortex_options['c9-consumer-secret'];
		$access_token		 = $cortex_options['c9-access-token'];
		$access_secret		 = $cortex_options['c9-access-token-secret'];
		$c9_twitter_keys	 = array($consumer_key, $consumer_secret, $access_token, $access_secret);

		// see if keys have been entered, if not send them to the options page
		if ( !in_array("", $c9_twitter_keys) ) {

			$defaults = array(
				'title'    => '',
				'limit'    => 1,
				'username' => 'covertnine',
				'avatar_icon' => true,
				'show_link' => true,
				'style' => 'basic'
			);
			$values = wp_parse_args( $instance, $defaults );

	?>
	<p>
			<div class="widet_input">
			<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e( 'Style:', 'cortex-widgets' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>">
				<option value="basic"<?php if (($values['style'] == 'basic') || ($values['style'] == '')) { echo " selected"; } ?>><?php _e('Basic List', 'cortex-widgets'); ?></option>
				<option value="darkmedium"<?php if ($values['style'] == 'darkmedium') { echo " selected"; } ?>><?php _e('Dark Medium', 'cortex-widgets'); ?></option>
				<option value="darklarge"<?php if ($values['style'] == 'darklarge') { echo " selected"; } ?>><?php _e('Dark Large', 'cortex-widgets'); ?></option>
				<option value="lightmedium"<?php if ($values['style'] == 'lightmedium') { echo " selected"; } ?>><?php _e('Light Medium', 'cortex-widgets'); ?></option>
				<option value="lightlarge"<?php if ($values['style'] == 'lightlarge') { echo " selected"; } ?>><?php _e('Light Large', 'cortex-widgets'); ?></option>
			</select>
		</div>
	</p>
	<p>
	  <label for='<?php echo $this->get_field_id( 'username' ); ?>'>
	    <?php _e( 'Twitter handle:', 'cortex-widgets' ); ?>
	    <input class='widefat' id='<?php echo $this->get_field_id( 'username' ); ?>' name='<?php echo $this->get_field_name( 'username' ); ?>' type='text' value='<?php echo $values['username']; ?>' />
	  </label>
	</p>
	<p>
	    <input class='checkbox' id='<?php echo $this->get_field_id( 'show_link' ); ?>' name='<?php echo $this->get_field_name( 'show_link' ); ?>' type='checkbox' <?php checked($values['show_link'], 'on'); ?> />
	    <label for='<?php echo $this->get_field_id( 'show_link' ); ?>'><?php _e( 'Show follow link?', 'cortex-widgets' ); ?></label>
	</p>
	<p>
	  <label for='<?php echo $this->get_field_id( 'title' ); ?>'>
	    <?php _e( 'Title: <small>(Only displays with "Basic List" option.)</small>', 'cortex-widgets' ); ?>
	    <input class='widefat' id='<?php echo $this->get_field_id( 'title' ); ?>' name='<?php echo $this->get_field_name( 'title' ); ?>' type='text' value='<?php echo $values['title']; ?>' />
	  </label>
	</p>
	<p>
	  <label for='<?php echo $this->get_field_id( 'limit' ); ?>'>
	    <?php _e( 'Tweets to show:', 'cortex-widgets' ); ?>
	    <input class='widefat' id='<?php echo $this->get_field_id( 'limit' ); ?>' name='<?php echo $this->get_field_name( 'limit' ); ?>' type='text' value='<?php echo $values['limit']; ?>' />
	  </label>
	</p>
	<p>
	    <input class='checkbox' id='<?php echo $this->get_field_id( 'avatar_icon' ); ?>' name='<?php echo $this->get_field_name( 'avatar_icon' ); ?>' type='checkbox' <?php checked($values['avatar_icon'], 'on'); ?> />
	    <label for='<?php echo $this->get_field_id( 'avatar_icon' ); ?>'><?php _e( 'Display avatar and bio? <br /><small>(Only applies to "Basic List" option.)</small>', 'cortex-widgets' ); ?></label>
	</p>
	<?php
		} else { //keys are empty
	?>
	<p>
		<?php
			$customizer_link = '<a href="' . get_admin_url() . 'admin.php?page=cortex-options">' . __('Cortex Theme Options', 'cortex-widgets') . '</a>';
			echo sprintf( __( '<small>In order to display tweets, be sure to enter your API credentials on the %s page.</small>	', 'cortex-widgets' ), $customizer_link );
		?>
	<p>
	<?php
		} //end checking for api keys
	}

	/** Saving form data **/
	function update( $new_instance, $old_instance ) {
		$instance				 = $old_instance;
		$instance['title']		 = $new_instance['title'];
		$instance['limit']		 = $new_instance['limit'];
		$instance['style']		 = $new_instance['style'];
		$instance['username']	 = $new_instance['username'];
		$instance['avatar_icon'] = $new_instance['avatar_icon'];
		$instance['show_link']	 = $new_instance['show_link'];
		return $instance;
	}

  	/** retrieving tweets **/
	function retrieve_tweets( $widget_id, $instance ) {
		global $cb;
		if ($instance['style'] == 'basic') { //check to see if more than 1 tweet is needed
			$numtweets = $instance['limit'];
			$timeline = $cb->statuses_userTimeline( 'screen_name=' . $instance['username']. '&count=' . $numtweets . '&exclude_replies=true' );
		} else { //only 1 is needed
			$timeline = $cb->statuses_userTimeline( 'screen_name=' . $instance['username']. '&count=1&exclude_replies=true' );
		}
		return $timeline;
	}

	function save_tweets( $widget_id, $instance ) {
		$timeline = $this->retrieve_tweets( $widget_id, $instance );
		$tweets = array( 'tweets' => $timeline, 'update_time' => time() + ( 60 * 5 ) );
		update_option( 'cortex_tweets_' . $widget_id, $tweets );
		return $tweets;
	}

	function get_tweets( $widget_id, $instance ) {
		$tweets = get_option( 'cortex_tweets_' . $widget_id );
		if( empty( $tweets ) OR time() > $tweets['update_time'] ) {
		$tweets = $this->save_tweets( $widget_id, $instance );
		}
		return $tweets;
	}

	/** The front-end display **/
	function widget( $args, $instance ) {

		// use a template for the output so that it can easily be overridden by theme

		if ($instance['style'] == 'basic') {

			// check for template in active theme
			$template = cortex_widget_get_template('widget-twitter-basic-template.php');

			// if none found use the default template
			if ( $template == '' ) $template = CORTEX_WIDGETS_PATH . '/widget-templates/widget-twitter-basic-template.php';
				include ( $template );

		} elseif ($instance['style'] == 'darkmedium') {

			// check for template in active theme
			$template = cortex_widget_get_template('widget-twitter-dark-template.php');

			// if none found use the default template
			if ( $template == '' ) $template = CORTEX_WIDGETS_PATH . '/widget-templates/widget-twitter-dark-template.php';
				include ( $template );

		} elseif ($instance['style'] == 'darklarge') {

			// check for template in active theme
			$template = cortex_widget_get_template('widget-twitter-dark-template.php');

			// if none found use the default template
			if ( $template == '' ) $template = CORTEX_WIDGETS_PATH . '/widget-templates/widget-twitter-dark-template.php';
				include ( $template );

		} elseif ($instance['style'] == 'lightmedium') {

			// check for template in active theme
			$template = cortex_widget_get_template('widget-twitter-light-template.php');

			// if none found use the default template
			if ( $template == '' ) $template = CORTEX_WIDGETS_PATH . '/widget-templates/widget-twitter-light-template.php';
				include ( $template );

		} elseif ($instance['style'] == 'lightlarge') {

			// check for template in active theme
			$template = cortex_widget_get_template('widget-twitter-light-template.php');

			// if none found use the default template
			if ( $template == '' ) $template = CORTEX_WIDGETS_PATH . '/widget-templates/widget-twitter-light-template.php';
				include ( $template );

		}  else {
			//none selected
		}


	}

}
?>