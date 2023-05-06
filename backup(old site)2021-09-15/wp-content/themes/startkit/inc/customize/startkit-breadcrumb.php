<?php
function startkit_breadcrumb_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Breadcrumb Settings Panel
	=========================================*/
	$wp_customize->add_panel( 
		'breadcrumb_setting', 
		array(
			'priority'      => 129,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Page breadcrumbs', 'startkit'),
		) 
	);
	/*=========================================
	Background Section
	=========================================*/ 
	$wp_customize->add_section(
        'breadcrumb_design',
        array(
        	'priority'      => 1,
            'title' 		=> esc_html__('Settings','startkit'),
            'description' 	=>'',
			'panel'  		=> 'breadcrumb_setting',
		)
    );
	
	$wp_customize->add_setting( 
		'hide_show_breadcrumb' , 
			array(
			'default' => esc_html__( '1', 'startkit' ),
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	
	$wp_customize->add_control( new Startkit_Customizer_Toggle_Control( $wp_customize, 
	'hide_show_breadcrumb', 
		array(
			'label'	      => esc_html__( 'Hide/Show breadcrumbs', 'startkit' ),
			'section'     => 'breadcrumb_design',
			'settings'    => 'hide_show_breadcrumb',
			'type'        => 'ios', // light, ios, flat
		) 
	));
	
	$wp_customize->add_section(
        'breadcrumb_background',
        array(
        	'priority'      => 2,
            'title' 		=> esc_html__('Background','startkit'),
            'description' 	=>'',
			'panel'  		=> 'breadcrumb_setting',
		)
    );
	
	// Background Image // 
    $wp_customize->add_setting( 
    	'breadcrumb_background_setting' , 
    	array(
			'default' 			=> get_template_directory_uri() .'/images/breadcumb-bg.jpg',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'startkit_sanitize_url',	
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'breadcrumb_background_setting' ,
		array(
			'label'          => esc_html__( 'Background Image', 'startkit' ),
			'section'        => 'breadcrumb_background',
			'settings'   	 => 'breadcrumb_background_setting',
		) 
	));
}
add_action( 'customize_register', 'startkit_breadcrumb_setting' );
?>