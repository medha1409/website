<?php
/**
 * The template for displaying the footer.
 *
 *
 * @package Indigo Lite
 */
?>
<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
<div id="footer">
  		<div id="footerinner">
    		<?php dynamic_sidebar( 'sidebar-2' ); ?>
  		</div>
</div>
<?php endif ?>

<?php if ( has_nav_menu( 'social' ) ) {
					wp_nav_menu(
						array(
							'theme_location'  => 'social',
							'container'       => 'div',
							'container_id'    => 'menu-social',
							'container_class' => 'menu',
							'menu_id'         => 'menu-social-items',
							'menu_class'      => 'menu-items',
							'depth'           => 1,
							'link_before'     => '<span class="screen-reader-text">',
							'link_after'      => '</span>',
							'fallback_cb'     => '',
						)
					);
} ?>
<div id="copyinfo">
  	&copy; <?php echo date_i18n(__('Y','indigo-lite')); ?>
    <?php bloginfo('name'); ?>
    . <a href="<?php echo esc_url( esc_html__( 'http://wordpress.org/', 'indigo-lite' ) ); ?>"> <?php printf( esc_html__( 'Powered by %s.', 'indigo-lite' ), 'WordPress' ); ?> </a> <?php printf( esc_html__( 'Theme by %1$s.', 'indigo-lite' ), '<a href="http://www.vivathemes.com/" rel="designer">Viva Themes</a>' ); ?>
  </div>
<?php wp_footer(); ?>
</body></html>