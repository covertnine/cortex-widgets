<div class="c9-recent-posts">
	<div class="c9-recent-posts-container">
        <?php while ( $cortex_latest_cat_posts->have_posts() ) : $cortex_latest_cat_posts->the_post(); ?>
		<article class="c9-single-article mar20B">
        <?php if ( has_post_thumbnail() ) { ?>
        	<figure class="c9-single-article-image entry-image alignleft">
        		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                	<?php the_post_thumbnail('cortex-featured', array('class' => 'img-responsive')); ?>
                </a>
			</figure>
		<?php } ?>
			<header class="c9-single-article-title<?php if ( (has_post_thumbnail()) ) { echo " alignleft"; } ?>">
				<div class="c9-single-article-date"><span class="h6"><?php cortextoo_widgets_posted_on(); ?></span></div>
				<h4 class="entry-title mar5T mar5B h6"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><span class="mar0T"><?php the_title();?></span></a></h4>
			</header>
		</article>
        <?php endwhile; ?>
	</div>
</div>