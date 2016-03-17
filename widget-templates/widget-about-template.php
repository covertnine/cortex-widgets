<?php
/*
 * Template for the output of the Cortex About Widget
 * Override by placing a file called widget-about-template.php in your active theme in a directory called widget-templates
 */

/* Output
	title text
	title image
	title description
*/

	echo '<!-- Cortex about widget -->
	<aside id="widget-cortex-about" class="widget widget-cortex-about">
	<header>';

	echo '<h3 class="widget-title">';
	if ( isset( $instance['title_text'] ) ) {
		echo $instance['title_text'];
	}
	echo '</h3>';

	echo '</header>';

	if ( isset( $instance['title_image'] ) ) {
		echo '<div class="widget-about-img mar15B"><img src="' . $instance['title_image'] . '" class="img-responsive" alt="' . $instance['title_text'] . '"></div>';
	}
	if ( isset( $instance['title_description'] ) ) {
		echo '<div class="widget-about-text"><p class="body-color-text">' . nl2br($instance['title_description']) . '</p></div>';
	}
	echo '</aside>';
?>