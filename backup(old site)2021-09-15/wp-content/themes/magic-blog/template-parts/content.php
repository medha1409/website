<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Moral
 */

?>
<?php $archive_img_enable = get_theme_mod( 'magic_blog_enable_archive_featured_img', true );
 if ( has_post_thumbnail() && $archive_img_enable ) {
		$class= 'has-post-thumbnail';
	} else {
		$class= 'no-post-thumbnail';
	}
 ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="<?php echo esc_attr($class); ?>">
    <div class="post-wrapper">
	    <?php 
		$archive_img_enable = get_theme_mod( 'magic_blog_enable_archive_featured_img', true );

		$img_url = '';
		if ( has_post_thumbnail() && $archive_img_enable ) : 
			$img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		endif;
		?>
        <div class="featured-image" style="background-image: url('<?php echo esc_url( $img_url ); ?>');">
            <a href="<?php the_permalink(); ?>" class="post-thumbnail-link"></a>
        </div><!-- .featured-image -->

        <div class="entry-container">
            <div class="entry-meta">
               <span class="cat-links">
                   <?php magic_blog_cats();  ?>
                </span>
            </div><!-- .entry-meta -->

            <header class="entry-header">
                <?php
					if ( is_singular() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					endif; ?>
            </header>

            <div class="entry-content">
                <?php
				$archive_content_type = get_theme_mod( 'magic_blog_enable_archive_content_type', 'excerpt' );
				if ( 'excerpt' === $archive_content_type ) {
					the_excerpt();
					
				} else {
					the_content( sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'magic-blog' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					) );

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'magic-blog' ),
						'after'  => '</div>',
					) );
				}
			?>
            </div><!-- .entry-content -->
            <div class="read-more">
			    <a href="<?php the_permalink(); ?>" class="btn"	><?php echo esc_html( get_theme_mod( 'magic_blog_archive_excerpt', esc_html__( 'Continue Reading', 'magic-blog' ) ) ); ?></a>
			</div><!-- .read-more -->
        </div><!-- .entry-container -->
    </div><!-- .post-wrapper -->
</article>


