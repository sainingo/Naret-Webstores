<?php
/**
 * VW Storefront: Block Patterns
 *
 * @package VW Storefront
 * @since   1.0.0
 */

/**
 * Register Block Pattern Category.
 */
if ( function_exists( 'register_block_pattern_category' ) ) {

	register_block_pattern_category(
		'vw-storefront',
		array( 'label' => __( 'VW Storefront', 'vw-storefront' ) )
	);
}

/**
 * Register Block Patterns.
 */
if ( function_exists( 'register_block_pattern' ) ) {
	register_block_pattern(
		'vw-storefront/banner-section',
		array(
			'title'      => __( 'Banner Section', 'vw-storefront' ),
			'categories' => array( 'vw-storefront' ),
			'content'    => "<!-- wp:cover {\"url\":\"" . esc_url(get_template_directory_uri()) . "/inc/block-patterns/images/banner.png\",\"id\":6150,\"dimRatio\":0,\"align\":\"full\",\"className\":\"banner-section\"} -->\n<div class=\"wp-block-cover alignfull banner-section\" style=\"background-image:url(" . esc_url(get_template_directory_uri()) . "/inc/block-patterns/images/banner.png)\"><div class=\"wp-block-cover__inner-container\"><!-- wp:columns {\"align\":\"wide\"} -->\n<div class=\"wp-block-columns alignwide\"><!-- wp:column {\"verticalAlignment\":\"center\"} -->\n<div class=\"wp-block-column is-vertically-aligned-center\"><!-- wp:heading {\"level\":4,\"style\":{\"color\":{\"text\":\"#e2333e\"}}} -->\n<h4 class=\"has-text-color\" style=\"color:#e2333e\">LOREM IPSUM DOLOR SIT AMET </h4>\n<!-- /wp:heading -->\n\n<!-- wp:heading {\"textAlign\":\"left\",\"level\":1,\"textColor\":\"black\"} -->\n<h1 class=\"has-text-align-left has-black-color has-text-color\">Lorem ipsum dolor sit amet, consectetur</h1>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"textColor\":\"black\"} -->\n<p class=\"has-black-color has-text-color\">Lorem Ipsum has been the industrys standard. Lorem Ipsum has been the industrys standard.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button {\"style\":{\"color\":{\"gradient\":\"linear-gradient(100deg,rgb(229,51,61) 0%,rgb(189,50,72) 100%)\"}}} -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link has-background\" style=\"background:linear-gradient(100deg,rgb(229,51,61) 0%,rgb(189,50,72) 100%)\">SHOP NOW</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns --></div></div>\n<!-- /wp:cover -->",
		)
	);

	register_block_pattern(
		'vw-storefront/products-section',
		array(
			'title'      => __( 'Featured Product Section', 'vw-storefront' ),
			'categories' => array( 'vw-storefront' ),
			'content'    => "<!-- wp:cover {\"overlayColor\":\"white\",\"align\":\"wide\",\"className\":\"products-outer-box\"} -->\n<div class=\"wp-block-cover alignwide has-white-background-color has-background-dim products-outer-box\"><div class=\"wp-block-cover__inner-container\"><!-- wp:paragraph {\"align\":\"center\",\"style\":{\"color\":{\"text\":\"#e5333d\"}}} -->\n<p class=\"has-text-align-center has-text-color\" style=\"color:#e5333d\">Shop &amp; Explore</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading {\"textAlign\":\"center\",\"textColor\":\"black\"} -->\n<h2 class=\"has-text-align-center has-black-color has-text-color\">New Arrivals</h2>\n<!-- /wp:heading -->\n\n<!-- wp:woocommerce/product-category {\"columns\":4,\"rows\":1,\"categories\":[32],\"contentVisibility\":{\"title\":true,\"price\":true,\"rating\":false,\"button\":true},\"align\":\"wide\",\"className\":\"products-container\"} /-->\n\n<!-- wp:paragraph {\"align\":\"center\",\"placeholder\":\"Write title\",\"fontSize\":\"large\"} -->\n<p class=\"has-text-align-center has-large-font-size\"></p>\n<!-- /wp:paragraph --></div></div>\n<!-- /wp:cover -->",
		)
	);
}