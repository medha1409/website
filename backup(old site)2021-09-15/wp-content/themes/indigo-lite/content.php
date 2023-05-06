<?php
/**
 * The template for displaying posts on index view
 *
 * @package Indigo Lite
 */
?>

<div <?php post_class(); ?>>
	<?php if (has_post_thumbnail()): ?>
		<a href="<?php the_permalink() ?>">
      		<?php the_post_thumbnail('indigo-blogthumb') ?>
    	</a>
    <?php endif; ?>
    <h2 class="entry-title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
        <?php the_title(); ?>
        </a></h2>
      <div class="entry">
        <?php the_excerpt(); ?>
      </div>
    </div>