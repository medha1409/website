<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Moral
 */

$default = magic_blog_get_default_mods();
?>

	</div><!-- #content -->
	<footer id="colophon" class="site-footer" role="contentinfo">
            <!-- .supports col-1, col-2, col-3, col-4 -->
            <?php  
				$count = 0;
				for ( $i=1; $i <=4 ; $i++ ) { 
					if ( is_active_sidebar( 'footer-' . $i ) ) {
						$count++;
					}
				} ?>
			<?php if ( 0 !== $count ) : ?>
            <div class="footer-widgets-area col-<?php echo esc_attr( $count );?>">
                <div class="wrapper">
                <?php 
					for ( $j=1; $j <=4; $j++ ) { 
						if ( is_active_sidebar( 'footer-' . $j ) ) {
			    			echo '<div class="hentry">';
							dynamic_sidebar( 'footer-' . $j ); 
			    			echo '</div>';
						}
					}
					?>
                </div><!-- .wrapper -->
            </div><!-- .footer-widgets-area -->
        <?php endif; ?>
        	<?php $footer_menu = get_theme_mod( 'magic_blog_enable_footer_social_menu', true );
             $footer_text = get_theme_mod( 'magic_blog_enable_footer_text', true ); ?>
            <?php if ( $footer_text ) { ?>
	            <div class="site-info">
	            	<div class="wrapper">
					    <span>
					       <?php 
					        printf( esc_html__( 'Theme: %1$s by %2$s. ', 'magic-blog' ), 'Magic Blog', '<a href="' . esc_url( 'http://moralthemes.com/' ) . '">Moral Themes</a>' ); 
					        if ( function_exists( 'the_privacy_policy_link' ) ) {
								the_privacy_policy_link();
							}
					        ?>
					    </span><!-- .footer-copyright -->
					    <span class="social-menu">
					    <?php if ( $footer_menu && has_nav_menu( 'social' ) ) :
							wp_nav_menu( array(
								'theme_location' => 'social',
								'menu_class'	 => 'social-icons',
								'container_class' => 'social-menu',
								'depth'          => 1,
								'link_before'    => '<span class="screen-reader-text">',
								'link_after'     => '</span>' . magic_blog_get_svg( array( 'icon' => 'chain' ) ),
							) );
					    endif; ?>
				    </span>
					</div><!-- .wrapper -->  
	            </div><!-- .site-info -->
            <?php } ?> 
        </footer><!-- #colophon -->
	
	<?php  
	$backtop = get_theme_mod( 'magic_blog_back_to_top_enable', true );
	if ( $backtop ) { ?>
		<div class="backtotop"><?php echo magic_blog_get_svg( array( 'icon' => 'up-arrow' ) ); ?></div>
	<?php }	?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
