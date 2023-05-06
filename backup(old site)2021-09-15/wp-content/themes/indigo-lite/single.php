<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Indigo Lite
 */

get_header(); ?>
<div id="titlewrapper">
  <div class="frontwidget-bg-img" style="background-image:url(
  <?php if (has_post_thumbnail()) {
        		$featuredImage = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'indigo-slidethumb' );
                echo esc_url($featuredImage);
		} else {
        	header_image();
		} 
		?>
  );"></div>
  <div id="titleinner">
    <h1 class="entry-title">
      <?php the_title(); ?>
    </h1>
  </div>
</div>
<div id="wrapper">
  <div id="contentwrapper">
    <div id="content">
      <?php while ( have_posts() ) : the_post(); ?>
      <div <?php post_class(); ?>>
        <div class="entry">
          	<?php the_content(); ?>
        	<?php echo get_the_tag_list('<p class="singletags">',' ','</p>'); ?>
        	<?php wp_link_pages(array('before' => '<p><strong>'. esc_html__( 'Pages:', 'indigo-lite' ) .'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
        	<?php comments_template(); ?>
        	<?php the_post_navigation(); ?>
        </div>
      </div>
      <?php endwhile; // end of the loop. ?>
    </div>
    <?php get_sidebar(); ?>
  </div>
</div>
<?php get_footer(); ?>
