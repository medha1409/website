<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Indigo Lite
 */

get_header(); ?>

<div id="titlewrapper">
	<div class="frontwidget-bg-img" style="background-image:url(<?php header_image(); ?>);"></div>
	<div id="titleinner">
    	<h1 class="entry-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'indigo-lite' ); ?></h1>
    </div>
</div>

<div id="contentwrapper">
  	<div id="content">
    	<?php get_search_form(); ?>
  	</div>
  	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>