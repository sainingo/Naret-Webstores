<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Dan
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

	<?php
	if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title"><?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Search Results for: %s', 'dan' ), '<span>' . get_search_query() . '</span>' );
			?></h1>
		</header><!-- .page-header -->

		<?php
		/* Start the Loop */
		while ( have_posts() ) : the_post();

			/**
			 * Run the loop for the search to output the results.
			 * If you want to overload this in a child theme then include a file
			 * called content-search.php and that will be used instead.
			 */
			get_template_part( 'template-parts/content', 'search' );

		/* End the loop */
		endwhile;

		/* Previous/next page navigation */
		the_posts_pagination( array(
			'prev_text'          => esc_html( '&laquo; ' ) . __( 'Previous page', 'dan' ),
			'next_text'          => __( 'Next page', 'dan' ) . esc_html( ' &raquo;' ),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'dan' ) . '</span>',
		) );

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_sidebar();
get_footer();
