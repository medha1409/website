<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package startkit
 */

get_header();
?>
<section id="recent-blog" class="section-padding-80">
        <div class="container">
            <div class="row">	
			
			<!--Blog Detail-->
			<div class="col-lg-9 col-md-12 col-sm-12" >
					
					<?php if( have_posts() ): ?>
						<div class="row">
							<?php while( have_posts() ): the_post(); ?>
							
								<?php get_template_part('template-parts/content','page'); ?>
						
							<?php endwhile; ?>
						</div>
						
					<?php else: ?>
						
						<?php get_template_part('template-parts/content','none'); ?>
						
					<?php endif; ?>
			
			</div>
			<!--/End of Blog Detail-->
			<div class="col-lg-3 col-md-12">
				<section class="sidebar">
					<?php get_sidebar(); ?>
				 </section>
			</div>	
		</div>	
	</div>
</section>

<?php get_footer(); ?>
