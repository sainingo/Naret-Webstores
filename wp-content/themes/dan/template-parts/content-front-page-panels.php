<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Dan
 */

global $dan_counter;

?>

<section id="panel<?php echo $dan_counter; ?>" <?php post_class( 'dan-panel' ); ?>>
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

		<?php
		// Show recent blog posts if is blog posts page (Note that get_option returns a string, so we're casting the result as an int).
		if ( get_the_ID() === (int) get_option( 'page_for_posts' ) ) : ?>

			<?php // Show four most recent posts.
			$recent_posts = new WP_Query( array(
				'posts_per_page'      => 5,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			) );
			?>

			<?php if ( $recent_posts->have_posts() ) : ?>

			<div class="recent-posts">
				<?php
					while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
					get_template_part( 'template-parts/content', 'excerpt' );
					endwhile;
					wp_reset_postdata();
				?>
			</div><!-- .recent-posts -->

			<?php endif; ?>

		<?php endif; ?>

		<?php if ( get_edit_post_link() ) : ?>
			<footer class="entry-footer">
				<?php dan_edit_link(); ?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>
	</div><!-- .dan-panel-inner -->
</section><!-- #post-## -->
