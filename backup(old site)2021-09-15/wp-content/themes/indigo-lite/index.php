<?php
/**
 * The main template file.
 *
 *
 * @package Indigo Lite
 */

get_header(); ?>

<?php if (!is_front_page()) : ?>
	<div id="titlewrapper">
        <div class="frontwidget-bg-img" style="background-image:url(
  			<?php if (has_post_thumbnail(get_option('page_for_posts'))) {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id(get_option('page_for_posts') ), 'indigo-slidethumb' );
        		echo esc_url($image[0]);
			} else {
        		header_image();
			} 
			?>
  			);">
		</div>
  		<div id="titleinner">
    		<?php if( is_home() && get_option('page_for_posts') ) { $blog_page_id = get_option('page_for_posts'); echo '<h1 class="entry-title">'.esc_html(get_page($blog_page_id)->post_title).'</h1>'; } ?>
  		</div>
	</div>
<?php endif; ?>

<div id="wrapper">
  	<div id="contentwrapper">
    	<div id="content">
      		<?php if (have_posts()) : ?>
      			<?php
					while ( have_posts() ) : the_post();
						get_template_part( 'content', get_post_format() );
					endwhile;
				?>
      		<?php the_posts_pagination(); ?>
      
	  	<?php else : ?>
      
      		<h2 class="center">
        		<?php esc_html_e( 'You don&#39;t have any posts yet.', 'indigo-lite' ); ?>
      		</h2>
      
	  	<?php endif; ?>
    
    	</div>
    	<?php get_sidebar(); ?>
  	</div>
</div>
<?php get_footer(); ?>
