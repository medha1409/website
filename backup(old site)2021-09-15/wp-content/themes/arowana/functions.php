<?php
function arowana_css() {
	$parent_style = 'startkit-parent-style';
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'arowana-style', get_stylesheet_uri(), array( $parent_style ));
	
	wp_enqueue_style('arowana-color-default',get_stylesheet_directory_uri() .'/css/colors/default.css');
	wp_dequeue_style('startkit-color-default');
	
	wp_enqueue_style('arowana-responsive',get_stylesheet_directory_uri().'/css/responsive.css');
	wp_dequeue_style('startkit-responsive');

}
add_action( 'wp_enqueue_scripts', 'arowana_css',999);
   	

function arowana_setup()	{	
	add_editor_style( array( 'css/editor-style.css', arowana_google_font() ) );
}
add_action( 'after_setup_theme', 'arowana_setup' );
	
/**
 * Register Google fonts for StartBiz.
 */
function arowana_google_font() {
	
   $get_fonts_url = '';
		
    $font_families = array();
 
	$font_families = array('Open Sans:300,400,600,700,800', 'Raleway:400,700');
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $get_fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

    return $get_fonts_url;
}

function arowana_scripts_styles() {
    wp_enqueue_style( 'arowana-fonts', arowana_google_font(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'arowana_scripts_styles' );