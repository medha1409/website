<?php
/**
 * Template part for displaying content  in post.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Moral
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry' ); ?>>
	<?php $single_date_enable = get_theme_mod( 'magic_blog_enable_single_date', true );
		if ( $single_date_enable ) { ?>
	    <span class="posted-on">
	        <span class="screen-reader-text"><?php esc_html__('Posted on', 'magic-blog') ?></span> 
	        <time class="entry-date published" ><?php magic_blog_posted_on(); ?></time><time class="updated"><?php magic_blog_posted_on(); ?></time>
	    </span><!-- .posted-on -->
	<?php } ?>

    <div class="entry-content">
        <?php
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
			?>
    </div><!-- .entry-content -->

    <div class="entry-meta">
    	<?php $single_author_enable = get_theme_mod( 'magic_blog_enable_single_author', true );
	    if ( $single_author_enable ) { ?>
	        <span class="byline">
	            <span class="author vcard"><?php esc_html_e('By:', 'magic-blog'); ?> <a class="url fn n" href="<?php esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span>
	        </span><!-- .byline -->
	    <?php } ?>
       <span class="cat-links">
            <?php the_category( esc_html__( ', ', 'magic-blog' ) ); ?>
        </span>
        <?php magic_blog_tags(); ?>
    </div><!-- .entry-meta -->
</article>


