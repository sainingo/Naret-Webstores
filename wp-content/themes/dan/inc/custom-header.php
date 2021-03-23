<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Dan
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses dan_header_style()
 */
function dan_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'dan_custom_header_args', array(
		'default-image'          => '',
		'width'                  => 1920,
		'height'                 => 1080,
		'flex-height'            => true,
		'header-text'            => false,
		'video'                  => true,
		'wp-head-callback'       => 'dan_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'dan_custom_header_setup' );

if ( ! function_exists( 'dan_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see dan_custom_header_setup().
 */
function dan_header_style() {
	$header_text_color = get_header_textcolor();

	/*
	 * If no custom options for text are set, let's bail.
	 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
	 */
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif;

if ( ! function_exists( 'dan_video_controls' ) ) :
/**
 * Customize video play/pause button in the custom header.
 *
 * @param array $settings Video settings.
 * @return array The filtered video settings.
 */
function dan_video_controls( $settings ) {
	$settings['l10n']['play'] = '<span class="fas fa-play"></span><span class="screen-reader-text">' . __( 'Play background video', 'dan' ) . '</span>';
	$settings['l10n']['pause'] = '<span class="fas fa-pause"></span><span class="screen-reader-text">' . __( 'Pause background video', 'dan' ) . '</span>';
	return $settings;
}
add_filter( 'header_video_settings', 'dan_video_controls' );
endif;
