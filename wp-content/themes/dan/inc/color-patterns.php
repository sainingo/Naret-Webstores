<?php
/**
 * Dan: Color Patterns
 *
 * @package WordPress
 * @since 1.1.1
 */

/**
 * Generate the CSS for the current custom color scheme.
 */
function dan_custom_colors_css() {
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );

	/**
	 * Filter Dan default saturation level.
	 *
	 * @since 1.1.1
	 *
	 * @param int $saturation Color saturation level.
	 */
	$saturation = absint( apply_filters( 'dan_custom_colors_saturation', 30 ) );
	$reduced_saturation = ( .8 * $saturation ) . '%';
	$saturation = $saturation . '%';
	$css = '
/**
 * Dan: Color Patterns
 */

body.colors-custom  {
	background-color: hsl( ' . $hue . ', ' . $saturation . ', 99% );
}

body.colors-custom ,
.colors-custom button,
.colors-custom input,
.colors-custom optgroup,
.colors-custom select,
.colors-custom textarea {
	color: hsl( ' . $hue . ', ' . $saturation . ', 10% );
}

.colors-custom pre,
.colors-custom tbody th,
.colors-custom thead th {
	background-color: hsl( ' . $hue . ', ' . $saturation . ', 95% );
}

.colors-custom td,
.colors-custom th,
.colors-custom thead th {
	border-color: hsl( ' . $hue . ', ' . $saturation . ', 90% );
}

.colors-custom button,
.colors-custom input[type=button],
.colors-custom input[type=reset],
.colors-custom input[type=submit] {
	background-color: hsl( ' . $hue . ', ' . $saturation . ', 85% );
	color: hsl( ' . $hue . ', ' . $saturation . ', 25% ):
}

.colors-custom button:hover,
.colors-custom input[type="button"]:hover,
.colors-custom input[type="reset"]:hover,
.colors-custom input[type="submit"]:hover {
	background-image: -webkit-gradient(linear, left top, left bottom, from(hsla( ' . $hue . ', ' . $saturation . ', 25%, 0.1 )), to(hsla( ' . $hue . ', ' . $saturation . ', 25%, 0.1 )));
	background-image: linear-gradient(hsla( ' . $hue . ', ' . $saturation . ', 25%, 0.1 ), hsla( ' . $hue . ', ' . $saturation . ', 25%, 0.1 ));
}

.colors-custom button:focus,
.colors-custom input[type="button"]:focus,
.colors-custom input[type="reset"]:focus,
.colors-custom input[type="submit"]:focus,
.colors-custom button:active,
.colors-custom input[type="button"]:active,
.colors-custom input[type="reset"]:active,
.colors-custom input[type="submit"]:active {
	background-image: -webkit-gradient(linear, left top, left bottom, from(hsla( ' . $hue . ', ' . $saturation . ', 25%, 0.08 )), to(hsla( ' . $hue . ', ' . $saturation . ', 25%, 0.08 )));
	background-image: linear-gradient(hsla( ' . $hue . ', ' . $saturation . ', 25%, 0.08 ), hsla( ' . $hue . ', ' . $saturation . ', 25%, 0.08 ));
}

.colors-custom .site-header,
.colors-custom .wp-custom-header,
.colors-custom .social-navigation a,
.colors-custom .more-link {
	background-color: hsl( ' . $hue . ', ' . $saturation . ', 35% );
}

.colors-custom .site-description {
	color: hsl( ' . $hue . ', ' . $saturation . ', 95% );
}

.colors-custom .site-title,
.colors-custom .site-title a,
.colors-custom .dropdown-toggle,
.colors-custom .main-navigation a,
.colors-custom .menu-toggle {
	color: hsl( ' . $hue . ', ' . $saturation . ', 100% );
}

@media screen and (max-width:767px){
	.colors-custom .main-navigation {
		background-color: hsla( ' . $hue . ', ' . $saturation . ', 35%, .9 );
	}
	.colors-custom .main-navigation li+li,
	.dropdown-toggle::after {
		border-color: hsla( ' . $hue . ', ' . $saturation . ', 65%, .2 );
	}
}

@media screen and (min-width:768px) {
	.colors-custom .main-navigation #primary-menu > .current_page_item::after,
	.colors-custom .main-navigation #primary-menu > .current-menu-item::after,
	.colors-custom .main-navigation #primary-menu > .current_page_ancestor::after,
	.colors-custom .main-navigation #primary-menu > .current-menu-ancestor::after {
		border-color: hsl( ' . $hue . ', ' . $saturation . ', 80% );
	}

	.colors-custom .main-navigation ul ul {
		background-color: hsl( ' . $hue . ', ' . $saturation . ', 30% );
		color: hsl( ' . $hue . ', ' . $saturation . ', 100% );
	}
	.colors-custom .main-navigation ul ul a{
		color: hsl( ' . $hue . ', ' . $saturation . ', 100% );
	}
}

