<?php
/**
 * The template part for header
 *
 * @package VW Storefront 
 * @subpackage vw-storefront
 * @since vw-storefront 1.0
 */
?>

<div id="header" class="pt-2 pb-2">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-4 col-9">
        <div class="logo">
          <?php if ( has_custom_logo() ) : ?>
            <div class="site-logo"><?php the_custom_logo(); ?></div>
          <?php endif; ?>
          <?php $blog_info = get_bloginfo( 'name' ); ?>
            <?php if ( ! empty( $blog_info ) ) : ?>
              <?php if ( is_front_page() && is_home() ) : ?>
                <?php if( get_theme_mod('vw_storefront_logo_title_hide_show',true) != ''){ ?>
                  <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php } ?>
              <?php else : ?>
                <?php if( get_theme_mod('vw_storefront_logo_title_hide_show',true) != ''){ ?>
                  <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                <?php } ?>
              <?php endif; ?>
            <?php endif; ?>
            <?php
              $description = get_bloginfo( 'description', 'display' );
              if ( $description || is_customize_preview() ) :
            ?>
            <?php if( get_theme_mod('vw_storefront_tagline_hide_show',true) != ''){ ?>
              <p class="site-description">
                <?php echo esc_html($description); ?>
              </p>
            <?php } ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-lg-6 col-md-2 col-3">
        <?php if(has_nav_menu('primary')){ ?>
          <div class="toggle-nav mobile-menu">
            <button role="tab" onclick="vw_storefront_menu_open_nav()" class="responsivetoggle"><i class="<?php echo esc_attr(get_theme_mod('vw_storefront_res_menu_open_icon','fas fa-bars')); ?>"></i><span class="screen-reader-text"><?php esc_html_e('Open Button','vw-storefront'); ?></span></button>
          </div>
        <?php } ?>
        <div id="mySidenav" class="nav sidenav">
          <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'vw-storefront' ); ?>">
            <?php 
              if(has_nav_menu('primary')){
                wp_nav_menu( array( 
                  'theme_location' => 'primary',
                  'container_class' => 'main-menu clearfix' ,
                  'menu_class' => 'clearfix',
                  'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
                  'fallback_cb' => 'wp_page_menu',
                ) ); 
              }
            ?>
            <a href="javascript:void(0)" class="closebtn mobile-menu" onclick="vw_storefront_menu_close_nav()"><i class="<?php echo esc_attr(get_theme_mod('vw_storefront_res_menu_close_icon','fas fa-times')); ?>"></i><span class="screen-reader-text"><?php esc_html_e('Close Button','vw-storefront'); ?></span></a>
          </nav>
        </div>
      </div>
      <div class="col-lg-1 col-md-3 col-4">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-6 pl-md-0 pl-lg-0">
            <div class="account">
              <?php if(class_exists('woocommerce')){ ?>
                <?php if ( is_user_logged_in() ) { ?>
                  <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('My Account','vw-storefront'); ?>"><i class="fas fa-sign-in-alt"></i><span class="screen-reader-text"><?php esc_html_e( 'My Account','vw-storefront' );?></span></a>
                <?php }
                else { ?>
                  <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('Login / Register','vw-storefront'); ?>"><i class="fas fa-user"></i><span class="screen-reader-text"><?php esc_html_e( 'Login / Register','vw-storefront' );?></span></a>
                <?php } ?>
              <?php }?>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-6 pl-md-0 pl-lg-0">
            <?php if(class_exists('woocommerce')){ ?>
              <div class="cart_no">
                <a href="<?php if(function_exists('wc_get_cart_url')){ echo esc_url(wc_get_cart_url()); } ?>" title="<?php esc_attr_e( 'shopping cart','vw-storefront' ); ?>"><i class="fas fa-shopping-basket"></i><span class="screen-reader-text"><?php esc_html_e( 'shopping cart','vw-storefront' );?></span></a>
                <span class="cart-value"> <?php echo esc_html(wp_kses_data( WC()->cart->get_cart_contents_count() ));?></span>
              </div>
            <?php }?>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-8">
        <?php if( get_theme_mod( 'vw_storefront_phone_text') != '' || get_theme_mod( 'vw_storefront_phone_number') != '') { ?>
          <div class="phone_no">
            <div class="row">
              <div class="col-lg-2 col-md-2 col-2 p-0">
                <i class="fas fa-comments"></i>
              </div>
              <div class="col-lg-10 col-md-10 col-10">
                <p class="phone_text"><?php echo esc_html(get_theme_mod('vw_storefront_phone_text',''));?></p>
                <strong><?php echo esc_html(get_theme_mod('vw_storefront_phone_number',''));?></strong>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>