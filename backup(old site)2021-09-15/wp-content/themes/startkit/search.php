<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package startkit
 */

get_header(); ?>
<section  id="recent-blog" class="section-padding section-padding-80 search-result">
	<div class="container">
					
		<div class="row">	
			<div class="col-lg-9 col-md-9 col-sm-9">
				<?php
				if ( have_posts() ) :
				
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );

					endwhile;

					the_posts_navigation();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>
			</div>
			<div class="col-lg-3 col-md-12">
                <section class="sidebar">
					<?php get_sidebar(); ?>
				</section>
            </div>
			
		</div>
	</div>
</section>

<?php
get_footer();
