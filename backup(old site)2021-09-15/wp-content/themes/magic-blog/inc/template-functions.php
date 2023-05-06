<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Moral
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function magic_blog_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	} 

	
	// When global archive layout is checked.
	if ( is_archive() || magic_blog_is_latest_posts() || is_404() || is_search() ) {
		$archive_sidebar = get_theme_mod( 'magic_blog_archive_sidebar', 'right' ); 
		$classes[] = esc_attr( $archive_sidebar ) . '-sidebar';
	} else if ( is_single() ) { // When global post sidebar is checked.
    	$magic_blog_post_sidebar_meta = get_post_meta( get_the_ID(), 'magic-blog-select-sidebar', true );
    	if ( ! empty( $magic_blog_post_sidebar_meta ) ) {
			$classes[] = esc_attr( $magic_blog_post_sidebar_meta ) . '-sidebar';
    	} else {
			$global_post_sidebar = get_theme_mod( 'magic_blog_global_post_layout', 'right' ); 
			$classes[] = esc_attr( $global_post_sidebar ) . '-sidebar';
    	}
	} elseif ( magic_blog_is_frontpage_blog() || is_page() ) {
		if ( magic_blog_is_frontpage_blog() ) {
			$page_id = get_option( 'page_for_posts' );
		} else {
			$page_id = get_the_ID();
		}

    	$magic_blog_page_sidebar_meta = get_post_meta( $page_id, 'magic-blog-select-sidebar', true );
		if ( ! empty( $magic_blog_page_sidebar_meta ) ) {
			$classes[] = esc_attr( $magic_blog_page_sidebar_meta ) . '-sidebar';
		} else {
			$global_page_sidebar = get_theme_mod( 'magic_blog_global_page_layout', 'right' ); 
			$classes[] = esc_attr( $global_page_sidebar ) . '-sidebar';
		}
	}

	// Site layout classes
	$site_layout = get_theme_mod( 'magic_blog_site_layout', 'wide' );
	$classes[] = esc_attr( $site_layout ) . '-layout';

  // Animation enable
  $animation_enable = get_theme_mod( 'magic_blog_animation_enable', false );
  $classes[] = ( $animation_enable ) ? 'animaton-enable' : '';

	return $classes;
}
add_filter( 'body_class', 'magic_blog_body_classes' );

function magic_blog_post_classes( $classes ) {
	if ( magic_blog_is_page_displays_posts() ) {
		// Search 'has-post-thumbnail' returned by default and remove it.
		$key = array_search( 'has-post-thumbnail', $classes );
		unset( $classes[ $key ] );
		
		$archive_img_enable = get_theme_mod( 'magic_blog_enable_archive_featured_img', true );

		if( has_post_thumbnail() && $archive_img_enable ) {
			$classes[] = 'has-post-thumbnail';
		} else {
			$classes[] = 'no-post-thumbnail';
		}
	}

  $classes[] = 'animated animatedFadeInUp';
  
	return $classes;
}
add_filter( 'post_class', 'magic_blog_post_classes' );

/**
 * Excerpt length
 * 
 * @since Moral 1.0.0
 * @return Excerpt length
 */
function magic_blog_excerpt_length( $length ){
	if ( is_admin() ) {
		return $length;
	}

	$length = get_theme_mod( 'magic_blog_archive_excerpt_length', 60 );
	return $length;
}
add_filter( 'excerpt_length', 'magic_blog_excerpt_length', 999 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function magic_blog_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'magic_blog_pingback_header' );

/**
 * Get an array of post id and title.
 * 
 */
function magic_blog_get_post_choices() {
	$choices = array( '' => esc_html__( '--Select--', 'magic-blog' ) );
	$args = array( 'numberposts' => -1, );
	$posts = get_posts( $args );

	foreach ( $posts as $post ) {
		$id = $post->ID;
		$title = $post->post_title;
		$choices[ $id ] = $title;
	}

	return $choices;
}

/**
 * Get an array of cat id and title.
 * 
 */
function magic_blog_get_post_cat_choices() {
  $choices = array( '' => esc_html__( '--Select--', 'magic-blog' ) );
	$cats = get_categories();

	foreach ( $cats as $cat ) {
		$id = $cat->term_id;
		$title = $cat->name;
		$choices[ $id ] = $title;
	}

	return $choices;
}

/**
 * Checks to see if we're on the homepage or not.
 */
function magic_blog_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}

/**
 * Checks to see if Static Front Page is set to "Your latest posts".
 */
function magic_blog_is_latest_posts() {
	return ( is_front_page() && is_home() );
}

/**
 * Checks to see if Static Front Page is set to "Posts page".
 */
function magic_blog_is_frontpage_blog() {
	return ( is_home() && ! is_front_page() );
}

/**
 * Checks to see if the current page displays any kind of post listing.
 */
function magic_blog_is_page_displays_posts() {
	return ( magic_blog_is_frontpage_blog() || is_search() || is_archive() || magic_blog_is_latest_posts() );
}

