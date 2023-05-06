<?php 
// Customizer tabs
function startkit_info_customize_register( $wp_customize ) {
	if ( class_exists( 'Cleverfox_Customize_Control_Tabs' ) ) {
		// Pricing Tables Tabs
		$wp_customize->add_setting(
			'startkit_info_tabs', array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			new Cleverfox_Customize_Control_Tabs(
				$wp_customize, 'startkit_info_tabs', array(
					'section' => 'info_setting',
					'tabs' => array(
						'general' => array(
							'nicename' => esc_html__( 'Settings', 'startkit' ),
							'icon' => 'cogs',
							'controls' => array(
								'hide_show_info',
								
							),
						),
						'first' => array(
							'nicename' => esc_html__( 'First', 'startkit' ),
							'icon' => 'info',
							'controls' => array(
								'info_icons',
								'info_title',
								'info_description',
							),
						),
						'second' => array(
							'nicename' => esc_html__( 'Second', 'startkit' ),
							'icon' => 'info',
							'controls' => array(
								'info_icons2',
								'info_title2',
								'info_description2',
							),
						),
						'third' => array(
							'nicename' => esc_html__( 'Third', 'startkit' ),
							'icon' => 'info',
							'controls' => array(
								'info_icons3',
								'info_title3',
								'info_description3',	
							),
						),
					),
				)
			)
		);
	}
}
add_action( 'customize_register', 'startkit_info_customize_register' );

// Customizer tabs
function startkit_blog_customize_register( $wp_customize ) {
	if ( class_exists( 'Cleverfox_Customize_Control_Tabs' ) ) {
		// Pricing Tables Tabs
		$wp_customize->add_setting(
			'startkit_blog_tabs', array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			new Cleverfox_Customize_Control_Tabs(
				$wp_customize, 'startkit_blog_tabs', array(
					'section' => 'blog_setting',
					'tabs' => array(
						'general' => array(
							'nicename' => esc_html__( 'Settings', 'startkit' ),
							'icon' => 'cogs',
							'controls' => array(
								'hide_show_blog',
							),
						),
						'first' => array(
							'nicename' => esc_html__( 'Header', 'startkit' ),
							'icon' => 'header',
							'controls' => array(
								'blog_title',
								'blog_description',	
							),
						),
						'Second' => array(
							'nicename' => esc_html__( 'Content', 'startkit' ),
							'icon' => 'info',
							'controls' => array(
								'blog_display_num',
							),
						),
					),
				)
			)
		);
	}
}
add_action( 'customize_register', 'startkit_blog_customize_register' );
?>