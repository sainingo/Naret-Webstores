<?php
/**
 * Template for displaying search forms
 *
 * @package Saka
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'dan' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'dan' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<button type="submit" class="search-submit"><span class="fas fa-search"></span><span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'dan' ); ?></span></button>
</form>
