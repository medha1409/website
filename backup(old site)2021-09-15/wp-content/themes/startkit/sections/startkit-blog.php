<!-- Start: Recent Blog
============================= -->
<?php 
	$hide_show_blog = get_theme_mod('hide_show_blog','1');
	$startkit_blog_title = get_theme_mod('blog_title');
	$blog_description = get_theme_mod('blog_description'); 
	$blog_display_num = get_theme_mod('blog_display_num','3');
?>
<?php if($hide_show_blog == '1') {?>
<section id="recent-blog" class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3 text-center">
				<div class="section-header">
					<?php if($startkit_blog_title) { ?>
						<h2><?php echo esc_html($startkit_blog_title); ?></h2>
					<?php } ?>
					<?php if($blog_description) { ?>
						<p class="wow fadeInUp" data-wow-delay="0.1s"><?php echo esc_html($blog_description); ?></p>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="row">
			<?php 	
				 if ( function_exists( 'cleverfox_activate' ) ) { 
					$args = array( 'post_type' => 'post','posts_per_page' => $blog_display_num,'post__not_in'=>get_option("sticky_posts")) ; 	
				}else{
					$args = array( 'post_type' => 'post','post__not_in'=>get_option("sticky_posts")) ; 	
				}
					 $startkit_wp_query = new WP_Query($args);
					if($startkit_wp_query)
					{	
					while($startkit_wp_query->have_posts()):$startkit_wp_query->the_post(); ?>
					<div class="col-lg-4 col-md-6 col-sm-12 mb-lg-0 mb-4">
						<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
							<div class="post-thumbnail">
								<?php if ( has_post_thumbnail() ) { ?>
								<ul class="meta-info list-inline">
									<li class="posted-by"><?php esc_html_e('By','startkit'); ?> <a class="url fn n" href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>"><?php the_author(); ?></a></li>
									<li class="post-date"><?php echo esc_html(get_the_date('j M Y')); ?></li>
									 
									 
									 <?php   $cat_list = get_the_category_list();
									if(!empty($cat_list)) { ?>
								
								   <li class="tags"><?php esc_html_e('Categories:','startkit'); ?><a href="<?php esc_url(the_permalink()); ?>"> <?php the_category(', '); ?></a></li>
								
								<?php } ?>
								</ul>
								<?php } ?>
								
								<a  href="<?php esc_url(the_permalink()); ?>" class="img-responsive center-block home-blogs" ><?php the_post_thumbnail(); ?></a>
							</div>
							<div class="post-content">
								<div class="post-content-inner read-more-wrapper">
									<?php     
										if ( is_single() ) :
										
										the_title('<h5 class="post-title">', '</h5>' );
										else:
										the_title( sprintf( '<h5 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
										endif; 
									?> 
								   <?php 
										the_content( 
											sprintf( 
												__( 'Read More', 'startkit' ), 
												'<span class="screen-reader-text">  '.esc_html(get_the_title()).'</span>' 
											) 
										);
									?>
								</div><!-- .entry-content -->
							</div>
						</article>
					</div>
			<?php 
				endwhile; 
				wp_reset_postdata(); 
				}
			?>
			
		</div>
	</div>
</section>
<?php } ?>
<!-- End: Recent Blog
============================= -->