/**
 * Shows a breadcrumb for all types of pages.  This is a wrapper function for the Breadcrumb_Trail class,
 * which should be used in theme templates.
 *
 * @since  1.0.0
 * @access public
 * @param  array $args Arguments to pass to Breadcrumb_Trail.
 * @return void
 */
function magic_blog_breadcrumb( $args = array() ) {
	$breadcrumb = apply_filters( 'breadcrumb_trail_object', null, $args );

	if ( ! is_object( $breadcrumb ) )
		$breadcrumb = new Breadcrumb_Trail( $args );

	return $breadcrumb->trail();
}

/**
 * Pagination in archive/blog/search pages.
 */
function magic_blog_posts_pagination() { 
	$archive_pagination = get_theme_mod( 'magic_blog_archive_pagination_type', 'numeric' );
	if ( 'disable' === $archive_pagination ) {
		return;
	}
	if ( 'numeric' === $archive_pagination ) {
		the_posts_pagination( array(
            'prev_text'          => magic_blog_get_svg( array( 'icon' => 'left-arrow' ) ) . esc_html__( 'Previous', 'magic-blog' ),
            'next_text'          => magic_blog_get_svg( array( 'icon' => 'left-arrow' ) ) .esc_html__( 'Next', 'magic-blog' ),
        ) );
	} elseif ( 'older_newer' === $archive_pagination ) {
        the_posts_navigation( array(
            'prev_text'          => magic_blog_get_svg( array( 'icon' => 'left-arrow' ) ) . '<span>'. esc_html__( 'Older', 'magic-blog' ) .'</span>',
            'next_text'          => '<span>'. esc_html__( 'Newer', 'magic-blog' ) .'</span>' . magic_blog_get_svg( array( 'icon' => 'left-arrow' ) ),
        )  );
	}
}

function magic_blog_get_svg_by_url( $url = false ) {
	if ( ! $url ) {
		return false;
	}

	$social_icons = magic_blog_social_links_icons();

	foreach ( $social_icons as $attr => $value ) {
		if ( false !== strpos( $url, $attr ) ) {
			return magic_blog_get_svg( array( 'icon' => esc_attr( $value ) ) );
		}
	}
}


function magic_blog_calculate_banner_image_brightness($image_path){

    
    if ( substr ( $image_path , ( strlen($image_path) - 4 )) == '.png' ) {
      $image = imagecreatefrompng($image_path);
    }else{
      $image = imagecreatefromjpeg($image_path);
    }

    $image_size = getimagesize($image_path);
  

    $cord_x   = ( $image_size[0]/2 )-200;
    $cord_y   = ( $image_size[1]/2 )-100;
    $luma   = 0;
    $count = 0;
    for ($i=0; $i < 5; $i++) { 
      for ($j=0; $j < 5; $j++) { 
        $cord_x = $cord_x + ( $j == 0 ? 0 : 100 );
        $rgb = imagecolorat($image, $cord_x, $cord_y );
        $colors = imagecolorsforindex($image, $rgb);
        $luma = $luma + ( 0.2126 * $colors['red'] + 0.7152 * $colors['green'] + 0.0722 * $colors['blue'] );
      }
      $cord_x = 395;
      $cord_y = $cord_y + 50;
     } 

     $luma = $luma/25;
    if ( $luma > 110 ) {
      return "#000";
    }else{
      return "#fff";
    }
}

