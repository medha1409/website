<?php
/**
 * Moral Theme Customizer
 *
 * @package Moral
 */

/**
 * Get all the default values of the theme mods.
 */
function magic_blog_get_default_mods() {
	$magic_blog_default_mods = array(

		'magic_blog_about_btn_txt' => esc_html__( 'Know More', 'magic-blog' ),
		'magic_blog_trending_btn_text' => esc_html__( 'Start Shopping', 'magic-blog' ),


		// Sliders
		'magic_blog_slider_custom_content' => esc_html__( 'We carve design in most  possible beautiful way.', 'magic-blog' ),
		'magic_blog_slider_custom_btn' => esc_html__( 'Know More', 'magic-blog' ),

		// Blog section
		'magic_blog_blog_section_title' => esc_html__( 'Stay Updated. Happening Now.', 'magic-blog' ),
		'magic_blog_blog_section_sub_title' => esc_html__( 'Latest Blog', 'magic-blog' ),

		
		// Homepage sortable sections
		'magic_blog_sort_home_sections' => array( 'slider', 'about', 'latest-posts' ),
	);

	return apply_filters( 'magic_blog_default_mods', $magic_blog_default_mods );
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function magic_blog_customize_register( $wp_customize ) {
	/**
	 * Separator custom control
	 *
	 * @version 1.0.0
	 * @since  1.0.0
	 */
	class Magic_Blog_Separator_Custom_Control extends WP_Customize_Control {
		/**
		 * Control type
		 *
		 * @var string
		 */
		public $type = 'magic-blog-separator';
		/**
		 * Control method
		 *
		 * @since 1.0.0
		 */
		public function render_content() {
			?>
			<p><hr style="border-color: #222; opacity: 0.2;"></p>
			<?php
		}
	}

	/**
	 * The radio image customize control extends the WP_Customize_Control class.  This class allows
	 * developers to create a list of image radio inputs.
	 *
	 * Note, the `$choices` array is slightly different than normal and should be in the form of
	 * `array(
		 *	$value => array( 'color' => $color_value ),
		 *	$value => array( 'color' => $color_value ),
	 * )`
	 *
	 */


	class Magic_Blog_Customize_Control_Sort_Sections extends WP_Customize_Control {

	  	/**
	   	* Control Type
	   	*/
	  	public $type = 'sortable';
	  
		/**
		* Add custom parameters to pass to the JS via JSON.
		*
		* @access public
		* @return void
		*/
	  	public function to_json() {
		  	parent::to_json();

	    	$choices = $this->choices;
	      	$choices = array_filter( array_merge( array_flip( $this->value() ), $choices ) );
		  	$this->json['choices'] = $choices;
		  	$this->json['link']    = $this->get_link();
		  	$this->json['value']   = $this->value();
		  	$this->json['id']      = $this->id;
	  	}

	  	/**
	   	* Render Settings
	   	*/
	  	public function content_template() { ?>
		  	<# if ( ! data.choices ) {
		  		return;
		  	} #>

		    <# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>

		    <# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

		    <ul class="magic-blog-sortable-list">

		      	<# _.each( data.choices, function( args, choice ) { #>

		        <li>
		            <input class="magic-blog-sortable-input sortable-hideme" name="{{choice}}" type="hidden"  value="{{ choice }}" />
		            <span class ="menu-item-handle sortable-span">{{args.name}}</span>
		          <i title="<?php esc_html_e( 'Drag and Move', 'magic-blog' );?>" class="dashicons dashicons-menu magic-blog-drag-handle"></i>
		          <i title="<?php esc_html_e( 'Edit', 'magic-blog' );?>" class="dashicons dashicons-edit magic-blog-edit" data-jump="{{args.section_id}}"></i>
		        </li>

		        <# } ) #>

		        <li class="sortable-hideme">
		          <input class="magic-blog-sortable-value" {{{ data.link }}} value="{{data.value}}" />
		        </li>

		    </ul>
	  	<?php
	  	}
	}

	$wp_customize->register_control_type( 'Magic_Blog_Customize_Control_Sort_Sections' );

	$default = magic_blog_get_default_mods();

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'magic_blog_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'magic_blog_customize_partial_blogdescription',
		) );
	}

	/**
	 *
	 * 
	 * Header panel
	 *
	 * 
	 */
	// Header panel
	$wp_customize->add_panel(
		'magic_blog_header_panel',
		array(
			'title' => esc_html__( 'Header', 'magic-blog' ),
			'priority' => 100
		)
	);

	$wp_customize->get_section( 'title_tagline' )->panel         = 'magic_blog_header_panel';
	$wp_customize->get_section( 'header_image' )->panel         = 'magic_blog_header_panel';

	// Header text display setting
	$wp_customize->add_setting(	
		'magic_blog_header_text_display',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_checkbox',
			'default' => true,
			'transport'	=> 'postMessage',
		)
	); 

	$wp_customize->add_control(
		'magic_blog_header_text_display',
		array(
			'section'		=> 'title_tagline',
			'type'			=> 'checkbox',
			'label'			=> esc_html__( 'Display Site Title and Tagline', 'magic-blog' ),
		)
	);

	// Header section
	$wp_customize->add_section(
		'magic_blog_header_section',
		array(
			'title' => esc_html__( 'Header', 'magic-blog' ),
			'panel' => 'magic_blog_header_panel',
		)
	);

	// Header search form settings
	$wp_customize->add_setting(
		'magic_blog_show_search',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_checkbox',
			'default' => true
		)
	);

	$wp_customize->add_control(
		'magic_blog_show_search',
		array(
			'section'		=> 'magic_blog_header_section',
			'label'			=> esc_html__( 'Show search.', 'magic-blog' ),
			'type'			=> 'checkbox',
		)
	);

	/**
	 *
	 * 
	 * Home sections panel
	 *
	 * 
	 */
	// Home sections panel
	$wp_customize->add_panel(
		'magic_blog_home_panel',
		array(
			'title' => esc_html__( 'Homepage', 'magic-blog' ),
			'priority' => 105
		)
	);

	$wp_customize->get_section( 'static_front_page' )->panel         = 'magic_blog_home_panel';

	// Homepage sort section
	$wp_customize->add_section(
		'magic_blog_homepage_section_sort',
		array(
			'title' => esc_html__( 'Sort sections', 'magic-blog' ),
			'panel' => 'magic_blog_home_panel',
		)
	);

	// Homepage sections sortable.
	$wp_customize->add_setting(	
		'magic_blog_sort_home_sections',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_sort',
			'default'	=> $default['magic_blog_sort_home_sections'],
		)
	);

	$wp_customize->add_control( 
		new Magic_Blog_Customize_Control_Sort_Sections( 
		$wp_customize,
		'magic_blog_sort_home_sections',
			array(
				'section'		=> 'magic_blog_homepage_section_sort',
				'label'			=> esc_html__( 'Sort sections', 'magic-blog' ),
				'choices'  => array(
		            'slider'    => array(
		            	'name' => esc_html__( 'Slider', 'magic-blog' ),
		            	'section_id' => 'magic_blog_slider'
		            ), 

		            'about'    => array(
		            	'name' => esc_html__( 'About', 'magic-blog' ),
		            	'section_id' => 'magic_blog_about'
		            ),
		          
		            'latest-posts'    => array(
		            	'name' => esc_html__( 'Blog Section', 'magic-blog' ),
		            	'section_id' => 'magic_blog_blog_section'
		            ), 
		        ),
			)
		)
	);

	// Your latest posts title setting
	$wp_customize->add_setting(	
		'magic_blog_your_latest_posts_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => esc_html__( 'Blogs', 'magic-blog' ),
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'magic_blog_your_latest_posts_title',
		array(
			'section'		=> 'static_front_page',
			'label'			=> esc_html__( 'Title:', 'magic-blog' ),
			'active_callback' => 'magic_blog_is_latest_posts'
		)
	);

	$wp_customize->selective_refresh->add_partial( 
		'magic_blog_your_latest_posts_title', 
		array(
	        'selector'            => '.home.blog #page-header .page-title',
			'render_callback'     => 'magic_blog_your_latest_posts_partial_title',
    	) 
    );

	/**
	 * Slider section
	 */
	// Slider section
	$wp_customize->add_section(
		'magic_blog_slider',
		array(
			'title' => esc_html__( 'Slider', 'magic-blog' ),
			'panel' => 'magic_blog_home_panel',
		)
	);

	// Slider enable settings
	$wp_customize->add_setting(
		'magic_blog_slider',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_select',
			'default' => 'post'
		)
	);

	$wp_customize->add_control(
		'magic_blog_slider',
		array(
			'section'		=> 'magic_blog_slider',
			'label'			=> esc_html__( 'Content type:', 'magic-blog' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'magic-blog' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'magic-blog' ),
					'post' => esc_html__( 'Post', 'magic-blog' ),
			 	)
		)
	);

	// Slider number setting
	$wp_customize->add_setting(
		'magic_blog_slider_num',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_number_range',
			'default' => 3,
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'magic_blog_slider_num',
		array(
			'section'		=> 'magic_blog_slider',
			'label'			=> esc_html__( 'Number of slider:', 'magic-blog' ),
			'description'			=> esc_html__( 'Min: 1 | Max: 3', 'magic-blog' ),
			'active_callback' => 'magic_blog_if_slider_not_disabled',
			'type'			=> 'number',
			'input_attrs'	=> array( 'min' => 1, 'max' => 3 ),
		)
	);

	// Slider number separator setting
	$wp_customize->add_setting(
		'magic_blog_slider_num_separator',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_html',
		)
	);

	$wp_customize->add_control(
		new Magic_Blog_Separator_Custom_Control( 
		$wp_customize,
		'magic_blog_slider_num_separator',
			array(
				'section'		=> 'magic_blog_slider',
				'active_callback' => 'magic_blog_if_slider_not_disabled',
				'type'			=> 'magic-blog-separator',
			)
		)
	);

	$slider_num = get_theme_mod( 'magic_blog_slider_num', 3 );
	for ( $i=1; $i <= $slider_num; $i++ ) { 

		// Slider post setting
		$wp_customize->add_setting(
			'magic_blog_slider_post_' . $i,
			array(
				'sanitize_callback' => 'magic_blog_sanitize_dropdown_pages',
			)
		);

		$wp_customize->add_control(
			'magic_blog_slider_post_' . $i,
			array(
				'section'		=> 'magic_blog_slider',
				'label'			=> esc_html__( 'Post ', 'magic-blog' ) . $i,
				'active_callback' => 'magic_blog_if_slider_post',
				'type'			=> 'select',
				'choices'		=> magic_blog_get_post_choices(),
			)
		);
		
		// Slider custom separator setting
		$wp_customize->add_setting(
			'magic_blog_slider_custom_separator_' . $i,
			array(
				'sanitize_callback' => 'magic_blog_sanitize_html',
			)
		);

		$wp_customize->add_control(
			new Magic_Blog_Separator_Custom_Control( 
			$wp_customize,
			'magic_blog_slider_custom_separator_' . $i,
				array(
					'section'		=> 'magic_blog_slider',
					'active_callback' => 'magic_blog_if_slider_not_disabled',
					'type'			=> 'magic-blog-separator',
				)
			)
		);
	}

	/**
	 * About section
	 */
	// About section
	$wp_customize->add_section(
		'magic_blog_about',
		array(
			'title' => esc_html__( 'About', 'magic-blog' ),
			'panel' => 'magic_blog_home_panel',
		)
	);

	// About enable settings
	$wp_customize->add_setting(
		'magic_blog_about',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_select',
			'default' => 'page'
		)
	);

	$wp_customize->add_control(
		'magic_blog_about',
		array(
			'section'		=> 'magic_blog_about',
			'label'			=> esc_html__( 'Content type:', 'magic-blog' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'magic-blog' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'magic-blog' ),
					'page' => esc_html__( 'Page', 'magic-blog' ),
			 	)
		)
	);

	// About page setting
	$wp_customize->add_setting(
		'magic_blog_about_page',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_dropdown_pages',
			'default' => 0,
		)
	);

	$wp_customize->add_control(
		'magic_blog_about_page',
		array(
			'section'		=> 'magic_blog_about',
			'label'			=> esc_html__( 'Page:', 'magic-blog' ),
			'type'			=> 'dropdown-pages',
			'active_callback' => 'magic_blog_if_about_page'
		)
	);

	// About image setting
	$wp_customize->add_setting(
		'magic_blog_about_signature',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_image',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'magic_blog_about_signature',
			array(
				'section'		=> 'magic_blog_about',
				'label'			=> esc_html__( 'Signature Image:', 'magic-blog' ),
				'description'			=> esc_html__( 'Recommended Image size 415 X 90 ', 'magic-blog' ),
				'active_callback' => 'magic_blog_if_about_enabled',
			)
		)
	);

	// Trending enable settings
	$wp_customize->add_setting(
		'magic_blog_trending',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_select',
			'default' => 'page'
		)
	);

	$wp_customize->add_control(
		'magic_blog_trending',
		array(
			'section'		=> 'magic_blog_about',
			'label'			=> esc_html__( 'Trending Content type:', 'magic-blog' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'magic-blog' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'magic-blog' ),
					'page' => esc_html__( 'Page', 'magic-blog' ),

			 	)
		)
	);

	// Trending page setting
	$wp_customize->add_setting(
		'magic_blog_trending_page',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_dropdown_pages',
			'default' => 0,
		)
	);

	$wp_customize->add_control(
		'magic_blog_trending_page',
		array(
			'section'		=> 'magic_blog_about',
			'label'			=> esc_html__( 'Page:', 'magic-blog' ),
			'type'			=> 'dropdown-pages',
			'active_callback' => 'magic_blog_if_trending_page'
		)
	);

    // Trending title setting
	$wp_customize->add_setting(
		'magic_blog_trending_btn_text',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => $default['magic_blog_trending_btn_text'],
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'magic_blog_trending_btn_text',
		array(
			'section'		=> 'magic_blog_about',
			'label'			=> esc_html__( 'Trending button Text:', 'magic-blog' ),
			'active_callback' => 'magic_blog_if_trending_enabled'
		)
	);

	$wp_customize->selective_refresh->add_partial( 
		'magic_blog_trending_btn_text', 
		array(
	        'selector'            => '#about-us .trending .btn',
			'render_callback'     => 'magic_blog_trending_partial_btn_text',
    	) 
    );

	/**
	 * Blog section section
	 */
	// Blog section section
	$wp_customize->add_section(
		'magic_blog_blog_section',
		array(
			'title' => esc_html__( 'Blog section', 'magic-blog' ),
			'panel' => 'magic_blog_home_panel',
		)
	);

	// Blog section enable settings
	$wp_customize->add_setting(
		'magic_blog_blog_section',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_select',
			'default' => 'recent-posts'
		)
	);

	$wp_customize->add_control(
		'magic_blog_blog_section',
		array(
			'section'		=> 'magic_blog_blog_section',
			'label'			=> esc_html__( 'Content type:', 'magic-blog' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'magic-blog' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'magic-blog' ),
					'recent-posts' => esc_html__( 'Recent Posts', 'magic-blog' ),
					'cat' => esc_html__( 'Category', 'magic-blog' ),
			 	)
		)
	);

	// Blog section title setting
	$wp_customize->add_setting(
		'magic_blog_blog_section_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => $default['magic_blog_blog_section_title'],
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'magic_blog_blog_section_title',
		array(
			'section'		=> 'magic_blog_blog_section',
			'label'			=> esc_html__( 'Title:', 'magic-blog' ),
			'active_callback' => 'magic_blog_if_blog_section_not_disabled'
		)
	);

	$wp_customize->selective_refresh->add_partial( 
		'magic_blog_blog_section_title', 
		array(
	        'selector'            => '#latest-posts .section-title',
			'render_callback'     => 'magic_blog_blog_section_partial_title',
    	) 
    );

   

    // Blog section number setting
	$wp_customize->add_setting(
		'magic_blog_blog_section_num',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_number_range',
			'default' => 5,
			// 'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'magic_blog_blog_section_num',
		array(
			'section'		=> 'magic_blog_blog_section',
			'label'			=> esc_html__( 'Number of posts:', 'magic-blog' ),
			'description'			=> esc_html__( 'Min: 1 | Max: 5', 'magic-blog' ),
			'active_callback' => 'magic_blog_if_blog_section_not_disabled',
			'type'			=> 'number',
			'input_attrs'	=> array( 'min' => 1, 'max' => 5 ),
		)
	);

	// Blog section category setting
	$wp_customize->add_setting(
		'magic_blog_blog_section_cat',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'magic_blog_blog_section_cat',
		array(
			'section'		=> 'magic_blog_blog_section',
			'label'			=> esc_html__( 'Category:', 'magic-blog' ),
			'description'			=> esc_html__( 'The button will be linked to the selected category\'s archive link automatically.', 'magic-blog' ),
			'active_callback' => 'magic_blog_if_blog_section_cat',
			'type'			=> 'select',
			'choices'		=> magic_blog_get_post_cat_choices(),
		)
	);

	/**
	 *
	 * General settings panel
	 * 
	 */
	// General settings panel
	$wp_customize->add_panel(
		'magic_blog_general_panel',
		array(
			'title' => esc_html__( 'Advanced Settings', 'magic-blog' ),
			'priority' => 107
		)
	);

	$wp_customize->get_section( 'colors' )->panel         = 'magic_blog_general_panel';
	
	// Header title color setting
	$wp_customize->add_setting(	
		'magic_blog_header_title_color',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_hex_color',
			'default' => '#ff8737',
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control( 
		$wp_customize,
			'magic_blog_header_title_color',
			array(
				'section'		=> 'colors',
				'label'			=> esc_html__( 'Site title Color:', 'magic-blog' ),
			)
		)
	);

	// Header tagline color setting
	$wp_customize->add_setting(	
		'magic_blog_header_tagline',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_hex_color',
			'default' => '#929292',
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control( 
		$wp_customize,
			'magic_blog_header_tagline',
			array(
				'section'		=> 'colors',
				'label'			=> esc_html__( 'Site tagline Color:', 'magic-blog' ),
			)
		)
	);
	

	$wp_customize->get_section( 'background_image' )->panel         = 'magic_blog_general_panel';
	$wp_customize->get_section( 'custom_css' )->panel         = 'magic_blog_general_panel';

	/**
	 * General settings
	 */
	// General settings
	$wp_customize->add_section(
		'magic_blog_general_section',
		array(
			'title' => esc_html__( 'General', 'magic-blog' ),
			'panel' => 'magic_blog_general_panel',
		)
	);


	// Breadcrumb enable setting
	$wp_customize->add_setting(
		'magic_blog_breadcrumb_enable',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'magic_blog_breadcrumb_enable',
		array(
			'section'		=> 'magic_blog_general_section',
			'label'			=> esc_html__( 'Enable breadcrumb.', 'magic-blog' ),
			'type'			=> 'checkbox',
		)
	);

	// Backtop enable setting
	$wp_customize->add_setting(
		'magic_blog_back_to_top_enable',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'magic_blog_back_to_top_enable',
		array(
			'section'		=> 'magic_blog_general_section',
			'label'			=> esc_html__( 'Enable Scroll up.', 'magic-blog' ),
			'type'			=> 'checkbox',
		)
	);


	/**
	 * Menu setting section 
	 */
	// Menu setting section 
	$wp_customize->add_section(
		'magic_blog_menu_settings',
		array(
			'title' => esc_html__( 'Menu Setting', 'magic-blog' ),
			'panel' => 'magic_blog_general_panel',
		)
	);

	// Pagination enable setting
	$wp_customize->add_setting(
		'magic_blog_enable_menu_transparent',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'magic_blog_enable_menu_transparent',
		array(
			'section'		=> 'magic_blog_menu_settings',
			'label'			=> esc_html__( 'Enable Menu Transparent.', 'magic-blog' ),
			'type'			=> 'checkbox',
		)
	);


	/**
	 * Global Layout
	 */
	// Global Layout
	$wp_customize->add_section(
		'magic_blog_global_layout',
		array(
			'title' => esc_html__( 'Global Layout', 'magic-blog' ),
			'panel' => 'magic_blog_general_panel',
		)
	);

	// Global archive layout setting
	$wp_customize->add_setting(
		'magic_blog_archive_sidebar',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_select',
			'default' => 'right',
		)
	);

	$wp_customize->add_control(
		'magic_blog_archive_sidebar',
		array(
			'section'		=> 'magic_blog_global_layout',
			'label'			=> esc_html__( 'Archive Sidebar', 'magic-blog' ),
			'description'			=> esc_html__( 'This option works on all archive pages like: 404, search, date, category, "Your latest posts" and so on.', 'magic-blog' ),
			'type'			=> 'radio',
			'choices'		=> array( 
				'right' => esc_html__( 'Right', 'magic-blog' ), 
				'no' => esc_html__( 'No Sidebar', 'magic-blog' ), 
			),
		)
	);

	// Global page layout setting
	$wp_customize->add_setting(
		'magic_blog_global_page_layout',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_select',
			'default' => 'right',
		)
	);

	$wp_customize->add_control(
		'magic_blog_global_page_layout',
		array(
			'section'		=> 'magic_blog_global_layout',
			'label'			=> esc_html__( 'Global page sidebar', 'magic-blog' ),
			'description'			=> esc_html__( 'This option works only on single pages including "Posts page". This setting can be overridden for single page from the metabox too.', 'magic-blog' ),
			'type'			=> 'radio',
			'choices'		=> array( 
				'right' => esc_html__( 'Right', 'magic-blog' ), 
				'no' => esc_html__( 'No Sidebar', 'magic-blog' ), 
			),
		)
	);

	// Global post layout setting
	$wp_customize->add_setting(
		'magic_blog_global_post_layout',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_select',
			'default' => 'right',
		)
	);

	$wp_customize->add_control(
		'magic_blog_global_post_layout',
		array(
			'section'		=> 'magic_blog_global_layout',
			'label'			=> esc_html__( 'Global post sidebar', 'magic-blog' ),
			'description'			=> esc_html__( 'This option works only on single posts. This setting can be overridden for single post from the metabox too.', 'magic-blog' ),
			'type'			=> 'radio',
			'choices'		=> array( 
				'right' => esc_html__( 'Right', 'magic-blog' ), 
				'no' => esc_html__( 'No Sidebar', 'magic-blog' ), 
			),
		)
	);

	/**
	 * Blog/Archive section 
	 */
	// Blog/Archive section 
	$wp_customize->add_section(
		'magic_blog_archive_settings',
		array(
			'title' => esc_html__( 'Archive/Blog', 'magic-blog' ),
			'description' => esc_html__( 'Settings for archive pages including blog page too.', 'magic-blog' ),
			'panel' => 'magic_blog_general_panel',
		)
	);

	// Archive excerpt setting
	$wp_customize->add_setting(
		'magic_blog_archive_excerpt',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => esc_html__( 'View the post', 'magic-blog' ),
		)
	);

	$wp_customize->add_control(
		'magic_blog_archive_excerpt',
		array(
			'section'		=> 'magic_blog_archive_settings',
			'label'			=> esc_html__( 'Excerpt more text:', 'magic-blog' ),
		)
	);

	// Archive excerpt length setting
	$wp_customize->add_setting(
		'magic_blog_archive_excerpt_length',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_number_range',
			'default' => 60,
		)
	);

	$wp_customize->add_control(
		'magic_blog_archive_excerpt_length',
		array(
			'section'		=> 'magic_blog_archive_settings',
			'label'			=> esc_html__( 'Excerpt more length:', 'magic-blog' ),
			'type'			=> 'number',
			'input_attrs'   => array( 'min' => 5 ),
		)
	);

	// Pagination type setting
	$wp_customize->add_setting(
		'magic_blog_archive_pagination_type',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_select',
			'default' => 'numeric',
		)
	);

	$archive_pagination_description = '';
	$archive_pagination_choices = array( 
				'disable' => esc_html__( '--Disable--', 'magic-blog' ),
				'numeric' => esc_html__( 'Numeric', 'magic-blog' ),
				'older_newer' => esc_html__( 'Older / Newer', 'magic-blog' ),
			);
	$wp_customize->add_control(
		'magic_blog_archive_pagination_type',
		array(
			'section'		=> 'magic_blog_archive_settings',
			'label'			=> esc_html__( 'Pagination type:', 'magic-blog' ),
			'description'			=>  $archive_pagination_description,
			'type'			=> 'select',
			'choices'		=> $archive_pagination_choices,
		)
	);

	/**
	 * Single setting section 
	 */
	// Single setting section 
	$wp_customize->add_section(
		'magic_blog_single_settings',
		array(
			'title' => esc_html__( 'Single Posts', 'magic-blog' ),
			'description' => esc_html__( 'Settings for all single posts.', 'magic-blog' ),
			'panel' => 'magic_blog_general_panel',
		)
	);

	// Pagination enable setting
	$wp_customize->add_setting(
		'magic_blog_enable_single_pagination',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'magic_blog_enable_single_pagination',
		array(
			'section'		=> 'magic_blog_single_settings',
			'label'			=> esc_html__( 'Enable pagination.', 'magic-blog' ),
			'type'			=> 'checkbox',
		)
	);

	/**
	 * Single pages setting section 
	 */
	// Single pages setting section 
	$wp_customize->add_section(
		'magic_blog_single_page_settings',
		array(
			'title' => esc_html__( 'Single Pages', 'magic-blog' ),
			'description' => esc_html__( 'Settings for all single pages.', 'magic-blog' ),
			'panel' => 'magic_blog_general_panel',
		)
	);

	// Pagination enable setting
	$wp_customize->add_setting(
		'magic_blog_enable_single_page_pagination',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_checkbox',
			'default' => false,
		)
	);

	$wp_customize->add_control(
		'magic_blog_enable_single_page_pagination',
		array(
			'section'		=> 'magic_blog_single_page_settings',
			'label'			=> esc_html__( 'Enable pagination.', 'magic-blog' ),
			'type'			=> 'checkbox',
		)
	);

	/**
	 * Reset all settings
	 */
	// Reset settings section
	$wp_customize->add_section(
		'magic_blog_reset_sections',
		array(
			'title' => esc_html__( 'Reset all', 'magic-blog' ),
			'description' => esc_html__( 'Reset all settings to default.', 'magic-blog' ),
			'panel' => 'magic_blog_general_panel',
		)
	);

	// Reset sortable order setting
	$wp_customize->add_setting(
		'magic_blog_reset_settings',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_checkbox',
			'default' => false,
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'magic_blog_reset_settings',
		array(
			'section'		=> 'magic_blog_reset_sections',
			'label'			=> esc_html__( 'Reset all settings?', 'magic-blog' ),
			'type'			=> 'checkbox',
		)
	);

	/**
	 *
	 *
	 * Footer copyright
	 *
	 *
	 */
	// Footer copyright
	$wp_customize->add_section(
		'magic_blog_footer_section',
		array(
			'title' => esc_html__( 'Footer', 'magic-blog' ),
			'priority' => 106,
			// 'panel' => 'magic_blog_general_panel',
		)
	);

	// Footer social menu enable setting
	$wp_customize->add_setting(
		'magic_blog_enable_footer_social_menu',
		array(
			'sanitize_callback' => 'magic_blog_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'magic_blog_enable_footer_social_menu',
		array(
			'section'		=> 'magic_blog_footer_section',
			'label'			=> esc_html__( 'Enable social menu.', 'magic-blog' ),
			'type'			=> 'checkbox',
		)
	);

}
add_action( 'customize_register', 'magic_blog_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function magic_blog_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function magic_blog_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function magic_blog_customize_preview_js() {
	wp_enqueue_script( 'magic-blog-customizer', get_theme_file_uri( '/assets/js/customizer.js' ), array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'magic_blog_customize_preview_js' );

/**
 * Binds JS handlers for Customizer controls.
 */
function magic_blog_customize_control_js() {


	wp_enqueue_style( 'magic-blog-customize-style', get_theme_file_uri( '/assets/css/customize-controls.css' ), array(), '20151215' );

	wp_enqueue_script( 'magic-blog-customize-control', get_theme_file_uri( '/assets/js/customize-control.js' ), array( 'jquery', 'customize-controls' ), '20151215', true );
	$localized_data = array( 
		'refresh_msg' => esc_html__( 'Refresh the page after Save and Publish.', 'magic-blog' ),
		'reset_msg' => esc_html__( 'Warning!!! This will reset all the settings. Refresh the page after Save and Publish to reset all.', 'magic-blog' ),
	);

	wp_localize_script( 'magic-blog-customize-control', 'localized_data', $localized_data );
}
add_action( 'customize_controls_enqueue_scripts', 'magic_blog_customize_control_js' );

/**
 *
 * Sanitization callbacks.
 * 
 */

/**
 * Checkbox sanitization callback example.
 * 
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function magic_blog_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}


/**
 * HEX Color sanitization callback example.
 *
 * - Sanitization: hex_color
 * - Control: text, WP_Customize_Color_Control
 *
 */
function magic_blog_sanitize_hex_color( $hex_color, $setting ) {
	// Sanitize $input as a hex value without the hash prefix.
	$hex_color = sanitize_hex_color( $hex_color );
	
	// If $input is a valid hex value, return it; otherwise, return the default.
	return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
}

/**
 * Image sanitization callback example.
 *
 * Checks the image's file extension and mime type against a whitelist. If they're allowed,
 * send back the filename, otherwise, return the setting default.
 *
 * - Sanitization: image file extension
 * - Control: text, WP_Customize_Image_Control
 */
function magic_blog_sanitize_image( $image, $setting ) {
	/*
	 * Array of valid image file types.
	 *
	 * The array includes image mime types that are included in wp_get_mime_types()
	 */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon',
        'svg'          => 'image/svg+xml'
    );
	// Return an array with file extension and mime_type.
    $file = wp_check_filetype( $image, $mimes );
	// If $image has a valid mime_type, return it; otherwise, return the default.
    return ( $file['ext'] ? $image : $setting->default );
}

