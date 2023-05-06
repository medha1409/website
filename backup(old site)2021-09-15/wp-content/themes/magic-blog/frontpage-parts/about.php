<?php
/**
 * Template part for displaying front page about.
 *
 * @package Moral
 */
// Get default  mods value.
$default = magic_blog_get_default_mods();

// Get the content type.
$about = get_theme_mod( 'magic_blog_about', 'page' );
$trending = get_theme_mod( 'magic_blog_trending', 'page' );

// Bail if the section is disabled.
if ( 'disable' === $about ) {
	return;
}

if ( 'disable' === $trending ) {
	return;
}
// Query if the content type is either post or page.
	$about_id = get_theme_mod( 'magic_blog_about_page' );

	$query = new WP_Query( array( 'post_type' => 'page', 'p' => absint( $about_id ) ) );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$img_url     = get_the_post_thumbnail_url( $about_id, 'large' );
			$about_title   = get_the_title();
			$content = get_the_excerpt();
			$btn_url     = get_permalink();

		}
		wp_reset_postdata();
	} 
$about_signature_url = get_theme_mod( 'magic_blog_about_signature');


// Query if the trending content type is either post or page.
	$trending_id = get_theme_mod( 'magic_blog_trending_page' );

	$the_query = new WP_Query( array( 'post_type' => 'page', 'p' => absint( $trending_id ) ));

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$trending_img_url     = get_the_post_thumbnail_url( $trending_id, 'full' );
			$trending_title   = get_the_title();
			$trending_btn_url     = get_permalink();
		}
		wp_reset_postdata();
	}

$trending_btn_txt = get_theme_mod( 'magic_blog_trending_btn_text', $default['magic_blog_trending_btn_text'] );

?>
<div id="about-us" class="col-2">
    <div class="wrapper">

        <article class="hentry">
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html( $about_title ); ?></h2>
            </div>

            <div class="about-image">
                <a href="<?php echo esc_url( $btn_url ); ?>"><img src="<?php echo esc_url( $img_url );?>"></a>
            </div>

            <div class="entry-content">
                <p><?php echo wp_kses_post( $content ); ?></p>

                <img src="<?php echo esc_url( $about_signature_url ); ?>">
            </div><!-- .entry-content -->
        </article><!-- .hentry -->
        <article class=" trending hentry">
            <header class="entry-header">
                <h2 class="entry-title"><?php echo esc_html($trending_title); ?></h2>
            </header>
            <div class="featured-image" style="background-image:url('<?php echo esc_url( $trending_img_url ); ?>')">
                <a href="<?php echo esc_url( $trending_btn_url ); ?>" class="btn btn-fill" tabindex="0"><?php echo esc_html( $trending_btn_txt ); ?></a>
            </div>
        </article><!-- .hentry -->
    </div><!-- .wrapper -->
</div><!-- #about-us -->

