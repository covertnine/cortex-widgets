<?php

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

// register
add_action('widgets_init', function(){
	register_widget('Cortex_Latest_Category_Posts');
});

class Cortex_Latest_Category_Posts extends WP_Widget {

	function __construct() {
		$widget_args = array( 'description' => __( 'Show latest posts from a category', 'cortex-widgets' ) );
		parent::__construct('cortex_latest_cat_posts', __( 'Cortex Latest Posts', 'cortex-widgets' ), $widget_args);
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

		if ($cat_name == '') { // all posts
			$cortex_latest_cat_posts = new WP_Query(
				array(
					'post_type' => 'post',
					'post_status'	=> 'publish',
					'no_found_rows'       => true,
					'posts_per_page' => $items_num,
					'post__not_in' => array( $post->ID ),
					'order'                  => 'DESC',
					'orderby'                => 'date',
					'paged' => 1,
					'ignore_sticky_posts' => true
				)
			);

		} else { // category posts
			$cortex_latest_cat_posts = new WP_Query(
				array(
					'post_type' => 'post',
					'no_found_rows'       => true,
					'cat' => $cat_name,
					'posts_per_page' => $items_num,
					'post__not_in' => array( $post->ID ),
					'post_status'	=> 'publish',
					'order'                  => 'DESC',
					'orderby'                => 'date',
					'paged' => 1,
					'ignore_sticky_posts' => true
				)
			);
		}

		if ( $cortex_latest_cat_posts->have_posts() ):

			echo $before_widget;
            if ( $title ) echo $before_title . $title . $after_title;

	 		// check for template in active theme
			$template = cortextoo_widget_get_template('widget-latest-category-template.php');

			// if none found use the default template
			if ( $template == '' ) $template = 'widget-latest-category-template.php';

			include ( $template );

            echo $after_widget;
			wp_reset_postdata();
			wp_reset_query();

		endif;

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
			'title' => __('Category Name', 'cortex-widgets'),
			'items_num' => '3',
			'cat_name' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

	?>
		<h3><?php echo  __('Latest Post Settings', 'cortex-widgets'); ?></h3>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'cortex-widgets'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'items_num' ); ?>"><?php _e('Maximum number of posts to show:', 'cortex-widgets'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'items_num' ); ?>" name="<?php echo $this->get_field_name( 'items_num' ); ?>" value="<?php echo $instance['items_num']; ?>" size="1" />
		</p>
        <p>
        	<label for="<?php echo $this->get_field_id( 'cat_name' ); ?>"><?php _e('Select Category:', 'cortex-widgets'); ?></label>
        	<select id="<?php echo $this->get_field_id( 'cat_name' ); ?>" name="<?php echo $this->get_field_name( 'cat_name' ); ?>" class="widefat">
	        	<option value="" <?php if (empty($instance["cat_name"])) { echo "selected"; } ?>><?php _e('All Categories', 'cortex-widgets'); ?></option>
        	<?php
			$categories = get_categories();
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