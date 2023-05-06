<?php
/**
 *
 * @package Indigo Lite
 */

/**
 * Setup the WordPress core custom header feature.
 */
function indigo_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'indigo_custom_header_args', array(
		'width'         => 2000,
		'height'        => 1000,
		'uploads'       => true,
		'default-text-color'     => '404040',
		'wp-head-callback'       => 'indigo_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'indigo_custom_header_setup' );

if ( ! function_exists( 'indigo_header_style' ) ) :
        function indigo_header_style() {
                wp_enqueue_style( 'indigo-style', get_stylesheet_uri() );
                $header_text_color = get_header_textcolor();
                $position = "absolute";
                $clip ="rect(1px, 1px, 1px, 1px)";
                if ( ! display_header_text() ) {
                        $custom_css = '.site-title, .site-description {
                                position: '.$position.';
                                clip: '.$clip.'; 
                        }';
                } else{

                        $custom_css = 'h1.site-title, h2.site-description  {
                                color: #' . $header_text_color . ';                     
                        }';
                }
                wp_add_inline_style( 'indigo-style', $custom_css );
        }
        add_action( 'wp_enqueue_scripts', 'indigo_header_style' );

endif;