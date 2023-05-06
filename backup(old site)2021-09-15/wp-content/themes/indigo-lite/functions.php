<?php
/**
 * Themes functions and definitions
 *
 * @package Indigo Lite
 */
function indigo_setup() {
	global $content_width;
		if ( ! isset( $content_width ) ){
      		$content_width = 990;
		}
	load_theme_textdomain( 'indigo-lite', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo');
	add_theme_support( 'customize-selective-refresh-widgets' );
	register_nav_menus( array(
			'main-menu' => esc_html__( 'Main Menu', 'indigo-lite' ),
			'social' 	=> esc_html__( 'Social Menu', 'indigo-lite' )
		) );
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff',
	) );
	add_theme_support( 'post-thumbnails' );
	add_image_size('indigo-slidethumb', 2000, 600, true);
	add_image_size('indigo-blogthumb', 700, 350, true);
}
add_action( 'after_setup_theme', 'indigo_setup' );

function indigo_widgets_init() {
	
	register_sidebar( array(
		'name' => esc_html__( 'Footer Widgets', 'indigo-lite' ),
		'id' => 'sidebar-2',
		'description' => esc_html__( 'Footer widgets, drag and drop widgets from the left', 'indigo-lite' ),
		'before_widget' => '<div id="%1$s" class="widgets">',
      	'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );
	
	register_sidebar( array(
		'name' => esc_html__( 'Right Sidebar', 'indigo-lite' ),
		'id' => 'sidebar-1',
		'description' => esc_html__( 'Right sidebar visible in all pages, drag and drop widgets from the left', 'indigo-lite' ),
		'before_widget' => '<div id="%1$s" class="widgets">',
      	'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );
}
add_action( 'widgets_init', 'indigo_widgets_init' );

add_filter('widget_text', 'do_shortcode');

/**
 * Register Open Sans Google fonts for Indigo.
 *
 * @return string
 */
function indigo_open_sans_font_url() {
	$open_sans_font_url = '';

	/* translators: If there are characters in your language that are not supported
	 * by Open Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'indigo-lite' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language,
		 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'indigo-lite' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		} elseif ( 'greek' == $subset ) {
			$subsets .= ',greek,greek-ext';
		} elseif ( 'vietnamese' == $subset ) {
			$subsets .= ',vietnamese';
		}

		$query_args = array(
			'family' => urlencode( 'Open Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' ),
			'subset' => urlencode( $subsets ),
		);

		$open_sans_font_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $open_sans_font_url;
}

function indigo_scripts_styles() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	if (!is_admin()) {
		wp_enqueue_script( 'indigo-superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'indigo-mobilemenu', get_template_directory_uri() . '/js/reaktion.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'indigo-header', get_template_directory_uri() . '/js/headroom.js', array( ), '', true );
		wp_enqueue_script( 'indigo-responsive-videos', get_template_directory_uri() . '/js/responsive-videos.js', array( 'jquery' ), '', true );
		wp_enqueue_style( 'indigo-open-sans', indigo_open_sans_font_url(), array(), null );
		wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.3.1' );
		wp_enqueue_style( 'indigo-style', get_stylesheet_uri());
	}
}
add_action( 'wp_enqueue_scripts', 'indigo_scripts_styles' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

