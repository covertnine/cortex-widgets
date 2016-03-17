<div class="magazine-recent-posts">
		<div class="widget-single-article-container">
	        <?php while ( $cortex_upcoming_events->have_posts() ) : $cortex_upcoming_events->the_post();
		    //custom field renaming for use
		    $u_start				 = get_field('date_and_time');
			$u_date					 = date_i18n('F j, Y', $u_start);
			$event_headline			 = get_field('event_headline');
			$location_name			 = get_field('location_name');
			$location_city_country	 = get_field('location_city_country');
			$location_address		 = get_field('location_address');
			$location_map_link		 = get_field('location_map_link');
			$event_ticket_link		 = get_field('event_ticket_link');
			$rsvp_link				 = get_field('rsvp_link');
			$share_buttons			 = get_field('share_buttons');
			 $opener_1				 = get_field('opener_1');
			 $opener_2				 = get_field('opener_2');
			 $opener_3				 = get_field('opener_3');
			 $opener_4				 = get_field('opener_4');
			 $opener_5				 = get_field('opener_5');
	        ?>
			<article class="single-article mar20B clearfix">

				<header class="single-article-title">
					<h5 class="entry-title mar0B"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><span class="mar0T"><?php the_title();?></span></a></h5>
					<div class="magazine-article-date"><span class="h6 alternate"><?php echo $u_date; ?></span></div>
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
					<div class="col-xs-6 col-sm-12 col-md-5">
		            <?php if ( has_post_thumbnail() ) { ?>
		            	<figure class="single-article-image entry-image alignleft">
		            		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		                    	<?php the_post_thumbnail('large', array('class' => 'img-responsive')); ?>
		                    </a>
		    			</figure>
		            <?php } elseif( first_post_image() ) { // Set the first image from the editor ?>
						<figure class="single-article-image entry-image alignleft">
		            		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		            			<img src="<?php echo first_post_image(); ?>" alt="<?php the_title(); ?>" />
		            		</a>
		        		</figure>
					<?php } ?>
					</div><!--end of col-->
					<div class="col-xs-6 col-sm-12 col-md-7">
						<div class="event-act">
						<?php if ( !empty($event_headline) ) { ?><span class="h6 opener headline-font mar0B mar0T"><?php echo $event_headline; ?></span><?php } ?>
						<?php if ( !empty($opener_1) ) { ?><span class="h6 opener headline-font mar0B"><?php echo $opener_1; ?></span><?php } ?>
						<?php if ( !empty($opener_2) ) { ?><span class="h6 opener headline-font mar0B"><?php echo $opener_2; ?></span><?php } ?>
						<?php if ( !empty($opener_3) ) { ?><span class="h6 opener headline-font mar0B"><?php echo $opener_3; ?></span><?php } ?>
						<?php if ( !empty($opener_4) ) { ?><span class="h6 opener headline-font mar0B"><?php echo $opener_4; ?></span><?php } ?>
						<?php if ( !empty($opener_5) ) { ?><span class="h6 opener headline-font mar0B"><?php echo $opener_5; ?></span><?php } ?>
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
