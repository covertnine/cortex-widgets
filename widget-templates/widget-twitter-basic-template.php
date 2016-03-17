<?php
/*
 * Template for the output of the Cortex Twitter Widget
 * Override by placing a file called widget-twitter-template.php in your active theme in a directory called widgets
 */

/* Output
	title text
	tweets
*/

$tweets = $this->get_tweets( $args['widget_id'], $instance );


if( !empty( $tweets['tweets'] ) and empty( $tweets['tweets']->errors ) ) {

	echo $args['before_widget'];
	echo $args['before_title'] . $instance['title'] .  $args['after_title'];

	$user = current( $tweets['tweets'] );
	$user = $user->user;
?>
	<div class="basic">
<?php
	if (!empty($instance['avatar_icon'])) { //check to see if avatar should be displayed
		echo '
		<div class="twitter-profile">
		<img src="' . $user->profile_image_url . '" alt="' . $user->screen_name . ' Twitter Avatar" class="twitter-avatar">
		<div class="twitter-heading">
			<h3><a class="heading-text-color" href="http://twitter.com/' . $user->screen_name . '">' . $user->screen_name . '</a></h3>
			<div class="description content">' . $user->description . '</div>
		</div>
		</div>	';
	}
	echo '<ul>';
	foreach( $tweets['tweets'] as $tweet ) {
		if( is_object( $tweet ) ) {
			$tweet_text = htmlentities($tweet->text, ENT_QUOTES);
			$tweet_text = preg_replace("/(http:|https:)(\/\/|(www\.))(([^\s<]{4,68})[^\s<]*)/", '<a href="http:$2$3$4" target="_blank">$1$2$4</a>', $tweet_text);

			echo '
		<li>
		  <span class="content">' . $tweet_text . '</span>
		  <div class="date"><a class="heading-text-color" href="http://twitter.com/' . $user->screen_name . '" target="_blank">' . human_time_diff( strtotime( $tweet->created_at ) ) . ' ago </a></div>
		</li>';
		}
	}

	if (!empty($instance['show_link'])) { //check to see if they want follow link displayed
		echo '<li class="follow-link"><a class="action-link headline-color-text" href="http://twitter.com/' . $user->screen_name . '" target="_blank">';
		_e("Follow on Twitter", "cortex");
		echo '</a></li>';
	}

	echo '</ul>';
	?>
	</div>
	<?php

	echo $args['after_widget'];
}

?>