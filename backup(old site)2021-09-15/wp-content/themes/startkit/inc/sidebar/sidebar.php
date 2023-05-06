<?php	
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package startkit
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function startkit_widgets_init() {
	register_sidebar( array(
		'name' => esc_html__( 'Sidebar Widget Area', 'startkit' ),
		'id' => 'sidebar-primary',
		'description' => esc_html__( 'Primary widget area', 'startkit' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );
	
	register_sidebar( array(
		'name' => esc_html__( 'Footer widget  area', 'startkit' ),
		'id' => 'footer-widget-area',
		'description' => esc_html__( 'Footer widget area', 'startkit' ),
		'before_widget' => '<div class="col-lg-3 col-md-6 col-sm-12 mb-lg-0 mb-4"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );
}
add_action( 'widgets_init', 'startkit_widgets_init' );
 
?>