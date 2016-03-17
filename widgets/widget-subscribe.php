<?php

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

//register
add_action( 'widgets_init', function(){
	register_widget( 'Cortex_Subscribe_Widget' );
});


/**
 * Adds Cortex_About_Widget widget.
 */
class Cortex_Subscribe_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Cortex_Subscribe_Widget', // Base ID
			__('Cortex Subscribe', 'cortex-widgets'), // Name
			array('description' => __( 'Creates a simple widget with social subscribe/follow buttons.', 'cortex-widgets' ),) // Args
		);

		add_action( 'sidebar_admin_setup', array( $this, 'admin_setup' ) );

	}

	function admin_setup(){

		wp_enqueue_style('widget-subscribe-css', CORTEX_WIDGETS_CSS_URL . '/widget_subscribe_admin.css');

	}


	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		// use a template for the output so that it can easily be overridden by theme

		// check for template in active theme
		$template = cortex_widget_get_template('widget-subscribe-template.php');

		// if none found use the default template
		if ( $template == '' ) $template = 'widget-subscribe-template.php';

		include ( $template );

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$title_text			 = ( isset( $instance['title_text'] ) ) ? $instance['title_text'] : '';
		$icon_type			 = ( isset( $instance['icon_type'] ) ) ? $instance['icon_type'] : '';
		$icon_facebook		 = ( isset( $instance['icon_facebook'] ) ) ? $instance['icon_facebook'] : '';
		$icon_twitter	     = ( isset( $instance['icon_twitter'] ) ) ? $instance['icon_twitter'] : '';
		$icon_instagram		 = ( isset( $instance['icon_instagram'] ) ) ? $instance['icon_instagram'] : '';
		$icon_flickr		 = ( isset( $instance['icon_flickr'] ) ) ? $instance['icon_flickr'] : '';
		$icon_googleplus	 = ( isset( $instance['icon_googleplus'] ) ) ? $instance['icon_googleplus'] : '';
		$icon_email			 = ( isset( $instance['icon_email'] ) ) ? $instance['icon_email'] : '';
		$icon_youtube		 = ( isset( $instance['icon_youtube'] ) ) ? $instance['icon_youtube'] : '';
		$icon_tumblr		 = ( isset( $instance['icon_tumblr'] ) ) ? $instance['icon_tumblr'] : '';
		$icon_yelp			 = ( isset( $instance['icon_yelp'] ) ) ? $instance['icon_yelp'] : '';
		$icon_lastfm		 = ( isset( $instance['icon_lastfm'] ) ) ? $instance['icon_lastfm'] : '';
		$icon_pinterest		 = ( isset( $instance['icon_pinterest'] ) ) ? $instance['icon_pinterest'] : '';
		$icon_reddit		 = ( isset( $instance['icon_reddit'] ) ) ? $instance['icon_reddit'] : '';
		$icon_linkedin		 = ( isset( $instance['icon_linkedin'] ) ) ? $instance['icon_linkedin'] : '';
		$icon_map			 = ( isset( $instance['icon_map'] ) ) ? $instance['icon_map'] : '';
		$icon_github		 = ( isset( $instance['icon_github'] ) ) ? $instance['icon_github'] : '';
		$icon_soundcloud	 = ( isset( $instance['icon_soundcloud'] ) ) ? $instance['icon_soundcloud'] : '';
		$icon_deviantart	 = ( isset( $instance['icon_deviantart'] ) ) ? $instance['icon_deviantart'] : '';
	?>

		<div class="cortex_subscribe_widget">

			<h3><?php __('Subscribe &amp; Follow', 'cortex-widgets'); ?></h3>
			<p>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'title_text' ); ?>"><?php _e( 'Title:', 'cortex-widgets' ); ?></label>
					<input class="title_text widefat" id="<?php echo $this->get_field_id( 'title_text' ); ?>" name="<?php echo $this->get_field_name( 'title_text' ); ?>" value="<?php echo $title_text ?>" type="text"><br/>
				</div>
				<div class="widet_input">
					<label for="<?php echo $this->get_field_id( 'icon_type' ); ?>"><?php _e( 'Button Type:', 'cortex-widgets' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id( 'icon_type' ); ?>" name="<?php echo $this->get_field_name( 'icon_type' ); ?>">
						<option value=""<?php if ($icon_type == '') { echo " selected"; } ?>><?php _e('SELECT', 'cortex-widgets'); ?></option>
						<option value="square"<?php if ($icon_type == 'square') { echo " selected"; } ?>><?php _e('Square', 'cortex-widgets'); ?></option>
						<option value="normal"<?php if ($icon_type == 'normal') { echo " selected"; } ?>><?php _e('Normal', 'cortex-widgets'); ?></option>
					</select>
				</div>
			</p>
			<p>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_facebook' ); ?>"><?php _e( 'Facebook Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_facebook widefat" id="<?php echo $this->get_field_id( 'icon_facebook' ); ?>" name="<?php echo $this->get_field_name( 'icon_facebook' ); ?>" value="<?php echo $icon_facebook ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_twitter' ); ?>"><?php _e( 'Twitter Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_twitter widefat" id="<?php echo $this->get_field_id( 'icon_twitter' ); ?>" name="<?php echo $this->get_field_name( 'icon_twitter' ); ?>" value="<?php echo $icon_twitter ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_instagram' ); ?>"><?php _e( 'Instagram Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_instagram widefat" id="<?php echo $this->get_field_id( 'icon_instagram' ); ?>" name="<?php echo $this->get_field_name( 'icon_instagram' ); ?>" value="<?php echo $icon_instagram ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_googleplus' ); ?>"><?php _e( 'Google Plus Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_googleplus widefat" id="<?php echo $this->get_field_id( 'icon_googleplus' ); ?>" name="<?php echo $this->get_field_name( 'icon_googleplus' ); ?>" value="<?php echo $icon_googleplus ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_flickr' ); ?>"><?php _e( 'Flickr Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_flickr widefat" id="<?php echo $this->get_field_id( 'icon_flickr' ); ?>" name="<?php echo $this->get_field_name( 'icon_flickr' ); ?>" value="<?php echo $icon_flickr ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_email' ); ?>"><?php _e( 'MailChimp Subscribe Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_email widefat" id="<?php echo $this->get_field_id( 'icon_email' ); ?>" name="<?php echo $this->get_field_name( 'icon_email' ); ?>" value="<?php echo $icon_email ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_youtube' ); ?>"><?php _e( 'YouTube Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_youtube widefat" id="<?php echo $this->get_field_id( 'icon_youtube' ); ?>" name="<?php echo $this->get_field_name( 'icon_youtube' ); ?>" value="<?php echo $icon_youtube ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_tumblr' ); ?>"><?php _e( 'Tumblr Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_tumblr widefat" id="<?php echo $this->get_field_id( 'icon_tumblr' ); ?>" name="<?php echo $this->get_field_name( 'icon_tumblr' ); ?>" value="<?php echo $icon_tumblr ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_yelp' ); ?>"><?php _e( 'Yelp Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_yelp widefat" id="<?php echo $this->get_field_id( 'icon_yelp' ); ?>" name="<?php echo $this->get_field_name( 'icon_yelp' ); ?>" value="<?php echo $icon_yelp ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_lastfm' ); ?>"><?php _e( 'Last.fm Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_lastfm widefat" id="<?php echo $this->get_field_id( 'icon_lastfm' ); ?>" name="<?php echo $this->get_field_name( 'icon_lastfm' ); ?>" value="<?php echo $icon_lastfm ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_pinterest' ); ?>"><?php _e( 'Pinterest Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_pinterest widefat" id="<?php echo $this->get_field_id( 'icon_pinterest' ); ?>" name="<?php echo $this->get_field_name( 'icon_pinterest' ); ?>" value="<?php echo $icon_pinterest ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_reddit' ); ?>"><?php _e( 'Reddit Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_reddit widefat" id="<?php echo $this->get_field_id( 'icon_reddit' ); ?>" name="<?php echo $this->get_field_name( 'icon_reddit' ); ?>" value="<?php echo $icon_reddit ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_linkedin' ); ?>"><?php _e( 'LinkedIn Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_linkedin widefat" id="<?php echo $this->get_field_id( 'icon_linkedin' ); ?>" name="<?php echo $this->get_field_name( 'icon_linkedin' ); ?>" value="<?php echo $icon_linkedin ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_map' ); ?>"><?php _e( 'Google Maps Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_map widefat" id="<?php echo $this->get_field_id( 'icon_map' ); ?>" name="<?php echo $this->get_field_name( 'icon_map' ); ?>" value="<?php echo $icon_map ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_github' ); ?>"><?php _e( 'GitHub Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_github widefat" id="<?php echo $this->get_field_id( 'icon_github' ); ?>" name="<?php echo $this->get_field_name( 'icon_github' ); ?>" value="<?php echo $icon_github ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_soundcloud' ); ?>"><?php _e( 'SoundCloud Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_soundcloud widefat" id="<?php echo $this->get_field_id( 'icon_soundcloud' ); ?>" name="<?php echo $this->get_field_name( 'icon_soundcloud' ); ?>" value="<?php echo $icon_soundcloud ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'icon_deviantart' ); ?>"><?php _e( 'DeviantArt Link:', 'cortex-widgets' ); ?></label>
					<input class="icon_deviantart widefat" id="<?php echo $this->get_field_id( 'icon_deviantart' ); ?>" name="<?php echo $this->get_field_name( 'icon_deviantart' ); ?>" value="<?php echo $icon_deviantart ?>" type="text"><br/>
				</div>
			</p>
		</div>

		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance 						 = array();
		$instance['title_text']			 = ( ! empty( $new_instance['title_text'] ) ) ? strip_tags( $new_instance['title_text'] ) : '';
		$instance['icon_type']			 = ( ! empty( $new_instance['icon_type'] ) ) ? strip_tags( $new_instance['icon_type'] ) : '';
		$instance['icon_facebook']		 = ( ! empty( $new_instance['icon_facebook'] ) ) ? strip_tags( $new_instance['icon_facebook'] ) : '';
		$instance['icon_twitter']	     = ( ! empty( $new_instance['icon_twitter'] ) ) ? strip_tags( $new_instance['icon_twitter'] ) : '';
		$instance['icon_instagram']		 = ( ! empty( $new_instance['icon_instagram'] ) ) ? strip_tags( $new_instance['icon_instagram'] ) : '';
		$instance['icon_flickr']		 = ( ! empty( $new_instance['icon_flickr'] ) ) ? strip_tags( $new_instance['icon_flickr'] ) : '';
		$instance['icon_googleplus']	 = ( ! empty( $new_instance['icon_googleplus'] ) ) ? strip_tags( $new_instance['icon_googleplus'] ) : '';
		$instance['icon_email']			 = ( ! empty( $new_instance['icon_email'] ) ) ? strip_tags( $new_instance['icon_email'] ) : '';
		$instance['icon_youtube']		 = ( ! empty( $new_instance['icon_youtube'] ) ) ? strip_tags( $new_instance['icon_youtube'] ) : '';
		$instance['icon_tumblr']		 = ( ! empty( $new_instance['icon_tumblr'] ) ) ? strip_tags( $new_instance['icon_tumblr'] ) : '';
		$instance['icon_yelp']			 = ( ! empty( $new_instance['icon_yelp'] ) ) ? strip_tags( $new_instance['icon_yelp'] ) : '';
		$instance['icon_lastfm']		 = ( ! empty( $new_instance['icon_lastfm'] ) ) ? strip_tags( $new_instance['icon_lastfm'] ) : '';
		$instance['icon_pinterest']		 = ( ! empty( $new_instance['icon_pinterest'] ) ) ? strip_tags( $new_instance['icon_pinterest'] ) : '';
		$instance['icon_reddit']		 = ( ! empty( $new_instance['icon_reddit'] ) ) ? strip_tags( $new_instance['icon_reddit'] ) : '';
		$instance['icon_linkedin']		 = ( ! empty( $new_instance['icon_linkedin'] ) ) ? strip_tags( $new_instance['icon_linkedin'] ) : '';
		$instance['icon_map']			 = ( ! empty( $new_instance['icon_map'] ) ) ? strip_tags( $new_instance['icon_map'] ) : '';
		$instance['icon_github']		 = ( ! empty( $new_instance['icon_github'] ) ) ? strip_tags( $new_instance['icon_github'] ) : '';
		$instance['icon_soundcloud']	 = ( ! empty( $new_instance['icon_soundcloud'] ) ) ? strip_tags( $new_instance['icon_soundcloud'] ) : '';
		$instance['icon_deviantart']	 = ( ! empty( $new_instance['icon_deviantart'] ) ) ? strip_tags( $new_instance['icon_deviantart'] ) : '';
		return $instance;
	}

} // class Cortex_Subscribe_Widget