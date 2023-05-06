<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Indigo Lite
 */

get_header(); ?>

<div id="titlewrapper">
  		<div class="frontwidget-bg-img" style="background-image:url(<?php header_image(); ?>);"></div>

  		<div id="titleinner">
    		<h1 class="entry-title"><?php printf( esc_html__( 'Search Results for: %s', 'indigo-lite' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
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
    <h2 class="center"><?php esc_html_e( 'No Post Found', 'indigo-lite' ); ?></h2>
    <?php endif; ?>
  </div>
  <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
