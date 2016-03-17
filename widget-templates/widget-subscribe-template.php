<?php
/*
 * Template for the output of the Cortex Subscribe Widget
 * Override by placing a file called widget-subscribe-template.php in your active theme in a directory called widgets
 */

/* Output
	link
*/
$icon_type = $instance['icon_type'];

echo $args['before_widget'];
echo $args['before_title'] . $instance['title_text'] .  $args['after_title'];

echo '
	<ul>';
if ( !empty( $instance['icon_facebook'] ) ) {
	echo '<li><a href="' . $instance['icon_facebook'] . '" target="_blank" title="Facebook" class="cortex-susbcribe icon-facebook-' . $icon_type .'"><span class="hide">Facebook</span></a></li>';
}
if ( !empty( $instance['icon_twitter'] ) ) {
	echo '<li><a href="' . $instance['icon_twitter'] . '" target="_blank" title="Twitter" class="cortex-susbcribe icon-twitter-' . $icon_type .'"><span class="hide">Twitter</span></a></li>';
}
if ( !empty( $instance['icon_instagram'] ) ) {
	echo '<li><a href="' . $instance['icon_instagram'] . '" target="_blank" title="Instagram" class="cortex-susbcribe icon-instagram-' . $icon_type .'"><span class="hide">Instagram</span></a></li>';
}
if ( !empty( $instance['icon_flickr'] ) ) {
	echo '<li><a href="' . $instance['icon_flickr'] . '" target="_blank" title="Flickr" class="cortex-susbcribe icon-flickr-' . $icon_type .'"><span class="hide">Flickr</span></a></li>';
}
if ( !empty( $instance['icon_googleplus'] ) ) {
	echo '<li><a href="' . $instance['icon_googleplus'] . '" target="_blank" title="Google+" class="cortex-susbcribe icon-googleplus-' . $icon_type .'"><span class="hide">Google+</span></a></li>';
}
if ( !empty( $instance['icon_email'] ) ) {
	echo '<li><a href="' . $instance['icon_email'] . '" target="_blank" title="Email" class="cortex-susbcribe icon-email-' . $icon_type .'"><span class="hide">Email Newsletter</span></a></li>';
}
if ( !empty( $instance['icon_youtube'] ) ) {
	echo '<li><a href="' . $instance['icon_youtube'] . '" target="_blank" title="YouTube" class="cortex-susbcribe icon-youtube-' . $icon_type .'"><span class="hide">Youtube</span></a></li>';
}
if ( !empty( $instance['icon_tumblr'] ) ) {
	echo '<li><a href="' . $instance['icon_tumblr'] . '" target="_blank" title="Tumblr" class="cortex-susbcribe icon-tumblr-' . $icon_type .'"><span class="hide">Tumblr</span></a></li>';
}
if ( !empty( $instance['icon_yelp'] ) ) {
	echo '<li><a href="' . $instance['icon_yelp'] . '" target="_blank" title="Yelp" class="cortex-susbcribe icon-yelp-' . $icon_type .'"><span class="hide">Yelp</span></a></li>';
}
if ( !empty( $instance['icon_lastfm'] ) ) {
	echo '<li><a href="' . $instance['icon_lastfm'] . '" target="_blank" title="Last.fm" class="cortex-susbcribe icon-lastfm-' . $icon_type .'"><span class="hide">Last.fm</span></a></li>';
}
if ( !empty( $instance['icon_pinterest'] ) ) {
	echo '<li><a href="' . $instance['icon_pinterest'] . '" target="_blank" title="Pinterest" class="cortex-susbcribe icon-pinterest-' . $icon_type .'"><span class="hide">Pinterest</span></a></li>';
}
if ( !empty( $instance['icon_reddit'] ) ) {
	echo '<li><a href="' . $instance['icon_reddit'] . '" target="_blank" title="Reddit" class="cortex-susbcribe icon-reddit-' . $icon_type .'"><span class="hide">Reddit</span></a></li>';
}
if ( !empty( $instance['icon_linkedin'] ) ) {
	echo '<li><a href="' . $instance['icon_linkedin'] . '" target="_blank" title="Linkedin" class="cortex-susbcribe icon-linkedin-' . $icon_type .'"><span class="hide">LinkedIn</span></a></li>';
}
if ( !empty( $instance['icon_map'] ) ) {
	echo '<li><a href="' . $instance['icon_map'] . '" target="_blank" title="Google Maps" class="cortex-susbcribe icon-map-' . $icon_type .'"><span class="hide">Google Map</span></a></li>';
}
if ( !empty( $instance['icon_github'] ) ) {
	echo '<li><a href="' . $instance['icon_github'] . '" target="_blank" title="Git Hub" class="cortex-susbcribe icon-github-' . $icon_type .'"><span class="hide">Git Hub</span></a></li>';
}
if ( !empty( $instance['icon_soundcloud'] ) ) {
	echo '<li><a href="' . $instance['icon_soundcloud'] . '" target="_blank" title="SoundCloud" class="cortex-susbcribe icon-soundcloud-' . $icon_type .'"><span class="hide">Sound Cloud</span></a></li>';
}
if ( !empty( $instance['icon_deviantart'] ) ) {
	echo '<li><a href="' . $instance['icon_deviantart'] . '" target="_blank" title="Deviant Art" class="cortex-susbcribe icon-deviantart-' . $icon_type .'"><span class="hide">Deviant Art</span></a></li>';
}
echo '</ul>
	</aside>';
?>