<?php
/**
 * Template part for displaying front page blog section.
 *
 * @package Moral
 */

// Get default  mods value.
$blog_section = get_theme_mod( 'magic_blog_blog_section', 'recent-posts' );

if ( 'disable' === $blog_section ) {
	return;
}

$default = magic_blog_get_default_mods();


?> 
       
<div id="blog" class="page-section">
    <div class="wrapper">
        <div class="section-header clear">
        	<?php  
        	$section_title =  get_theme_mod( 'magic_blog_blog_section_title', $default['magic_blog_blog_section_title'] );
        	if ( ! empty( $section_title ) ) : ?>
            	<h2 class="section-title"><?php echo esc_html( $section_title ); ?></h2>
        	<?php endif; ?>
        </div><!-- .section-header -->
        <?php $blog_counter = get_theme_mod( 'magic_blog_blog_section_num', 5 ); 
        $class='';
        if ($blog_counter <= 3) {
        	$class = 'col-2';
        	} else {
        		$class='col-3';
        	}
        ?>

        <div class="section-content clear <?php echo esc_attr($class); ?>">
        <?php  
        	if ( 'recent-posts' === $blog_section ) {
            	$args = array(
            			'posts_per_page' => $blog_counter,
            			'ignore_sticky_posts' => true,
            		);
        	} elseif ( 'cat' === $blog_section ) {
        		$blog_cat_id = get_theme_mod( 'magic_blog_blog_section_cat' );
        		$args = array(
            			'posts_per_page' => $blog_counter,
            			'ignore_sticky_posts' => true,
            			'cat' => $blog_cat_id,
            		);
        	}

        	$query = new WP_Query( $args );
        	
			$i=1;
			if ( $query->have_posts() ) : 
				while ( $query->have_posts() ) :
					$query->the_post(); 

				 
			        $blog_class='';
			        if ($i == 2) {
			         	$blog_class='large-width';
			         } ?>
		            <article class="<?php echo esc_attr( $blog_class ); ?>">
		                <div class="post-wrapper">
		                    <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'large' ); ?>');');">
		                        <a href="<?php the_permalink(); ?>" class="post-thumbnail-link"></a>
		                    </div><!-- .featured-image -->

		                    <div class="entry-container">
		                        <div class="entry-meta">
		                            <span class="posted-on">
		                                <span class="screen-reader-text"><?php esc_html__('Posted on', 'magic-blog') ?></span> 
		                                <a href="http://localhost/wordpress/tourable-pro/2018/10/" rel="bookmark" tabindex="-1">
		                                    <time class="entry-date published" datetime="2018-10-22T06:27:14+00:00"><?php magic_blog_posted_on(); ?></time>
		                                    <time class="updated" datetime="2018-10-29T05:26:59+00:00"><?php magic_blog_posted_on(); ?></time>
		                                </a>
		                            </span><!-- .posted-on -->
		                            <span class="byline"><?php esc_html_e('By:', 'magic-blog'); ?><span class="author vcard">
		                                <a class="url fn n" href="<?php the_permalink(); ?>" tabindex="-1"><?php echo esc_html( get_the_author() ); ?></a></span>
		                            </span><!-- .byline -->
		                        </div>

		                        <header class="entry-header">
		                            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		                        </header>
		                        <?php if ($i == 2): ?>
			                        <div class="entry-content">
			                            <?php the_excerpt(); ?>

			                        </div><!-- .entry-content -->

			                        <span class="cat-links">
			                            <?php the_category( esc_html__( ', ', 'magic-blog' ) ); ?>
			                        </span>
		                        <?php endif ?>
		                    </div><!-- .entry-container -->
		                </div><!-- .post-wrapper -->
		            </article>
		            <?php $i++; endwhile;?>
		        <?php wp_reset_postdata();?>
        	<?php endif; ?>
        </div><!-- .section-content -->
    </div><!-- .wrapper -->
</div><!-- #blog -->