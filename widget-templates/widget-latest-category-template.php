<div class="magazine-recent-posts">
		<div class="widget-single-article-container">
	        <?php while ( $cortex_latest_cat_posts->have_posts() ) : $cortex_latest_cat_posts->the_post(); ?>
			<article class="single-article mar20B">
            <?php if ( has_post_thumbnail() ) { ?>
            	<figure class="single-article-image entry-image alignleft">
            		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    	<?php the_post_thumbnail('cortex-featured', array('class' => 'img-responsive')); ?>
                    </a>
    			</figure>
    		<?php } ?>
				<header class="single-article-title<?php if ( (!has_post_thumbnail()) ) { echo " d100"; } else { echo " alignleft";} ?>">
					<div class="magazine-article-date"><span class="h6 alternate"><?php cortextoo_widgets_posted_on(); ?></span></div>
					<h5 class="entry-title mar5T mar5B h6"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><span class="mar0T"><?php the_title();?></span></a></h5>
				</header>
				<div class="clearfix">&nbsp;</div>
			</article>
	        <?php endwhile; ?>
		</div>
</div>