/**
 * Select sanitization callback example.
 *
 * - Sanitization: select
 * - Control: select, radio
 */
function magic_blog_sanitize_select( $input, $setting ) {
	
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Drop-down Pages sanitization callback example.
 *
 * - Sanitization: dropdown-pages
 * - Control: dropdown-pages
 * 
 */
function magic_blog_sanitize_dropdown_pages( $page_id, $setting ) {
	// Ensure $input is an absolute integer.
	$page_id = absint( $page_id );
	
	// If $page_id is an ID of a published page, return it; otherwise, return the default.
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

/**
 * Number Range sanitization callback example.
 *
 * - Sanitization: number_range
 * - Control: number, tel
 * 
 */
function magic_blog_sanitize_number_range( $number, $setting ) {
	
	// Ensure input is an absolute integer.
	$number = absint( $number );
	
	// Get the input attributes associated with the setting.
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;
	
	// Get minimum number in the range.
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
	
	// Get maximum number in the range.
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
	
	// Get step.
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
	
	// If the number is within the valid range, return it; otherwise, return the default
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

/**
 * HTML sanitization callback example.
 *
 * - Sanitization: html
 * - Control: text, textarea
 *
 * @param string $html HTML to sanitize.
 * @return string Sanitized HTML.
 */
function magic_blog_sanitize_html( $html ) {
	return wp_filter_post_kses( $html );
}

/**
 * Sortable section sanitization callback example.
 *
 * - Sanitization: sortable section
 * - Control: sortable
 *
 * @param string $input Value to be sanitized.
 * @return array Sanitized values as array.
 */
function magic_blog_sanitize_sort( $input ) {
	// Ensure $input is an array.
	if ( ! is_array( $input ) ){
		$input = explode( ',', $input );
	}

	$output = array_map( 'sanitize_text_field', $input );

	return $output;
}

/**
 *
 * Active callbacks.
 * 
 */

/**
 * Check if the about is enabled
 */
function magic_blog_if_about_enabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'magic_blog_about' )->value();
}

/**
 * Check if the about is page
 */
function magic_blog_if_about_page( $control ) {
	return 'page' === $control->manager->get_setting( 'magic_blog_about' )->value();
}

/**
 * Check if the trending is enabled
 */
function magic_blog_if_trending_enabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'magic_blog_trending' ) ->value();
}

