<div class="magazine-recent-posts">
		<div class="widget-single-article-container">
	        <?php while ( $cortex_upcoming_events->have_posts() ) : $cortex_upcoming_events->the_post();
		    //custom field renaming for use
		    $u_start				 = get_field('date_and_time');
			$u_date					 = date('F j, Y', strtotime($u_start));
			$event_headline			 = get_field('event_headline');
			$location_name			 = get_field('location_name');
			$location_city_country	 = get_field('location_city_country');
			$location_address		 = get_field('location_address');
			$location_map_link		 = get_field('location_map_link');
			$event_ticket_link		 = get_field('event_ticket_link');
			$rsvp_link				 = get_field('rsvp_link');
			$share_buttons			 = get_field('share_buttons');
	        ?>
			<article class="single-article mar40B clearfix">

				<header class="single-article-title">
					<div class="magazine-article-date"><span class="h6 alternate"><?php echo $u_date; ?></span></div>
					<h5 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><span class="mar0T"><?php the_title();?></span></a></h5>
					<div class="venue">
						<?php if ( !empty($location_map_link) ) { ?>
						<a href="<?php echo $location_map_link; ?>" target="_blank">
						<?php } ?>
						<?php if ( !empty($location_name) ) { ?><span class="secondary-font h6"><?php echo $location_name; ?></span><?php } ?>
						<?php if ( !empty($location_map_link) ) { ?></a><?php } ?>
					</div>
				</header>
				<div class="clearfix"></div>
				<div class="row">
		            <?php if ( has_post_thumbnail() ) { ?>
					<div class="col-xs-6 col-sm-12 col-md-5">
		            	<figure class="single-article-image entry-image alignleft">
		            		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		                    	<?php the_post_thumbnail('cortex-xlarge', array('class' => 'img-responsive')); ?>
		                    </a>
		    			</figure>
					</div><!--end of col-->
		            <?php } ?>
					<div class="col-xs-6 col-sm-12 col-md-7">
						<div class="event-act">
						<?php if ( !empty($event_headline) ) { ?><span class="h6 opener headline-font mar0B mar0T"><?php echo $event_headline; ?></span><?php } ?>
						<?php // check if the repeater field has rows of data
						if( have_rows('additional_headliners') ):

						 	// loop through the rows of data
						    while ( have_rows('additional_headliners') ) : the_row();
						?>
								<span class="h6 opener headline-font mar0B"><?php the_sub_field('headliner'); ?></span>
						<?php
						    endwhile;
						    endif;
						?>
						</div>

						<div class="clearfix"></div>

						<div class="event-buttons mar10T">
							<?php if ( !empty($event_ticket_link) ) { ?><a class="btn btn-sm btn-default" href="<?php echo $event_ticket_link; ?>" target="_blank"><?php _e('Tickets', 'cortex'); ?></a><?php } ?>
							<a class="btn btn-sm btn-primary" href="<?php the_permalink(); ?>"><?php _e('Details', 'cortex'); ?></a>
						</div>
					</div><!--end of col-->
				</div><!--end of row-->
			</article>
	        <?php endwhile; ?>
		</div>
</div><!--end magazine-recent-posts-->
