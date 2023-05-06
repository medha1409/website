<?php
/**
 * The template for displaying all pages.
 *
 * @package Indigo Lite
 */

get_header(); ?>
<?php if (!is_front_page()) : ?>
	<div id="titlewrapper">
  		<div class="frontwidget-bg-img" style="background-image:url(
  			<?php if (has_post_thumbnail()) {
        		$featuredImage = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'indigo-slidethumb' );
                echo esc_url($featuredImage);
			} else {
        		header_image();
			} 
			?>
  			);">
       </div>
       <div id="titleinner">
    		<h1 class="entry-title">
      			<?php the_title(); ?>
    		</h1>
  		</div>
	</div>
<?php endif; ?>
  
<div id="wrapper">
  <div id="contentwrapper">
    <div id="content">
    <?php if (is_front_page()) : ?>
	<h1 class="entry-title front-title">
      	<?php the_title(); ?>
    </h1>
    <?php endif; ?>
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <div class="post" id="post-<?php the_ID(); ?>">
        <div class="entry">
          <?php the_content(); ?>
        <?php wp_link_pages(array('before' => '<p><strong>'. esc_html__( 'Pages:', 'indigo-lite' ) .'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
        <?php comments_template(); ?>
        </div>
      </div>
      <?php endwhile; endif; ?>
    </div>
    <?php get_sidebar(); ?>
  </div>
</div>
<?php get_footer(); ?>