.colors-custom .menu-toggle,
.colors-custom .menu-toggle:hover,
.colors-custom .menu-toggle:focus,
.colors-custom .dropdown-toggle,
.colors-custom .dropdown-toggle:hover,
.colors-custom .dropdown-toggle:focus {
	background-color: transparent;
}

.colors-custom .page-numbers.current:after,
.colors-custom .page-links .page-number::after {
	border-color: hsl( ' . $hue . ', ' . $saturation . ', 80% );
}

.colors-custom .page-numbers:hover,
.colors-custom .page-numbers:focus,
.colors-custom .page-links a:hover,
.colors-custom .page-links a:focus,
.colors-custom .widget .tagcloud a:hover,
.colors-custom .widget .tagcloud a:focus,
.colors-custom .widget.widget_tag_cloud a:hover,
.colors-custom .widget.widget_tag_cloud a:focus,
.colors-custom .wp_widget_tag_cloud a:hover,
.colors-custom .wp_widget_tag_cloud a:focus {
	background-image: -webkit-gradient(linear, left top, left bottom, from( hsla( ' . $hue . ', ' . $saturation . ', 64%, 0.1 )), to( hsla( ' . $hue . ', ' . $saturation . ', 64%, 0.1 )));
	background-image: linear-gradient( hsla( ' . $hue . ', ' . $saturation . ', 64%, 0.1 ),  hsla( ' . $hue . ', ' . $saturation . ', 64%, 0.1 ));
}

.colors-custom .site-footer {
	background-color: hsl( ' . $hue . ', ' . $saturation . ', 96.5% );
	border-color: hsl( ' . $hue . ', ' . $saturation . ', 96.5% );
}
.colors-custom .site-info {
	color: hsl( ' . $hue . ', ' . $saturation . ', 30% );
}

.colors-custom .sticky-post {
	background-color: hsl( ' . $hue . ', ' . $saturation . ', 30% );
}

.colors-custom .entry-meta,
.colors-custom .entry-footer,
.colors-custom .entry-meta a,
.colors-custom .entry-footer a,
.colors-custom .comment-metadata,
.colors-custom .comment-metadata a {
	color: hsl( ' . $hue . ', ' . $reduced_saturation . ', 20% );
}

.colors-custom .footer-widget .widget_calendar thead th,
.colors-custom .footer-widget .widget_calendar th,
.colors-custom .footer-widget .widget_calendar td {
	border-color: hsl( ' . $hue . ', ' . $saturation . ', 85% );
}

.colors-custom .more-link {
	color: hsl( ' . $hue . ', ' . $saturation . ', 100% );
}

.colors-custom .more-link:hover,
.colors-custom .more-link:focus {
	background-image: -webkit-gradient(linear, left top, left bottom, from(hsla( ' . $hue . ', ' . $saturation . ', 35%, .2 )), to(hsla( ' . $hue . ', ' . $saturation . ', 35%, .2 )));
	background-image: linear-gradient(hsla( ' . $hue . ', ' . $saturation . ', 35%, .2 ), hsla( ' . $hue . ', ' . $saturation . ', 35%, .2 ));
}

.colors-custom .entry-content h2,
.colors-custom .entry-content h3 {
	border-color: hsl( ' . $hue . ', ' . $saturation . ', 90% );
}

.colors-custom .wp-block-table td,
.colors-custom .wp-block-table th {
	border-color: hsl( ' . $hue . ', ' . $saturation . ', 90% );
}

.colors-custom .wp-block-file .wp-block-file__button,
.colors-custom .wp-block-file .wp-block-file__button:hover,
.colors-custom .wp-block-file .wp-block-file__button:focus {
	background-color: hsl( ' . $hue . ', ' . $saturation . ', 35% );
}';

	/**
	 * Filters Dan custom colors CSS.
	 *
	 * @since 1.1.1
	 *
	 * @param string $css        Base theme colors CSS.
	 * @param int    $hue        The user's selected color hue.
	 * @param string $saturation Filtered theme color saturation level.
	 */
	return apply_filters( 'dan_custom_colors_css', $css, $hue, $saturation );
}
