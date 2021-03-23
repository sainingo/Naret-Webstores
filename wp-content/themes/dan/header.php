<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Dan
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'dan' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<div class="site-branding-logo">
					<?php the_custom_logo(); ?>
				</div><!-- .site-branding-logo -->
			<?php endif; ?>

			<?php if ( is_front_page() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<div class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="fas fa-bars" aria-hidden="true"></span><?php esc_html_e( 'Menu', 'dan' ); ?></button>
		<?php endif; ?>

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php if ( has_nav_menu( 'primary' ) ) : ?>
					<?php
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'container'      =>  false,
						) );
					?>
				<?php endif; ?>
			</nav><!-- #site-navigation -->
		<?php endif; ?>

		<?php if ( has_header_image() || has_header_video() ) : ?>
			<?php
			$description = get_bloginfo( 'description', 'display' );
			if ( is_front_page() && ( $description || is_customize_preview() ) ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>

			<?php the_custom_header_markup(); ?>

		<?php endif; ?>
	</header><!-- #masthead -->
