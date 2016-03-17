<?php

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

add_action( 'widgets_init', function(){
	register_widget( 'Cortex_Contact_Widget' );
});


/**
 * Adds Cortex_About_Widget widget.
 */
class Cortex_Contact_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Cortex_Contact_Widget', // Base ID
			__('Cortex Get In Touch', 'cortex-widgets'), // Name
			array('description' => __( 'Creates a simple widget with contact information.', 'cortex-widgets' ),) // Args
		);

		add_action( 'sidebar_admin_setup', array( $this, 'admin_setup' ) );

	}

	function admin_setup(){

		wp_enqueue_style('widget-contact-css', CORTEX_WIDGETS_CSS_URL . '/widget_contact_admin.css');

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
		$template = cortex_widget_get_template('widget-contact-template.php');

		// if none found use the default template
		if ( $template == '' ) $template = 'widget-contact-template.php';

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

		extract($instance);

	?>

		<div class="cortex_contact_widget">

			<h3><?php _e('Cortex Contact Widget', 'cortex-widgets'); ?></h3>
			<p>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'title_text' ); ?>"><?php _e( 'Title:', 'cortex-widgets' ); ?></label>
					<input class="title_text widefat" id="<?php echo $this->get_field_id( 'title_text' ); ?>" name="<?php echo $this->get_field_name( 'title_text' ); ?>" value="<?php if (!empty($title_text)) { echo $title_text; } ?>" type="text"><br/>
				</div>
			</p>
			<p>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'street' ); ?>"><?php _e( 'Street:', 'street' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'street' ); ?>" name="<?php echo $this->get_field_name( 'street' ); ?>" value="<?php if (!empty($street)) { echo $street; } ?>" type="text"><br/>
				</div>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'city' ); ?>"><?php _e( 'City:', 'cortex-widgets' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'city' ); ?>" name="<?php echo $this->get_field_name( 'city' ); ?>" value="<?php if (!empty($city)) { echo $city; } ?>" type="text"><br/>
				</div>
			</p>
			<p>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'state' ); ?>"><?php _e( 'State:', 'cortex-widgets' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'state' ); ?>" name="<?php echo $this->get_field_name( 'state' ); ?>" value="<?php if (!empty($state)) { echo $state; } ?>" type="text"><br/>
				</div>
			</p>
			<p>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'postal_code' ); ?>"><?php _e( 'Postal Code:', 'cortex-widgets' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'postal_code' ); ?>" name="<?php echo $this->get_field_name( 'postal_code' ); ?>" value="<?php if (!empty($postal_code)) { echo $postal_code; } ?>" type="text"><br/>
				</div>
			</p>
			<p>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'country' ); ?>"><?php _e( 'Country:', 'cortex-widgets' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'country' ); ?>" name="<?php echo $this->get_field_name( 'country' ); ?>" value="<?php if (!empty($country)) { echo $country; } ?>" type="text"><br/>
				</div>
			</p>
			<p>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'contact_phone' ); ?>"><?php _e( 'Phone Number: ', 'cortex-widgets' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'contact_phone' ); ?>" name="<?php echo $this->get_field_name( 'contact_phone' ); ?>" value="<?php if (!empty($contact_phone)) { echo $contact_phone; } ?>" type="text"><br/>
				</div>
			</p>
			<p>
				<div class="widget_input">
					<label for="<?php echo $this->get_field_id( 'contact_email' ); ?>"><?php _e( 'Contact Email:', 'cortex-widgets' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'contact_email' ); ?>" name="<?php echo $this->get_field_name( 'contact_email' ); ?>" value="<?php if (!empty($contact_email)) { echo $contact_email; } ?>" type="text"><br/>
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
		$instance['street']				 = ( ! empty( $new_instance['street'] ) ) ? strip_tags( $new_instance['street'] ) : '';
		$instance['city']				 = ( ! empty( $new_instance['city'] ) ) ? strip_tags( $new_instance['city'] ) : '';
		$instance['state']	    		 = ( ! empty( $new_instance['state'] ) ) ? strip_tags( $new_instance['state'] ) : '';
		$instance['postal_code']		 = ( ! empty( $new_instance['postal_code'] ) ) ? strip_tags( $new_instance['postal_code'] ) : '';
		$instance['country']			 = ( ! empty( $new_instance['country'] ) ) ? strip_tags( $new_instance['country'] ) : '';
		$instance['contact_phone']		 = ( ! empty( $new_instance['contact_phone'] ) ) ? strip_tags( $new_instance['contact_phone'] ) : '';
		$instance['contact_email']		 = ( ! empty( $new_instance['contact_email'] ) ) ? strip_tags( $new_instance['contact_email'] ) : '';

		return $instance;
	}

} // class Cortex_Contact_Widget