function magic_blog_custom_color_scheme() {
    if ( 'custom' != get_theme_mod( 'magic_blog_color_scheme' ) ) {
        return;
    }
    $color = get_theme_mod( 'magic_blog_custom_color_scheme', '#ff8737' );
    $custom_css = '
           	/*----------------------------------------
           		Color
           	------------------------------------------*/
           	a,
           	.site-title a:hover, 
           	.site-title a:focus,
           	.main-navigation ul#primary-menu li.current-menu-item > a, 
           	.main-navigation ul#primary-menu li:hover > a, 
           	.main-navigation ul#primary-menu li:focus > a,
           	.main-navigation a:hover, 
           	.main-navigation a:focus, 
           	.main-navigation ul.nav-menu > li > a:hover, 
           	.main-navigation ul.nav-menu > li > a:focus,
           	#services-section article .entry-title a:hover, 
           	#services-section article .entry-title a:focus,
           	#projects-section .entry-title a:hover, 
           	#projects-section .entry-title a:focus, 
           	#projects-section .entry-meta .cat-links a:hover, 
           	#projects-section .entry-meta .cat-links a:focus,
           	.blog-posts-wrapper .entry-container .entry-title a:hover, 
           	.blog-posts-wrapper .entry-container .entry-title a:focus, 
           	.blog-posts-wrapper .featured-image .entry-meta a:hover, 
           	.blog-posts-wrapper .featured-image .entry-meta a:focus,
           	.blog-posts-wrapper .cat-links a, 
           	.blog-posts-wrapper .cat-links,
           	.widget_popular_post h3 a:hover, 
           	.widget_popular_post h3 a:focus, 
           	.widget_popular_post a:hover time, 
           	.widget_popular_post a:focus time, 
           	.widget_latest_post h3 a:hover, 
           	.widget_latest_post h3 a:focus, 
           	.widget_latest_post a:hover time, 
           	.widget_latest_post a:focus time,
           	.pagination .page-numbers.prev, 
           	.pagination .page-numbers.next,
           	.pagination .page-numbers, 
           	.pagination .page-numbers.dots:hover, 
           	.pagination .page-numbers.dots:focus,
           	.single-post-wrapper span.tags-links a:hover, 
           	.single-post-wrapper span.tags-links a:focus,
           	.post-navigation a, 
           	.posts-navigation a,
           	.comment-meta .url:hover, 
           	.comment-meta .url:focus, 
           	.comment-metadata a, 
           	.comment-metadata a time,
            #secondary ul li a:hover,
            #secondary ul li a:focus {
           	    color: ' . esc_attr( $color ) . ';
           	}

           	.main-navigation ul#primary-menu li:hover > svg, 
           	.main-navigation ul#primary-menu li:focus > svg, 
           	.main-navigation li.menu-item-has-children:hover > a > svg, 
           	.main-navigation li.menu-item-has-children > a:hover > svg, 
           	.main-navigation li.menu-item-has-children > a:focus > svg, 
           	.main-navigation ul#primary-menu > li.current-menu-item > a > svg,
           	.main-navigation ul.nav-menu > li > a.search:hover svg.icon-search, 
           	.main-navigation ul.nav-menu > li > a.search:focus svg.icon-search, 
           	.main-navigation li.search-menu a:hover svg, 
           	.main-navigation li.search-menu a:focus svg, 
           	.main-navigation li.search-menu a.search-active svg,
           	.widget_search form.search-form button.search-submit:hover svg, 
           	.widget_search form.search-form button.search-submit:focus svg,
           	.pagination .prev.page-numbers svg, 
           	.pagination .next.page-numbers svg,
           	.single-post-wrapper span.posted-on svg, 
           	.single-post-wrapper span.cat-links svg,
           	.navigation.posts-navigation svg, 
           	.navigation.post-navigation svg,
            .byline svg {
           		fill: ' . esc_attr( $color ) . ';
           	}

           	@media screen and (min-width: 1024px) {
           		.modern-menu .main-navigation ul#primary-menu ul li.current-menu-item > a, 
           		.modern-menu .main-navigation ul#primary-menu ul li:hover > a, 
           		.modern-menu .main-navigation ul#primary-menu ul li:focus > a,
              .main-navigation ul#primary-menu ul li.current-menu-item > a {
           			color: ' . esc_attr( $color ) . ';
           		}
           	}

           	/*----------------------------------------
           		Background Color
           	------------------------------------------*/
           	.slick-prev, 
           	.slick-next,
           	.btn-default:hover, 
           	.btn-default:focus,
           	.slick-dots li.slick-active button,
           	.section-subtitle:after,
           	.btn-primary,
           	.testimonial-slider .entry-subtitle:after,
           	.testimonial-slider .slick-slide:nth-child(1) ul.slick-dots li:nth-child(1) button, 
           	.testimonial-slider .slick-slide:nth-child(2) ul.slick-dots li:nth-child(2) button, 
           	.testimonial-slider .slick-slide:nth-child(3) ul.slick-dots li:nth-child(3) button, 
           	.testimonial-slider .slick-slide:nth-child(4) ul.slick-dots li:nth-child(4) button, 
           	.testimonial-slider .slick-slide:nth-child(5) ul.slick-dots li:nth-child(5) button, 
           	.testimonial-slider .slick-slide:nth-child(6) ul.slick-dots li:nth-child(6) button,
           	.backtotop,
           	.pagination .page-numbers.current, 
           	.pagination .page-numbers:hover, 
           	.pagination .page-numbers:focus,
           	.reply a,
           	#respond input[type="submit"],
           	#projects-section .more-link:hover,
           	#projects-section .more-link:focus,
            .read-more-link a {
           		background-color: ' . esc_attr( $color ) . ';
           	}

           	.pagination .page-numbers, 
           	.pagination .page-numbers {
           		background-color: #eee;
           	}

           	@media screen and (min-width: 1024px) {
           		.main-navigation ul.sub-menu li:hover > a, 
           		.main-navigation ul.sub-menu li:focus > a {
           			background-color: ' . esc_attr( $color ) . ';
           		}
           	}

           	/*----------------------------------------
           		Border Color
           	------------------------------------------*/
           	.btn-default:hover, 
           	.btn-default:focus,
           	.single-post-wrapper span.tags-links a:hover, 
           	.single-post-wrapper span.tags-links a:focus {
           		border-color: ' . esc_attr( $color ) . ';
           	}

           	@media screen and (min-width: 1024px) {
           		.main-navigation ul ul {
           		    border-top-color: ' . esc_attr( $color ) . ';
           		}
           		.main-navigation ul.nav-menu > li.menu-item-has-children:hover > a:after {
           			border-bottom-color: ' . esc_attr( $color ) . ';
           		}
           	}
            ';
    wp_add_inline_style( 'magic-blog-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'magic_blog_custom_color_scheme' );

// Add auto p to the palces where get_the_excerpt is being called.
add_filter( 'get_the_excerpt', 'wpautop' );