/**
 * Check if the trending is page
 */
function magic_blog_if_trending_page( $control ) {
	return 'page' === $control->manager->get_setting( 'magic_blog_trending' )->value();
}

/**
 * Check if the slider is not disabled
 */
function magic_blog_if_slider_not_disabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'magic_blog_slider' )->value();
}

/**
 * Check if the slider is page
 */
function magic_blog_if_slider_page( $control ) {
	return 'page' === $control->manager->get_setting( 'magic_blog_slider' )->value();
}

/**
 * Check if the slider is post
 */
function magic_blog_if_slider_post( $control ) {
	return 'post' === $control->manager->get_setting( 'magic_blog_slider' )->value();
}

/**
 * Check if the blog section is not disabled
 */
function magic_blog_if_blog_section_not_disabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'magic_blog_blog_section' )->value();
}

/**
 * Check if the blog section is cat
 */
function magic_blog_if_blog_section_cat( $control ) {
	return 'cat' === $control->manager->get_setting( 'magic_blog_blog_section' )->value();
}

/**
 * Check if custom color scheme is enabled
 */
function magic_blog_if_custom_color_scheme( $control ) {
	return 'custom' === $control->manager->get_setting( 'magic_blog_color_scheme' )->value();
}

/**
 * Selective refresh.
 */

/**
 * Selective refresh for about btn text.
 */
function magic_blog_trending_partial_btn_txt() {
	return esc_html( get_theme_mod( 'magic_blog_trending_btn_txt' ) );
}

/**
 * Selective refresh for blog section title.
 */
function magic_blog_blog_section_partial_title() {
	return esc_html( get_theme_mod( 'magic_blog_blog_section_title' ) );
}


/**
 * Selective refresh for your latest posts title.
 */
function magic_blog_your_latest_posts_partial_title() {
	return esc_html( get_theme_mod( 'magic_blog_your_latest_posts_title' ) );
}

