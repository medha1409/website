<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package startkit
 */

?>
<div class="col-lg-6 col-md-6 col-sm-12 mb-lg-0 mb-4">
	<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
		<div class="post-thumbnail">
			<?php if ( has_post_thumbnail() ) { ?>
			<ul class="meta-info list-inline">
				 <li class="post-date"><?php echo esc_html(get_the_date('j M Y')); ?></li>
				 <li class="posted-by"><?php esc_html_e('By','startkit'); ?> <a class="url fn n" href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>"><?php the_author(); ?></a></li>
				 
				 <?php   $cat_list = get_the_category_list();
					if(!empty($cat_list)) { ?>
					 <li class="tags"> <?php esc_html_e('Categories:','startkit'); ?>  <a href="<?php esc_url(the_permalink()); ?>"> <?php the_category(', '); ?></a></li>
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
							'<span class="screen-reader-text">  '.get_the_title().'</span>' 
						) 
					);
				?>
			</div><!-- .entry-content -->
		</div>
	</article>
</div>				