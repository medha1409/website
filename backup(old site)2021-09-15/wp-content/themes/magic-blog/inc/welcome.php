<?php
/**
 * Moral welcome page
 *
 * @package Moral
 */
add_action( 'admin_menu', 'magic_blog_welcome_menu' );

/**
 * Add admin submenu
 */
function magic_blog_welcome_menu() {
	add_theme_page( esc_html__( 'Magic Blog Options', 'magic-blog' ), esc_html__( 'About Magic Blog', 'magic-blog' ), 'manage_options', 'magic-blog-welcome', 'magic_blog_welcome_display' );
}

/**
 * Welcome column loop
 * @param  array  $args [description]
 * @return string  Columns HTML
 */
function magic_blog_get_welcome_columns( $args = array() ) {
	foreach ( $args as $key => $value ) { 
		$target = '';
		if ( $value['new_tab'] ) {
			$target = "_blank";
		}
		?>
		<div class="column">
			<h2 class="magic-blog-postbox-title <?php echo esc_attr( $key ); ?>"><span class="dashicons dashicons-<?php echo esc_attr( $value['icon'] );?>"></span><?php echo esc_html( $value['title'] ); ?></h2>
			<div class="magic-blog-postbox-content">
				<p><?php echo esc_html( $value['desc'] ); ?></p>
				<a target="<?php echo esc_attr( $target ); ?>" class="button button-primary button-hero load-customize hide-if-no-customize" href="<?php echo esc_url( $value['url'] ); ?>"><?php echo esc_html( $value['btn_txt'] ); ?></a>
			</div><!-- .magic-blog-box-content-->
		</div><!-- .column -->
	<?php
	}
}

/**
 * Display admin welcome page.
 */
function magic_blog_welcome_display() {
	if ( ! current_user_can( 'manage_options' ) )  {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'magic-blog' ) );
	}

	$theme_data = wp_get_theme();
	?>
	<div id="magic-blog-themes-wrapper">
		<div id="magic-blog-header-content">
			<h1><?php echo esc_html( $theme_data->get( 'Name' ) ) . esc_html__( '-', 'magic-blog' ) . esc_html( $theme_data->get( 'Version' ) ); ?></h1>
			<p><?php echo esc_html( $theme_data->get( 'Description' ) ); ?></p>
		</div><!-- #magic-blog-header-content -->
		
		<div id="magic-blog-postbox-container">
			<?php 
			$args = array(
				'live-demo' => array(
					'title' => esc_html__( 'View Demo', 'magic-blog' ),
					'desc'	=> esc_html__( 'Woohoo!!! Magic Blog has been installed. Now want to have a peek at how Magic Blog theme would look as set up by the author. Mind that the setup is one of the many usage of the theme, you can create a different setup of the same theme. Just click the button below.', 'magic-blog' ),
					'url' => 'https://demo.moralthemes.com/magic-blog/',
					'new_tab' => true,
					'icon' => 'external',
					'btn_txt' => esc_html__( 'View Demo', 'magic-blog' )
				),
				'demo-importer' => array(
					'title' => esc_html__( 'One Click Demo Import', 'magic-blog' ),
					'desc'	=> esc_html__( 'Liked the demo and want to setup just like the demo? Just import the content and start editing  the content right away. One Click Demo Importer should be installed before the importer works. You are just a click away.', 'magic-blog' ),
					'url' =>  menu_page_url( 'pt-one-click-demo-import', false ),
					'new_tab' => false,
					'icon' => 'upload',
					'btn_txt' => esc_html__( 'Import Demo Content', 'magic-blog' )
				),
				'documentation' => array(
					'title' => esc_html__( 'Documentation', 'magic-blog' ),
					'desc'	=> esc_html__( 'Still getting confused after import? Or wanna start without the demo content. Do not worry!!! Magic Blog Themes provide a detailed documentation about the theme, its setup and other extra tips and tricks.', 'magic-blog' ),
					'icon' => 'list-view',
					'url' => '',
					'new_tab' => true,
					'btn_txt' => esc_html__( 'View Documentation', 'magic-blog' )
				),
				'support' => array(
					'title' => esc_html__( 'Support', 'magic-blog' ),
					'desc'	=> esc_html__( 'Need any help regarding the theme? Got stuck somewhere? Magic Blog theme support is just a click away. Search our incredible and 24/7 support forum. Query your questions and your solution will be resolved by our strong and dedicated support teams.', 'magic-blog' ),
					'url' => '',
					'new_tab' => true,
					'icon' => 'admin-users',
					'btn_txt' => esc_html__( 'Support Forum', 'magic-blog' )
				),
				'theme-features' => array(
					'title' => esc_html__( 'Theme Features', 'magic-blog' ),
					'desc'	=> esc_html__( 'Magic Blog theme comes with some incredible features. The elite feature of the theme is the user experience, code and security. Want to know more about the key features of the theme?', 'magic-blog' ),
					'url' => '',
					'new_tab' => true,
					'icon' => 'tag',
					'btn_txt' => esc_html__( 'Theme Features', 'magic-blog' )
				),
				'theme-comparison' => array(
					'title' => esc_html__( 'Free vs Pro', 'magic-blog' ),
					'desc'	=> esc_html__( 'Want to enhance your site? The Pro version provides more of the elite features that will enhance your site. There is more to the Magic Blog than meets the eye.', 'magic-blog' ),
					'url' => '',
					'new_tab' => true,
					'icon' => 'star-half',
					'btn_txt' => esc_html__( 'Theme Comparison', 'magic-blog' )
				),
			);

			if ( ! class_exists( 'OCDI_Plugin' ) ) {
				$args['demo-importer']['url'] = menu_page_url( 'tgmpa-install-plugins', false );
				$args['demo-importer']['btn_txt'] = esc_html__( 'Install One Click Demo Import', 'magic-blog' );
			}

			magic_blog_get_welcome_columns( $args ); ?>

		</div><!-- .postbox-container -->
	</div><!-- .wrap -->
<?php
}