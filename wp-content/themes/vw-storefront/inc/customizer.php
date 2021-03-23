<?php
/**
 * VW Storefront Theme Customizer
 *
 * @package VW Storefront
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function vw_storefront_custom_controls() {
	load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'vw_storefront_custom_controls' );

function vw_storefront_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-picker.php' );

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage'; 
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'blogname', array( 
		'selector' => '.logo .site-title a', 
	 	'render_callback' => 'vw_storefront_customize_partial_blogname', 
	)); 

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array( 
		'selector' => 'p.site-description', 
		'render_callback' => 'vw_storefront_customize_partial_blogdescription', 
	));

	//add home page setting pannel
	$vw_storefront_parent_panel = new VW_Storefront_WP_Customize_Panel( $wp_customize, 'vw_storefront_panel_id', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => esc_html__( 'VW Settings', 'vw-storefront' ),
		'priority' => 10,
	));

	// Layout
	$wp_customize->add_section( 'vw_storefront_left_right', array(
    	'title' => esc_html__( 'General Settings', 'vw-storefront' ),
		'panel' => 'vw_storefront_panel_id'
	) );

	$wp_customize->add_setting('vw_storefront_width_option',array(
        'default' => 'Full Width',
        'sanitize_callback' => 'vw_storefront_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Storefront_Image_Radio_Control($wp_customize, 'vw_storefront_width_option', array(
        'type' => 'select',
        'label' => esc_html__('Width Layouts','vw-storefront'),
        'description' => esc_html__('Here you can change the width layout of Website.','vw-storefront'),
        'section' => 'vw_storefront_left_right',
        'choices' => array(
            'Full Width' => esc_url(get_template_directory_uri()).'/assets/images/full-width.png',
            'Wide Width' => esc_url(get_template_directory_uri()).'/assets/images/wide-width.png',
            'Boxed' => esc_url(get_template_directory_uri()).'/assets/images/boxed-width.png',
    ))));

	$wp_customize->add_setting('vw_storefront_theme_options',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'vw_storefront_sanitize_choices'
	));
	$wp_customize->add_control('vw_storefront_theme_options',array(
        'type' => 'select',
        'label' => esc_html__('Post Sidebar Layout','vw-storefront'),
        'description' => esc_html__('Here you can change the sidebar layout for posts. ','vw-storefront'),
        'section' => 'vw_storefront_left_right',
        'choices' => array(
            'Left Sidebar' => esc_html__('Left Sidebar','vw-storefront'),
            'Right Sidebar' => esc_html__('Right Sidebar','vw-storefront'),
           	'One Column' => esc_html__('One Column','vw-storefront'),
            'Three Columns' => esc_html__('Three Columns','vw-storefront'),
            'Four Columns' => esc_html__('Four Columns','vw-storefront'),
            'Grid Layout' => esc_html__('Grid Layout','vw-storefront')
        ),
	) );

	$wp_customize->add_setting('vw_storefront_page_layout',array(
        'default' => 'One Column',
        'sanitize_callback' => 'vw_storefront_sanitize_choices'
	));
	$wp_customize->add_control('vw_storefront_page_layout',array(
        'type' => 'select',
        'label' => esc_html__('Page Sidebar Layout','vw-storefront'),
        'description' => esc_html__('Here you can change the sidebar layout for pages. ','vw-storefront'),
        'section' => 'vw_storefront_left_right',
        'choices' => array(
            'Left Sidebar' => esc_html__('Left Sidebar','vw-storefront'),
            'Right Sidebar' => esc_html__('Right Sidebar','vw-storefront'),
            'One Column' => esc_html__('One Column','vw-storefront')
        ),
	) );

    //Woocommerce Shop Page Sidebar
	$wp_customize->add_setting( 'vw_storefront_woocommerce_shop_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_storefront_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Storefront_Toggle_Switch_Custom_Control( $wp_customize, 'vw_storefront_woocommerce_shop_page_sidebar',array(
		'label' => esc_html__( 'Shop Page Sidebar','vw-storefront' ),
		'section' => 'vw_storefront_left_right'
    )));

    //Woocommerce Single Product page Sidebar
	$wp_customize->add_setting( 'vw_storefront_woocommerce_single_product_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_storefront_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Storefront_Toggle_Switch_Custom_Control( $wp_customize, 'vw_storefront_woocommerce_single_product_page_sidebar',array(
		'label' => esc_html__( 'Single Product Sidebar','vw-storefront' ),
		'section' => 'vw_storefront_left_right'
    )));

    //Pre-Loader
	$wp_customize->add_setting( 'vw_storefront_loader_enable',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_storefront_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Storefront_Toggle_Switch_Custom_Control( $wp_customize, 'vw_storefront_loader_enable',array(
        'label' => esc_html__( 'Pre-Loader','vw-storefront' ),
        'section' => 'vw_storefront_left_right'
    )));

	$wp_customize->add_setting('vw_storefront_loader_icon',array(
        'default' => 'Two Way',
        'sanitize_callback' => 'vw_storefront_sanitize_choices'
	));
	$wp_customize->add_control('vw_storefront_loader_icon',array(
        'type' => 'select',
        'label' => esc_html__('Pre-Loader Type','vw-storefront'),
        'section' => 'vw_storefront_left_right',
        'choices' => array(
            'Two Way' => esc_html__('Two Way','vw-storefront'),
            'Dots' => esc_html__('Dots','vw-storefront'),
            'Rotate' => esc_html__('Rotate','vw-storefront')
        ),
	) );

	//Top Header
	$wp_customize->add_section( 'vw_storefront_top_header' , array(
    	'title' => esc_html__( 'Top Header', 'vw-storefront' ),
		'panel' => 'vw_storefront_panel_id'
	) );

	$wp_customize->add_setting('vw_storefront_email_address',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_email'
	));	
	$wp_customize->add_control('vw_storefront_email_address',array(
		'label'	=> esc_html__('Email Address','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'support@123.com', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_top_header',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_storefront_location',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('vw_storefront_location',array(
		'label'	=> esc_html__('Location','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '78 lorem ipsum is a dummy text', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_top_header',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_storefront_discount_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('vw_storefront_discount_text',array(
		'label'	=> esc_html__('Discount Text','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Summer lorem ipsum is a "discount" text', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_top_header',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_storefront_phone_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('vw_storefront_phone_text',array(
		'label'	=> esc_html__('Phone Text','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Need Help Ordering ?', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_top_header',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_storefront_phone_number',array(
		'default'=> '',
		'sanitize_callback'	=> 'vw_storefront_sanitize_phone_number'
	));	
	$wp_customize->add_control('vw_storefront_phone_number',array(
		'label'	=> esc_html__('Phone Number','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '+00 123 456 7890', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_top_header',
		'type'=> 'text'
	));
    
	//Slider
	$wp_customize->add_section( 'vw_storefront_slidersettings' , array(
    	'title' => esc_html__( 'Slider Settings', 'vw-storefront' ),
		'panel' => 'vw_storefront_panel_id'
	) );

	$wp_customize->add_setting( 'vw_storefront_slider_arrows',array(
    	'default' => 0,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'vw_storefront_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Storefront_Toggle_Switch_Custom_Control( $wp_customize, 'vw_storefront_slider_arrows',array(
      	'label' => esc_html__( 'Show / Hide Slider','vw-storefront' ),
      	'section' => 'vw_storefront_slidersettings'
    )));

    //Selective Refresh
    $wp_customize->selective_refresh->add_partial('vw_storefront_slider_arrows',array(
		'selector'        => '#slider .carousel-caption h1',
		'render_callback' => 'vw_storefront_customize_partial_vw_storefront_slider_arrows',
	));

	for ( $count = 1; $count <= 4; $count++ ) {
		$wp_customize->add_setting( 'vw_storefront_slider_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'vw_storefront_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'vw_storefront_slider_page' . $count, array(
			'label'    => esc_html__( 'Select Slider Page', 'vw-storefront' ),
			'description' => esc_html__('Slider image size (1400 x 550)','vw-storefront'),
			'section'  => 'vw_storefront_slidersettings',
			'type'     => 'dropdown-pages'
		) );
	}

	//content layout
	$wp_customize->add_setting('vw_storefront_slider_content_option',array(
        'default' => 'Left',
        'sanitize_callback' => 'vw_storefront_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Storefront_Image_Radio_Control($wp_customize, 'vw_storefront_slider_content_option', array(
        'type' => 'select',
        'label' => esc_html__('Slider Content Layouts','vw-storefront'),
        'section' => 'vw_storefront_slidersettings',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/slider-content1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/slider-content2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/slider-content3.png',
    ))));

    //Slider excerpt
	$wp_customize->add_setting( 'vw_storefront_slider_excerpt_number', array(
		'default'              => 8,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_storefront_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'vw_storefront_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Excerpt length','vw-storefront' ),
		'section'     => 'vw_storefront_slidersettings',
		'type'        => 'range',
		'settings'    => 'vw_storefront_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );
 
	//Product Section
	$wp_customize->add_section('vw_storefront_product_section',array(
		'title'	=> esc_html__('Featured Product Section','vw-storefront'),
		'panel' => 'vw_storefront_panel_id',
	));

	$wp_customize->add_setting('vw_storefront_section_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('vw_storefront_section_text',array(
		'label'	=> esc_html__('Section Text','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Shop & Explore', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_product_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_storefront_product_settings' , array(
		'default' => '',
		'sanitize_callback' => 'vw_storefront_sanitize_dropdown_pages'
	) );
	$wp_customize->add_control( 'vw_storefront_product_settings' , array(
		'label'    => esc_html__( 'Select Produt Page', 'vw-storefront' ),
		'section'  => 'vw_storefront_product_section',
		'type'     => 'dropdown-pages'
	) );

	//Blog Post
	$wp_customize->add_panel( $vw_storefront_parent_panel );

	$BlogPostParentPanel = new VW_Storefront_WP_Customize_Panel( $wp_customize, 'blog_post_parent_panel', array(
		'title' => esc_html__( 'Blog Post Settings', 'vw-storefront' ),
		'panel' => 'vw_storefront_panel_id',
	));

	$wp_customize->add_panel( $BlogPostParentPanel );

	// Add example section and controls to the middle (second) panel
	$wp_customize->add_section( 'vw_storefront_post_settings', array(
		'title' => esc_html__( 'Post Settings', 'vw-storefront' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_storefront_toggle_postdate', array( 
		'selector' => '.post-main-box h2 a', 
		'render_callback' => 'vw_storefront_customize_partial_vw_storefront_toggle_postdate', 
	));

	$wp_customize->add_setting( 'vw_storefront_toggle_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_storefront_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Storefront_Toggle_Switch_Custom_Control( $wp_customize, 'vw_storefront_toggle_postdate',array(
        'label' => esc_html__( 'Post Date','vw-storefront' ),
        'section' => 'vw_storefront_post_settings'
    )));

    $wp_customize->add_setting( 'vw_storefront_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_storefront_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Storefront_Toggle_Switch_Custom_Control( $wp_customize, 'vw_storefront_toggle_author',array(
		'label' => esc_html__( 'Author','vw-storefront' ),
		'section' => 'vw_storefront_post_settings'
    )));

    $wp_customize->add_setting( 'vw_storefront_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_storefront_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Storefront_Toggle_Switch_Custom_Control( $wp_customize, 'vw_storefront_toggle_comments',array(
		'label' => esc_html__( 'Comments','vw-storefront' ),
		'section' => 'vw_storefront_post_settings'
    )));

    $wp_customize->add_setting( 'vw_storefront_toggle_tags',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_storefront_switch_sanitization'
	));
    $wp_customize->add_control( new VW_Storefront_Toggle_Switch_Custom_Control( $wp_customize, 'vw_storefront_toggle_tags', array(
		'label' => esc_html__( 'Tags','vw-storefront' ),
		'section' => 'vw_storefront_post_settings'
    )));

    $wp_customize->add_setting( 'vw_storefront_excerpt_number', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_storefront_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'vw_storefront_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','vw-storefront' ),
		'section'     => 'vw_storefront_post_settings',
		'type'        => 'range',
		'settings'    => 'vw_storefront_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Blog layout
    $wp_customize->add_setting('vw_storefront_blog_layout_option',array(
        'default' => 'Default',
        'sanitize_callback' => 'vw_storefront_sanitize_choices'
    ));
    $wp_customize->add_control(new VW_Storefront_Image_Radio_Control($wp_customize, 'vw_storefront_blog_layout_option', array(
        'type' => 'select',
        'label' => esc_html__('Blog Layouts','vw-storefront'),
        'section' => 'vw_storefront_post_settings',
        'choices' => array(
            'Default' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout2.png',
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout3.png',
    ))));

    $wp_customize->add_setting('vw_storefront_excerpt_settings',array(
        'default' => 'Excerpt',
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_storefront_sanitize_choices'
	));
	$wp_customize->add_control('vw_storefront_excerpt_settings',array(
        'type' => 'select',
        'label' => esc_html__('Post Content','vw-storefront'),
        'section' => 'vw_storefront_post_settings',
        'choices' => array(
        	'Content' => esc_html__('Content','vw-storefront'),
            'Excerpt' => esc_html__('Excerpt','vw-storefront'),
            'No Content' => esc_html__('No Content','vw-storefront')
        ),
	) );

	$wp_customize->add_setting('vw_storefront_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_excerpt_suffix',array(
		'label'	=> esc_html__('Add Excerpt Suffix','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '[...]', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_post_settings',
		'type'=> 'text'
	));

    // Button Settings
	$wp_customize->add_section( 'vw_storefront_button_settings', array(
		'title' => esc_html__( 'Button Settings', 'vw-storefront' ),
		'panel' => 'blog_post_parent_panel',
	));

	$wp_customize->add_setting('vw_storefront_button_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_button_padding_top_bottom',array(
		'label'	=> esc_html__('Padding Top Bottom','vw-storefront'),
		'description'	=> esc_html__('Enter a value in pixels. Example:20px','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '10px', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_storefront_button_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_button_padding_left_right',array(
		'label'	=> esc_html__('Padding Left Right','vw-storefront'),
		'description'	=> esc_html__('Enter a value in pixels. Example:20px','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '10px', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_storefront_button_border_radius', array(
		'default'              => 50,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_storefront_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'vw_storefront_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','vw-storefront' ),
		'section'     => 'vw_storefront_button_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_storefront_button_text', array( 
		'selector' => '.post-main-box .more-btn a', 
		'render_callback' => 'vw_storefront_customize_partial_vw_storefront_button_text', 
	));

    $wp_customize->add_setting('vw_storefront_button_text',array(
		'default'=> esc_html__( 'READ MORE', 'vw-storefront' ),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_button_text',array(
		'label'	=> esc_html__('Add Button Text','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'READ MORE', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_button_settings',
		'type'=> 'text'
	));

	// Related Post Settings
	$wp_customize->add_section( 'vw_storefront_related_posts_settings', array(
		'title' => esc_html__( 'Related Posts Settings', 'vw-storefront' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_storefront_related_post_title', array( 
		'selector' => '.related-post h3', 
		'render_callback' => 'vw_storefront_customize_partial_vw_storefront_related_post_title', 
	));

    $wp_customize->add_setting( 'vw_storefront_related_post',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_storefront_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Storefront_Toggle_Switch_Custom_Control( $wp_customize, 'vw_storefront_related_post',array(
		'label' => esc_html__( 'Related Post','vw-storefront' ),
		'section' => 'vw_storefront_related_posts_settings'
    )));

    $wp_customize->add_setting('vw_storefront_related_post_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_related_post_title',array(
		'label'	=> esc_html__('Add Related Post Title','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Related Post', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_related_posts_settings',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('vw_storefront_related_posts_count',array(
		'default'=> '3',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_related_posts_count',array(
		'label'	=> esc_html__('Add Related Post Count','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '3', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_related_posts_settings',
		'type'=> 'number'
	));

    //404 Page Setting
	$wp_customize->add_section('vw_storefront_404_page',array(
		'title'	=> esc_html__('404 Page Settings','vw-storefront'),
		'panel' => 'vw_storefront_panel_id',
	));	

	$wp_customize->add_setting('vw_storefront_404_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_storefront_404_page_title',array(
		'label'	=> esc_html__('Add Title','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '404 Not Found', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_storefront_404_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_storefront_404_page_content',array(
		'label'	=> esc_html__('Add Text','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_storefront_404_page_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_404_page_button_text',array(
		'label'	=> esc_html__('Add Button Text','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'GO BACK', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_404_page',
		'type'=> 'text'
	));

	//Social Icon Setting
	$wp_customize->add_section('vw_storefront_social_icon_settings',array(
		'title'	=> esc_html__('Social Icons Settings','vw-storefront'),
		'panel' => 'vw_storefront_panel_id',
	));	

	$wp_customize->add_setting('vw_storefront_social_icon_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_social_icon_font_size',array(
		'label'	=> esc_html__('Icon Font Size','vw-storefront'),
		'description'	=> esc_html__('Enter a value in pixels. Example:20px','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '10px', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_storefront_social_icon_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_social_icon_padding',array(
		'label'	=> esc_html__('Icon Padding','vw-storefront'),
		'description'	=> esc_html__('Enter a value in pixels. Example:20px','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '10px', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_storefront_social_icon_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_social_icon_width',array(
		'label'	=> esc_html__('Icon Width','vw-storefront'),
		'description'	=> esc_html__('Enter a value in pixels. Example:20px','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '10px', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_storefront_social_icon_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_social_icon_height',array(
		'label'	=> esc_html__('Icon Height','vw-storefront'),
		'description'	=> esc_html__('Enter a value in pixels. Example:20px','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '10px', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_storefront_social_icon_border_radius', array(
		'default'              => '',
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_storefront_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'vw_storefront_social_icon_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','vw-storefront' ),
		'section'     => 'vw_storefront_social_icon_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Responsive Media Settings
	$wp_customize->add_section('vw_storefront_responsive_media',array(
		'title'	=> esc_html__('Responsive Media','vw-storefront'),
		'panel' => 'vw_storefront_panel_id',
	));

    $wp_customize->add_setting( 'vw_storefront_resp_slider_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_storefront_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Storefront_Toggle_Switch_Custom_Control( $wp_customize, 'vw_storefront_resp_slider_hide_show',array(
      'label' => esc_html__( 'Show / Hide Slider','vw-storefront' ),
      'section' => 'vw_storefront_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_storefront_sidebar_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_storefront_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Storefront_Toggle_Switch_Custom_Control( $wp_customize, 'vw_storefront_sidebar_hide_show',array(
      'label' => esc_html__( 'Show / Hide Sidebar','vw-storefront' ),
      'section' => 'vw_storefront_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_storefront_resp_scroll_top_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_storefront_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Storefront_Toggle_Switch_Custom_Control( $wp_customize, 'vw_storefront_resp_scroll_top_hide_show',array(
      'label' => esc_html__( 'Show / Hide Scroll To Top','vw-storefront' ),
      'section' => 'vw_storefront_responsive_media'
    )));

    $wp_customize->add_setting('vw_storefront_res_menu_open_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Storefront_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_storefront_res_menu_open_icon',array(
		'label'	=> esc_html__('Add Open Menu Icon','vw-storefront'),
		'transport' => 'refresh',
		'section'	=> 'vw_storefront_responsive_media',
		'setting'	=> 'vw_storefront_res_menu_open_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_storefront_res_menu_close_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Storefront_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_storefront_res_menu_close_icon',array(
		'label'	=> esc_html__('Add Close Menu Icon','vw-storefront'),
		'transport' => 'refresh',
		'section'	=> 'vw_storefront_responsive_media',
		'setting'	=> 'vw_storefront_res_menu_close_icon',
		'type'		=> 'icon'
	)));

	//Footer Text
	$wp_customize->add_section('vw_storefront_footer',array(
		'title'	=> esc_html__('Footer Settings','vw-storefront'),
		'panel' => 'vw_storefront_panel_id',
	));	

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_storefront_footer_text', array( 
		'selector' => '.copyright p', 
		'render_callback' => 'vw_storefront_customize_partial_vw_storefront_footer_text', 
	));
	
	$wp_customize->add_setting('vw_storefront_footer_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('vw_storefront_footer_text',array(
		'label'	=> esc_html__('Copyright Text','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Copyright 2019, .....', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_storefront_copyright_alingment',array(
        'default' => 'center',
        'sanitize_callback' => 'vw_storefront_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Storefront_Image_Radio_Control($wp_customize, 'vw_storefront_copyright_alingment', array(
        'type' => 'select',
        'label' => esc_html__('Copyright Alignment','vw-storefront'),
        'section' => 'vw_storefront_footer',
        'settings' => 'vw_storefront_copyright_alingment',
        'choices' => array(
            'left' => esc_url(get_template_directory_uri()).'/assets/images/copyright1.png',
            'center' => esc_url(get_template_directory_uri()).'/assets/images/copyright2.png',
            'right' => esc_url(get_template_directory_uri()).'/assets/images/copyright3.png'
    ))));

    $wp_customize->add_setting('vw_storefront_copyright_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_copyright_padding_top_bottom',array(
		'label'	=> esc_html__('Copyright Padding Top Bottom','vw-storefront'),
		'description'	=> esc_html__('Enter a value in pixels. Example:20px','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '10px', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_storefront_footer_scroll',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'vw_storefront_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Storefront_Toggle_Switch_Custom_Control( $wp_customize, 'vw_storefront_footer_scroll',array(
      	'label' => esc_html__( 'Show / Hide Scroll to Top','vw-storefront' ),
      	'section' => 'vw_storefront_footer'
    )));

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_storefront_scroll_to_top_icon', array( 
		'selector' => '.scrollup i', 
		'render_callback' => 'vw_storefront_customize_partial_vw_storefront_scroll_to_top_icon', 
	));

    $wp_customize->add_setting('vw_storefront_scroll_to_top_icon',array(
		'default'	=> 'fas fa-long-arrow-alt-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Storefront_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_storefront_scroll_to_top_icon',array(
		'label'	=> esc_html__('Add Scroll to Top Icon','vw-storefront'),
		'transport' => 'refresh',
		'section'	=> 'vw_storefront_footer',
		'setting'	=> 'vw_storefront_scroll_to_top_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_storefront_scroll_to_top_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_scroll_to_top_font_size',array(
		'label'	=> esc_html__('Icon Font Size','vw-storefront'),
		'description'	=> esc_html__('Enter a value in pixels. Example:20px','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '10px', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_storefront_scroll_to_top_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_scroll_to_top_padding',array(
		'label'	=> esc_html__('Icon Top Bottom Padding','vw-storefront'),
		'description'	=> esc_html__('Enter a value in pixels. Example:20px','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '10px', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_storefront_scroll_to_top_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_scroll_to_top_width',array(
		'label'	=> esc_html__('Icon Width','vw-storefront'),
		'description'	=> esc_html__('Enter a value in pixels Example:20px','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '10px', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_storefront_scroll_to_top_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_storefront_scroll_to_top_height',array(
		'label'	=> esc_html__('Icon Height','vw-storefront'),
		'description'	=> esc_html__('Enter a value in pixels. Example:20px','vw-storefront'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '10px', 'vw-storefront' ),
        ),
		'section'=> 'vw_storefront_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_storefront_scroll_to_top_border_radius', array(
		'default'              => 50,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_storefront_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'vw_storefront_scroll_to_top_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','vw-storefront' ),
		'section'     => 'vw_storefront_footer',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

    $wp_customize->add_setting('vw_storefront_scroll_top_alignment',array(
        'default' => 'Right',
        'sanitize_callback' => 'vw_storefront_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Storefront_Image_Radio_Control($wp_customize, 'vw_storefront_scroll_top_alignment', array(
        'type' => 'select',
        'label' => esc_html__('Scroll To Top','vw-storefront'),
        'section' => 'vw_storefront_footer',
        'settings' => 'vw_storefront_scroll_top_alignment',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/layout2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/layout3.png'
    ))));

    // Has to be at the top
	$wp_customize->register_panel_type( 'VW_Storefront_WP_Customize_Panel' );
	$wp_customize->register_section_type( 'VW_Storefront_WP_Customize_Section' );
}

add_action( 'customize_register', 'vw_storefront_customize_register' );

if ( class_exists( 'WP_Customize_Panel' ) ) {
  	class VW_Storefront_WP_Customize_Panel extends WP_Customize_Panel {
	    public $panel;
	    public $type = 'vw_storefront_panel';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;
	      return $array;
    	}
  	}
}

if ( class_exists( 'WP_Customize_Section' ) ) {
  	class VW_Storefront_WP_Customize_Section extends WP_Customize_Section {
	    public $section;
	    public $type = 'vw_storefront_section';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;

	      if ( $this->panel ) {
	        $array['customizeAction'] = sprintf( 'Customizing &#9656; %s', esc_html( $this->manager->get_panel( $this->panel )->title ) );
	      } else {
	        $array['customizeAction'] = 'Customizing';
	      }
	      return $array;
    	}
  	}
}

// Enqueue our scripts and styles
function vw_storefront_customize_controls_scripts() {
  wp_enqueue_script( 'vw-storefront-customizer-controls', get_theme_file_uri( '/assets/js/customizer-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'vw_storefront_customize_controls_scripts' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class VW_Storefront_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	*/
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'VW_Storefront_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section( new VW_Storefront_Customize_Section_Pro( $manager,'vw_storefront_upgrade_pro_link', array(
			'priority'   => 1,
			'title'    => esc_html__( 'VW Storefront Pro', 'vw-storefront' ),
			'pro_text' => esc_html__( 'UPGRADE PRO', 'vw-storefront' ),
			'pro_url'  => esc_url('https://www.vwthemes.com/themes/storefront-wordpress-theme/'),
		)));

		$manager->add_section(new VW_Storefront_Customize_Section_Pro($manager,'vw_storefront_get_started_link',array(
			'priority'   => 1,
			'title'    => esc_html__( 'DOCUMENTATION', 'vw-storefront' ),
			'pro_text' => esc_html__( 'DOCS', 'vw-storefront' ),
			'pro_url'  => admin_url('themes.php?page=vw_storefront_guide'),
		)));
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'vw-storefront-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'vw-storefront-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
VW_Storefront_Customize::get_instance();