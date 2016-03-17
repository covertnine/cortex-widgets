<?php

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

add_action( 'widgets_init', function(){
	register_widget( 'Cortex_About_Widget' );
});


/**
 * Adds Cortex_About_Widget widget.
 */
class Cortex_About_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Cortex_About_Widget', // Base ID
			__('Cortex About', 'cortex-widgets'), // Name
			array('description' => __( 'Creates a simple about widget with an image.', 'cortex-widgets' ),) // Args
		);

		add_action( 'sidebar_admin_setup', array( $this, 'admin_setup' ) );

	}

	function admin_setup(){

		wp_enqueue_media();
		wp_register_script('widget-about-js', CORTEX_WIDGETS_JS_URL . '/widget_about_admin.js', array( 'jquery', 'media-upload', 'media-views' ) );
		wp_enqueue_script('widget-about-js');
		wp_enqueue_style('widget-about-css', CORTEX_WIDGETS_CSS_URL . '/widget_about_admin.css');

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
		$template = cortex_widget_get_template('widget-about-template.php');

		// if none found use the default template
		if ( $template == '' ) $template = CORTEX_WIDGETS_PATH . '/widget-templates/widget-about-template.php';

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


		$title_text		   = ( isset( $instance['title_text'] ) ) ? $instance['title_text'] : '';
		$title_image	   = ( isset( $instance['title_image'] ) ) ? $instance['title_image'] : '';
		$title_description = ( isset( $instance['title_description'] ) ) ? $instance['title_description'] : '';

	?>

		<div class="cortex_about_widget">

			<h3><?php __('About', 'cortex-widgets'); ?></h3>
			<p>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'title_text' ); ?>"><?php _e( 'Title:', 'cortex-widgets' ); ?></label>
					<input class="title_text widefat" id="<?php echo $this->get_field_id( 'title_text' ); ?>" name="<?php echo $this->get_field_name( 'title_text' ); ?>" value="<?php echo $title_text ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'title_image' ); ?>"><?php _e( 'Image:', 'cortex-widgets' ); ?></label>
					<input class="title_image widefat" id="<?php echo $this->get_field_id( 'title_image' ); ?>" name="<?php echo $this->get_field_name( 'title_image' ); ?>" value="<?php echo $title_image ?>" type="text"><button id="title_image_button" class="button" onclick="image_button_click('Choose About Image','Select Image','image','title_image_preview','<?php echo $this->get_field_id( 'title_image' );  ?>');"><?php _e('Select Image', 'cortex-widgets'); ?></button>
				</div>
				<div id="title_image_preview" class="preview_placholder">
				<?php
					if ($title_image!='') echo '<img src="' . $title_image . '">';
				?>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'title_description' ); ?>"><?php _e( 'About Description:', 'cortex-widgets'); ?></label>
					<textarea class="title_description widefat" id="<?php echo $this->get_field_id( 'title_description' ); ?>" rows="8" cols="20" name="<?php echo $this->get_field_name( 'title_description' ); ?>"><?php echo $title_description ?></textarea>
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
		$title_description_clean = wp_kses_post( $new_instance['title_description'] );
		$instance = array();
		$instance['title_text']		   = ( ! empty( $new_instance['title_text'] ) ) ? strip_tags( $new_instance['title_text'] ) : '';
		$instance['title_image']	   = ( ! empty( $new_instance['title_image'] ) ) ? strip_tags( $new_instance['title_image'] ) : '';
		$instance['title_description'] = ( ! empty( $new_instance['title_description'] ) ) ? $title_description_clean : '';
		return $instance;
	}

} // class Cortex_About_Widget