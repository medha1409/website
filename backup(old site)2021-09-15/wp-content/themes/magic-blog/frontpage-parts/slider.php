<?php
/**
 * Template part for displaying front page slider.
 *
 * @package Moral
 */

// Get default  mods value.
$slider = get_theme_mod( 'magic_blog_slider', 'custom' );

if ( 'disable' === $slider ) {
    return;
}

$default = magic_blog_get_default_mods();

$slider_num = get_theme_mod( 'magic_blog_slider_num', 3 );

?>
<div id="featured-slider-section" class="relative">
    <div class="featured-slider" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": true, "speed": 1000, "dots": false, "arrows":true, "autoplay": true, "draggable": true, "adaptiveHeight": true, "fade": true }'>
    	<?php

        	    
	        $slider_id = array();
	        for ( $i=1; $i <= $slider_num; $i++ ) { 
	            $slider_id[] = get_theme_mod( "magic_blog_slider_post_" . $i );
	        }
	        $args = array(
	            'post_type' => $slider,
	            'post__in' => (array)$slider_id,   
                'orderby'   => 'post__in',
	            'posts_per_page' => $slider_num,
	            'ignore_sticky_posts' => true,
	        );
        	    

	    $query = new WP_Query( $args );

	    $i = 1;
	    if ( $query->have_posts() ) :
	        while ( $query->have_posts() ) :
	            $query->the_post();
			       $image_url = get_the_post_thumbnail_url();
				   $color_value = magic_blog_calculate_banner_image_brightness($image_url);
		                	 
	            ?>
		        <article style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
		            <div class="wrapper">
		                <div class="entry-container" style="">
		                	
		                    <div class="entry-meta">
		                        <span class="posted-on">
		                            <span class="screen-reader-text"><?php esc_html_e('Posted on', 'magic-blog'); ?></span> 
		                            <a href="<?php the_permalink(); ?>" rel="bookmark" style="color:<?php echo esc_attr($color_value);?>">
		                                <time class="entry-date published" datetime="2018-10-22T06:27:14+00:00" style="color:<?php echo esc_attr($color_value);?>"><?php magic_blog_posted_on(); ?></time>
		                                <time class="updated" datetime="2018-10-29T05:26:59+00:00" style="color:<?php echo esc_attr($color_value);?>"><?php magic_blog_posted_on(); ?></time>
		                            </a>
		                        </span><!-- .posted-on -->
		                        <span class="byline" style="color:<?php echo esc_attr($color_value);?>" ><?php esc_html_e('By:', 'magic-blog'); ?> <span class="author vcard">
		                            <a class="url fn n" href=" <?php esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?> " style="color:<?php echo esc_attr($color_value);?>" > <?php echo esc_html( get_the_author() ); ?> </a></span>
		                        </span><!-- .byline -->
		                    </div><!-- .entry-meta -->

		                    <header class="entry-header">
		                        <h2 class="entry-title" ><a href="<?php the_permalink(); ?>" style="color:<?php echo esc_attr($color_value);?>"><?php the_title(); ?></a></h2>
		                    </header>

		                    <div class="entry-content" >
		                        <?php $excerpt= get_the_excerpt(); ?>
		                        <p style="color:<?php echo esc_attr($color_value);?>"><?php echo wp_kses_post(strip_tags(substr( get_the_excerpt(), 0, 200 )) ); ?></p>
		                    </div><!-- .entry-content -->
		                    <div class="read-more">
		                        <a href="<?php the_permalink(); ?>" class="btn btn-fill" tabindex="0"><?php echo esc_html( get_theme_mod( 'magic_blog_slider_custom_btn_' . $i, $default['magic_blog_slider_custom_btn'] ) ); ?>
		                        </a>
		                    </div>                           
		                </div>
		            </div><!-- .wrapper-->
		        </article>
	        <?php 
		        $i++;
	    	endwhile;
	        wp_reset_postdata();
		 endif;  ?>
    </div><!-- .featured-slider -->
</div><!-- #featured-slider-section -->
