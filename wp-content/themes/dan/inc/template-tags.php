<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Dan
 */

if ( ! function_exists( 'dan_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function dan_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
    /* translators: %s: post date. */
		__( '<span class="screen-reader-text">Posted on</span> %s', 'dan' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
    /* translators: %s: post author. */
		__( '<span class="screen-reader-text">by</span> %s', 'dan' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on"><span class="fas fa-clock fa-fw" aria-hidden="true"></span>' . $posted_on . '</span><span class="byline"><span class="fas fa-user-circle fa-fw" aria-hidden="true"></span>' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'dan_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function dan_entry_footer() {
	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'dan' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html( ' ' ) );
		if ( $categories_list && dan_categorized_blog() ) {
			printf( '<span class="cat-links"><span class="fas fa-folder fa-fw" aria-hidden="true"></span><span class="screen-reader-text">%1$s</span> %2$s</span>',
				esc_html__( 'Categories', 'dan' ),
				$categories_list
			);
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html( ' ' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><span class="fas fa-tag fa-fw" aria-hidden="true"></span><span class="screen-reader-text">%1$s</span> %2$s</span>',
				esc_html__( 'Tags', 'dan' ),
				$tags_list
			);
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link"><span class="fas fa-comment fa-fw" aria-hidden="true"></span>';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'dan' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo '</span>';
	}

	dan_edit_link();
}
endif;

if ( ! function_exists( 'dan_edit_link' ) ) :
function dan_edit_link() {
	edit_post_link(
		sprintf(
			wp_kses(
      /* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'dan' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

if ( ! function_exists( 'dan_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * Create your own dan_excerpt_more() function to override in a child theme.
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function dan_excerpt_more() {
	$link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'dan' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'dan_excerpt_more' );
endif;

/**
 * Display a front page section.
 *
 * @param WP_Customize_Partial $partial Partial associated with a selective refresh request.
 * @param integer              $id Front page section to display.
 */
function dan_front_page_section( $partial = null, $id = 0 ) {
	if ( is_a( $partial, 'WP_Customize_Partial' ) ) {
		// Find out the id and set it up during a selective refresh.
		global $dan_counter;
		$id         = str_replace( 'panel_', '', $partial->id );
		$dan_counter = $id;
	}

	global $post; // Modify the global post object before setting up post data.
	if ( get_theme_mod( 'panel_' . $id ) ) {
		$post = get_post( get_theme_mod( 'panel_' . $id ) );
		setup_postdata( $post );
		set_query_var( 'panel', $id );

		get_template_part( 'template-parts/content', 'front-page-panels' );

		wp_reset_postdata();
	} elseif ( is_customize_preview() ) {
		// The output placeholder anchor.
		echo '<article class="panel-placeholder panel dan-panel dan-panel' . $id . '" id="panel' . $id . '"><span class="dan-panel-title">' . sprintf( __( 'Front Page Section %1$s Placeholder', 'dan' ), $id ) . '</span></article>';
	}
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function dan_categorized_blog() {
	$all_the_cool_cats = get_transient( 'dan_categories' );
	if ( false === $all_the_cool_cats ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'dan_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 || is_preview() ) {
		// This blog has more than 1 category so dan_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so dan_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in dan_categorized_blog.
 */
function dan_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'dan_categories' );
}
add_action( 'edit_category', 'dan_category_transient_flusher' );
add_action( 'save_post',     'dan_category_transient_flusher' );
