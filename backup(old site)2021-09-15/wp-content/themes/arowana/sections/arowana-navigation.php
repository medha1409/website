<!-- Start: Header
============================= -->
<?php
	$cart_header_setting		= get_theme_mod('cart_header_setting','1');
	$header_search				= get_theme_mod('header_search');  
	$booknow_setting			= get_theme_mod('booknow_setting','1'); 
	$header_btn_icon			= get_theme_mod('header_btn_icon'); 
	$header_btn_lbl				= get_theme_mod('header_btn_lbl'); 
	$header_btn_link			= get_theme_mod('header_btn_link'); 
?>
<header id="header" role="banner">
<!-- Navigation Starts -->
	<div class="navbar-area normal-h <?php echo esc_attr(startkit_sticky_menu()); ?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-6">
				<div class="logo main">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php
							if(has_custom_logo())
							{	
								the_custom_logo();
							}
							else { 
						?>
							<h2 class="site-title"><?php echo esc_html(bloginfo('name')); ?></h2>
						<?php 		
							}
						?>
						
						<?php
							$description = get_bloginfo( 'description');
							if ($description) : ?>
								<p class="site-description"><?php echo esc_html($description); ?></p>
						<?php endif; ?>
					</a>
				</div>
			</div>
			<!-- Nav -->
			<div class="col-lg-6 d-none d-lg-block">
				<nav class="text-right main-menu">
					<?php 
					wp_nav_menu( 
						array(  
							'theme_location' => 'primary_menu',
							'container'  => '',
							'menu_class' => '',
							'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
							'walker' => new WP_Bootstrap_Navwalker()
							 ) 
						);
					?>
				</nav>
			</div>
			<!-- Nav End -->
			<div class="col-lg-3 col-6">
				<div class="header-right-bar">                            
					<ul>
						<?php if($cart_header_setting == '1') { ?>
						<li class="search-button search-cart-se">
							<a class="" href="#search"><i class="fa <?php echo esc_attr( $header_search ); ?>"></i></a>                                
						</li>
						<?php } ?>
						<?php if($booknow_setting == '1') { ?>
							<li class="book-now-btn">
								<?php if ( ! empty( $header_btn_lbl ) ) : ?>
									<a class="book-now" href="<?php echo esc_url( $header_btn_link ); ?>"><i class="fa <?php echo esc_attr( $header_btn_icon ); ?>"></i><?php echo esc_html( $header_btn_lbl ); ?></a>
								<?php endif; ?>		
							</li>
						<?php } ?>	
					</ul>
				</div>
			</div>
			<!-- Start Mobile Menu -->
            <div class="mobile-menu-area d-lg-none">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mobile-menu">
                                <nav class="mobile-menu-active">
                                    <?php 
										wp_nav_menu( 
											array(  
												'theme_location' => 'primary_menu',
												'container'  => '',
												'menu_class' => '',
												'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
												'walker' => new WP_Bootstrap_Navwalker()
												 ) 
											);
										?>
                                </nav>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Mobile Menu -->
		</div>
	</div>
</div>	
<!-- Navigation End -->
<?php 
if ( !is_page_template( 'templates/template-homepage.php' ) ) {
		startkit_breadcrumbs_style(); 
	}
?>