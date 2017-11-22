<?php
/*
 * Template for the output of the Cortex Twitter Widget
 * Override by placing a file called widget-twitter-template.php in your active theme in a directory called widgets
 */

/* Output
	single tweet and a link
*/

$tweets = $this->get_tweets( $args['widget_id'], $instance );


if( !empty( $tweets['tweets'] ) and empty( $tweets['tweets']->errors ) ) {

	echo $args['before_widget'];

	$user = current( $tweets['tweets'] );
	$user = $user->user;


	foreach( $tweets['tweets'] as $tweet ) {
		if( is_object( $tweet ) ) {
			$tweet_text = htmlentities($tweet->text, ENT_QUOTES);
			$tweet_text = preg_replace("/(http:|https:)(\/\/|(www\.))(([^\s<]{4,68})[^\s<]*)/", '<a href="$1$2$4" target="_blank" class="light-color-text">$1$2$4</a>', $tweet_text);

		?>
			<div class="twitter-tweet <?php if ($instance['style'] == 'darklarge') { echo "big ";} ?>dark">
				<div class="twitter-container">
					<div class="container">
						<div class="row">
							<div class="col-sm-12 twitter-content">
							<ul>
								<li class="icon-twitter-normal">
									<span class="third-color-text tweet-text"><?php echo $tweet_text ?></span>
									<a class="date clearfix" href="http://twitter.com/<?php echo $user->screen_name; ?>" target="_blank"><span class="secondary-color-text"><?php echo human_time_diff( strtotime( $tweet->created_at ) ); ?> <?php _e('ago', 'cortex'); ?></span></a>
								</li>
							</ul>
							<?php
							if (!empty($instance['show_link'])) { //check to see if they want follow link displayed
								echo '<a class="follow-link action-link light-color-text" href="http://twitter.com/' . $user->screen_name . '" target="_blank">';
								_e("Follow on Twitter", "cortex");
								echo '</a>';
							}
							?>
							</div><!--end col-->
						</div><!--end row-->
					</div><!--end container-->
					<div class="clearfix"></div>
					<div class="bg dark-color-bg">&nbsp;</div>
				</div><!--end twitter-container-->
			</div><!--end twitter tweet-->
		<?php
		}
	}



	echo $args['after_widget'];
}

?>