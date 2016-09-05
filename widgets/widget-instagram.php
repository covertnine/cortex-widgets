<?php

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

// register
add_action('widgets_init', function(){
	register_widget('Cortex_Instagram_Widget');
});

class Cortex_Instagram_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget-cortex-instagram', 'description' => __('Displays your latest Instagram photos', 'cortex-widgets') );
		parent::__construct('widget-cortex-instagram', __('Cortex Instagram', 'cortex-widgets'), $widget_ops);
	}

	function widget($args, $instance) {

		extract($args, EXTR_SKIP);

		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$username = empty($instance['username']) ? '' : $instance['username'];
		$limit = empty($instance['number']) ? 9 : $instance['number'];
		$size = empty($instance['size']) ? 'thumbnail' : $instance['size'];
		$target = empty($instance['target']) ? '_self' : $instance['target'];
		$link = empty($instance['link']) ? '' : $instance['link'];

		echo $before_widget;
		if(!empty($title)) { echo $before_title . $title . $after_title; };

		do_action( 'wpiw_before_widget', $instance );

		if ($username != '') {

			$media_array = $this->scrape_instagram($username, $limit);

			if ( is_wp_error($media_array) ) {

			   echo $media_array->get_error_message();

			} else {

				// filter for images only?
				if ( $images_only = apply_filters( 'wpiw_images_only', FALSE ) )
					$media_array = array_filter( $media_array, array( $this, 'images_only' ) );

					// check for template in active theme
					$template = cortex_widget_get_template('widget-instagram-template.php');

					// if none found use the default template
					if ( $template == '' ) $template = 'widget-instagram-template.php';

					include ( $template );

			}
		}

		do_action( 'wpiw_after_widget', $instance );

		echo $after_widget;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('Instagram', 'cortex-widgets'), 'username' => '', 'link' => __('Follow Us', 'cortex-widgets'), 'number' => 9, 'size' => 'thumbnail', 'target' => '_self') );
		$title = esc_attr($instance['title']);
		$username = esc_attr($instance['username']);
		$number = absint($instance['number']);
		$size = esc_attr($instance['size']);
		$target = esc_attr($instance['target']);
		$link = esc_attr($instance['link']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'cortex-widgets'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username', 'cortex-widgets'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of photos: <small>(Max 12)</small>', 'cortex-widgets'); ?> <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Photo size', 'cortex-widgets'); ?>:</label>
			<select id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" class="widefat">
				<option value="thumbnail" <?php selected('thumbnail', $size) ?>><?php _e('Thumbnail', 'cortex-widgets'); ?></option>
				<option value="large" <?php selected('large', $size) ?>><?php _e('Large', 'cortex-widgets'); ?></option>
			</select>
		</p>
		<p><label for="<?php echo $this->get_field_id('target'); ?>"><?php _e('Open links in', 'cortex-widgets'); ?>:</label>
			<select id="<?php echo $this->get_field_id('target'); ?>" name="<?php echo $this->get_field_name('target'); ?>" class="widefat">
				<option value="_self" <?php selected('_self', $target) ?>><?php _e('Current window (_self)', 'cortex-widgets'); ?></option>
				<option value="_blank" <?php selected('_blank', $target) ?>><?php _e('New window (_blank)', 'cortex-widgets'); ?></option>
			</select>
		</p>
		<p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link text', 'cortex-widgets'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" /></label></p>
		<?php

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = trim(strip_tags($new_instance['username']));
		$instance['number'] = !absint($new_instance['number']) ? 9 : $new_instance['number'];
		$instance['size'] = (($new_instance['size'] == 'thumbnail' || $new_instance['size'] == 'large') ? $new_instance['size'] : 'thumbnail');
		$instance['target'] = (($new_instance['target'] == '_self' || $new_instance['target'] == '_blank') ? $new_instance['target'] : '_self');
		$instance['link'] = strip_tags($new_instance['link']);
		return $instance;
	}

	function scrape_instagram( $username, $slice = 9 ) {
		$username = strtolower( $username );
		$username = str_replace( '@', '', $username );
		if ( false === ( $instagram = get_transient( 'instagram-media-5-'.sanitize_title_with_dashes( $username ) ) ) ) {
			$remote = wp_remote_get( 'http://instagram.com/'.trim( $username ) );
			if ( is_wp_error( $remote ) )
				return new WP_Error( 'site_down', __( 'Unable to communicate with Instagram.', 'wp-instagram-widget' ) );
			if ( 200 != wp_remote_retrieve_response_code( $remote ) )
				return new WP_Error( 'invalid_response', __( 'Instagram did not return a 200.', 'wp-instagram-widget' ) );
			$shards = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json = explode( ';</script>', $shards[1] );
			$insta_array = json_decode( $insta_json[0], TRUE );
			if ( ! $insta_array )
				return new WP_Error( 'bad_json', __( 'Instagram has returned invalid data.', 'wp-instagram-widget' ) );
			if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
			} else {
				return new WP_Error( 'bad_json_2', __( 'Instagram has returned invalid data.', 'wp-instagram-widget' ) );
			}
			if ( ! is_array( $images ) )
				return new WP_Error( 'bad_array', __( 'Instagram has returned invalid data.', 'wp-instagram-widget' ) );
			$instagram = array();
			foreach ( $images as $image ) {
				$image['thumbnail_src'] = preg_replace( "/^https:/i", "", $image['thumbnail_src'] );
				$image['thumbnail'] = str_replace( 's640x640', 's160x160', $image['thumbnail_src'] );
				$image['small'] = str_replace( 's640x640', 's320x320', $image['thumbnail_src'] );
				$image['display_src'] = preg_replace( "/^https:/i", "", $image['display_src'] );
				$image['large'] = $image['display_src'];
				if ( $image['is_video'] == true ) {
					$type = 'video';
				} else {
					$type = 'image';
				}
				$caption = __( 'Instagram Image', 'wp-instagram-widget' );
				if ( ! empty( $image['caption'] ) ) {
					$caption = $image['caption'];
				}
				$instagram[] = array(
					'description'   => $caption,
					'link'		  	=> '//instagram.com/p/' . $image['code'],
					'time'		  	=> $image['date'],
					'comments'	  	=> $image['comments']['count'],
					'likes'		 	=> $image['likes']['count'],
					'thumbnail'	 	=> $image['thumbnail'],
					'small'			=> $image['small'],
					'large'			=> $image['large'],
					'original'		=> $image['display_src'],
					'type'		  	=> $type
				);
			}
			// do not set an empty transient - should help catch private or empty accounts
			if ( ! empty( $instagram ) ) {
				$instagram = base64_encode( serialize( $instagram ) );
				set_transient( 'instagram-media-5-'.sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS*2 ) );
			}
		}
		if ( ! empty( $instagram ) ) {
			$instagram = unserialize( base64_decode( $instagram ) );
			return array_slice( $instagram, 0, $slice );
		} else {
			return new WP_Error( 'no_images', __( 'Instagram did not return any images.', 'wp-instagram-widget' ) );
		}
	}
	function images_only( $media_item ) {
		if ( $media_item['type'] == 'image' )
			return true;
		return false;
	}
} //end class Cortex_Instagram_Widget
?>