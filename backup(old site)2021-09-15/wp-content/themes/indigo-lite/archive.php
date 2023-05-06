<?php
/**
 * The template for displaying Archive pages.
 *
 *
 * @package Indigo Lite
 */

get_header(); ?>

<div id="titlewrapper">
  	<div class="frontwidget-bg-img" style="background-image:url(<?php header_image(); ?>);"></div>

  	<div id="titleinner">
    	<?php
			the_archive_title( '<h1 class="entry-title archive-title">', '</h1>' );
			the_archive_description( '<div class="artsubtitle">', '</div>' );
		?>
  	</div>
</div>

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
        		<?php esc_html_e( 'Not Found', 'indigo-lite' ); ?>
      		</h2>
      
	  	<?php endif; ?>
    
    	</div>
    	<?php get_sidebar(); ?>
  	</div>
</div>
<?php get_footer(); ?>
