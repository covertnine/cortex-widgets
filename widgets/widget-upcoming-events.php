<?php

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

// register
add_action('widgets_init', function(){
	register_widget('Cortex_Upcoming_Events');
});


class Cortex_Upcoming_Events extends WP_Widget {

	function __construct() {
		$widget_ue_args = array( 'description' => __( 'Show upcoming events', 'cortex-widgets' ) );
		parent::__construct( 'cortex_upcoming_events', __( 'Cortex Upcoming Events', 'cortex-widgets' ), $widget_ue_args );

	}

	/**
	 * Front-end display of widget
	**/
	function widget( $args, $instance ) {

		extract( $args );

		$title = apply_filters('widget_title', isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'Category Name' );
		$items_num = isset( $instance['items_num'] ) ? esc_attr( $instance['items_num'] ) : '3';
		$cat_name = isset( $instance['cat_name'] ) ? esc_attr( $instance['cat_name'] ) : '';

		/**
		 * Latest Posts
		**/
		global $post;
		$time = current_time( 'timestamp' );

		if ($cat_name == '') { // all posts
			$cortex_upcoming_events = new WP_Query(
				array(
					'post_type'              => 'event',
					'post_status'            => 'publish', // only show published events
					'orderby'                => 'meta_value', // order by date
					'meta_key'               => 'date_and_time', // your ACF Date & Time Picker field
					'meta_value'             => $time, // Use the current time from above
					'meta_compare'           => '>=', // Compare today's datetime with our event datetime
					'order'                  => 'ASC', // Show earlier events first
					'posts_per_page' => $items_num,
					'post__not_in' => array( $post->ID ),
					'ignore_sticky_posts' => 1
				)
			);

		} else { // category posts
			$cortex_upcoming_events = new WP_Query(
				array(
					'post_type'              => 'event',
					'post_status'            => 'publish', // only show published events
					'orderby'                => 'meta_value', // order by date
					'meta_key'               => 'date_and_time', // your ACF Date & Time Picker field
					'meta_value'             => $time, // Use the current time from above
					'meta_compare'           => '>=', // Compare today's datetime with our event datetime
					'order'                  => 'ASC', // Show earlier events first
					'tax_query' => array(
						array(
							'taxonomy' => 'events-category',
							'terms'		=> $cat_name
						),
					),
					'posts_per_page' => $items_num,
					'post__not_in' => array( $post->ID ),
					'ignore_sticky_posts' => 1
				)
			);
		}

		echo $before_widget;
        if ( !empty($title) ) echo $before_title . $title . $after_title;

		if ( $cortex_upcoming_events->have_posts() ) { //there are events, load the template


	 		// check for template in active theme
			$template = cortex_widget_get_template( 'widget-upcoming-events-template.php' );

			// if none found use the default template
			if ( $template == '' ) $template = 'widget-upcoming-events-template.php';

			include ( $template );


		} else { //no events, tell tlhe user
			_e('There are no upcoming events at this time', 'cortex-widgets');
		}

        echo $after_widget;
		wp_reset_postdata();

	}


	/**
	 * Sanitize widget form values as they are saved
	**/
	function update( $new_instance, $old_instance ) {

		$instance = array();

		/* Strip tags to remove HTML. For text inputs and textarea. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['items_num'] = strip_tags( $new_instance['items_num'] );
		$instance['cat_name'] = strip_tags( $new_instance['cat_name'] );

		return $instance;

	}


	/**
	 * Back-end widget form
	**/
	function form( $instance ) {

		/* Default widget settings. */
		$defaults = array(
			'title' => __('Events Heading', 'cortex-widgets'),
			'items_num' => '3',
			'cat_name' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

	?>
		<h3><?php echo  __('Upcoming Events Settings', 'cortex-widgets'); ?></h3>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'cortex-widgets'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'items_num' ); ?>"><?php _e('Maximum number of events to show:', 'cortex-widgets'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'items_num' ); ?>" name="<?php echo $this->get_field_name( 'items_num' ); ?>" value="<?php echo $instance['items_num']; ?>" size="1" />
		</p>
        <p>
        	<label for="<?php echo $this->get_field_id( 'cat_name' ); ?>"><?php _e('Select Event Category:', 'cortex-widgets'); ?></label>
        	<select id="<?php echo $this->get_field_id( 'cat_name' ); ?>" name="<?php echo $this->get_field_name( 'cat_name' ); ?>" class="widefat">
	        	<option value="" <?php if (empty($instance["cat_name"])) { echo "selected"; } ?>><?php _e('All Categories', 'cortex-widgets'); ?></option>
        	<?php
			$categories = get_categories(
				array(
					'taxonomy'	=> 'events-category',
					'hide_empty' => 1
				)
			);
			  foreach( $categories as $category ) {
			?>
				<option value="<?php echo $output_categories[] = $category->cat_ID; ?>" <?php if ( $instance["cat_name"] == $category->cat_ID ) echo 'selected="selected"'; ?>>
					<?php echo $output_categories[$category->cat_ID] = $category->name; ?>
                </option>
			<?php } ?>
            </select>
        </p>
	<?php
	}

}
