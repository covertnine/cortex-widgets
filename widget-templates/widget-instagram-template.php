<?php
/*
 * Template for the output of the Cortex About Widget
 * Override by placing a file called widget-about-template.php in your active theme in a directory called widgets
 */

/* Output
	images array
*/
?>
<ul class="instagram-pics <?php if ($size == 'large') { echo 'large'; } else { echo 'thumbs';} ?>">
<?php
foreach ($media_array as $item) {
	echo '<li><a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"><img src="'. esc_url($item['thumbnail']) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"/></a></li>';
}
?>
</ul>
<?php
		if ($link != '') {
			?><p class="clear"><a href="//instagram.com/<?php echo trim($username); ?>" rel="me" target="<?php echo esc_attr( $target ); ?>" class="action-link headline-color-text"><?php echo $link; ?></a></p><?php
		}
?>