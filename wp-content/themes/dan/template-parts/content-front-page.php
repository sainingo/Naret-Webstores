<?php
/**
 * Displays content for front page
 *
 */

?>

<section id="post-<?php the_ID(); ?>" <?php post_class( 'dan-panel' ); ?>>
	<div class="dan-panel-inner">
		<header class="entry-header">
			<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
		</header><!-- .entry-header -->

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="entry-thumbnail">
				<?php the_post_thumbnail( 'dan-featured-image' ); ?>
			</div><!-- .entry-thumbnail -->
		<?php endif; ?>

		<div class="entry-content">
			<?php
				the_content( sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'dan' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				) );
			?>
		</div><!-- .entry-content -->

		<?php if ( get_edit_post_link() ) : ?>
			<footer class="entry-footer">
				<?php dan_edit_link(); ?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>
	</div><!-- .dan-panel-inner -->
</section><!-- #post-## -->
