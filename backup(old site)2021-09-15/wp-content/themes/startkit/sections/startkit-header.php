<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="custom-header" rel="home">
		<img src="<?php esc_url(header_image()); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo( get_bloginfo( 'title' ) ); ?>">
	</a>
<?php endif;  ?>
	
    <!-- Start: Search
    ============================= -->
    <div id="search">
        <a href="#" id="close-btn">
        <i class="fa fa-times"></i>
        </a>
        <div>
		<form method="get" id="searchform" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input id="searchbox" class="search-field" type="search" type="text" value="" name="s" id="s" placeholder="<?php esc_attr_e('type here','startkit'); ?>" />
            <button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
		</form>
        </div>
    </div>	
    <!-- End: Search
    ============================= -->	