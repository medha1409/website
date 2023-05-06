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
<section  id="blog-content">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-md-12" >
			<?php if( have_posts() ): ?>
					
						<?php while( have_posts() ): the_post(); ?>
						 <article class="blog-post">
                        <div class="post-thumb">
                            <?php the_post_thumbnail(); ?>
                            <div class="post-overlay">
                                <a href="<?php esc_url(the_permalink()); ?>"><i class="fa fa-link"></i></a>
                            </div>
                        </div>
                        <div class="post-content">
                            <h4 class="post-title">
								<a href="<?php esc_url(the_permalink()); ?>">
									<?php  
										if ( is_single() ) :
											the_title('<h5 class="post-title">', '</h5>' );
										else:
											the_title( sprintf( '<h5 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
										endif; 
									?> 
								</a>
							</h4>
                            <p class="content">
                                <?php 
									the_content( 
										sprintf( 
											__( 'Read More', 'startkit' ), 
											'<span class="screen-reader-text">  '.get_the_title().'</span>' 
										) 
									);
								?>
                            </p>
                           
                        </div>
                        <ul class="meta-info">
                            <li class="post-date"><a href="<?php echo esc_url(get_month_link(get_post_time('Y'),get_post_time('m'))); ?>"><?php echo esc_html(get_the_date('j M, Y')); ?></a></li>
                            <li class="comments-quantity"><a href="<?php echo esc_url(get_comments_link( $post->ID )); ?>"> (<?php echo get_comments_number($post->ID); ?>) <?php esc_html_e('Comments','startkit'); ?></a></li>
                            <li class="posted-by"> <?php esc_html_e('By','startkit'); ?> <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>"><?php the_author(); ?></a></li>
                            <li class="post-category"><a href="<?php esc_url(the_permalink()); ?>"><?php the_category(', '); ?></a></li>
                        </ul>
					</article>	
						<?php endwhile; ?>
						
						<!-- Pagination -->
						
								<div class="paginations">
									<?php						
										// Previous/next page navigation.
										the_posts_pagination( 
											array(
												'prev_text'          => '<i class="fa fa-angle-double-left"></i>',
												'next_text'          => '<i class="fa fa-angle-double-right"></i>',
											) 
										); 
									?>
								</div>
					
						<!-- Pagination -->
						
					<?php else: ?>
						
						<?php get_template_part('template-parts/content','none'); ?>
						
					<?php endif; ?>
					<?php comments_template( '', true ); // show comments  ?>
			</div>
			<div class="col-lg-3 col-md-12">
				<section class="sidebar">
					<?php get_sidebar(); ?>
				</section>
			</div>
		</div>
	</div>
</section>	
<!-- End of Blog & Sidebar Section -->
 
<div class="clearfix"></div>

<?php get_footer(); ?>
