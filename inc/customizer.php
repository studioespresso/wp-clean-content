<?php
/**
 * Clean Content Theme Customizer
 *
 * @package Clean Content
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function clean_content_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'clean_content_customize_register' );


function cc_register_theme_customizer( $wp_customize ) {
	$wp_customize->add_section( 'cc_layout' , array(
		'title'      => __('Layout','clean-content'),
		'priority'   => 130,
		) );
	/** Sidebar control **/
	$wp_customize->add_setting(
		'cc_sidebar_control',
		array (
			'default'	=> 'right',
			'sanitize_callback' => 'clean_content_sanitize_sidebar'
			)
		);
	$wp_customize->add_control(
		'sidebar_control', array(
			'label'		=>__('Sidebar Position', 'clean-content'),
			'type'		=> 'radio',
			'choices'	=> array(
				'left' => __('Sidebar on the left', 'clean-content'),
				'right' => __('Sidebar on the right', 'clean-content'),
				'nosidebar' => __('No sidebar', 'clean-content')
				),
			'section'	=> 'cc_layout',
			'settings'	=> 'cc_sidebar_control'
			)
		);
	/** Text colour control **/
	$wp_customize->add_setting(
		'cc_text_color',
		array(
			'default'     => '#4A525A',
			'sanitize_callback' => 'sanitize_hex_color'

			)
		);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'text_color',
			array(
				'label'      => __( 'Text Color', 'cc' ),
				'section'    => 'colors',
				'settings'   => 'cc_text_color'
				)
			)
		);

	/** Logo **/
	$wp_customize->add_setting('cc_logo_image',
		array(
			'sanitize_callback' => 'sanitize_file_name'
			)
		);
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cc_logo_image', array(
	    'label'    => __( 'Logo', 'clean-content' ),
	    'section'  => 'title_tagline',
	    'settings' => 'cc_logo_image',
	) ) );

	/**Link colour control **/
	$wp_customize->add_setting(
		'cc_link_color',
		array(
			'default'     => '#284a60',
			'sanitize_callback' => 'sanitize_hex_color'
			)
		);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_color',
			array(
				'label'      => __( 'Link Color', 'cc' ),
				'section'    => 'colors',
				'settings'   => 'cc_link_color'
				)
			)
		);
	/** Tagline control **/
	$wp_customize->add_setting(
		'cc_show_tagline',
		array (
			'default' => 'y',
			'sanitize_callback' => 'clean_content_sanitize_checkbox'
			)
		);
	$wp_customize->add_control(
		'show_tagline', array(
			'label'		=> __('Show tagline','clean-content'),
			'type'		=> 'checkbox',
			'section' 	=> 'title_tagline',
			'settings'	=> 'cc_show_tagline',
			)
		);
}
/** Adds body classes **/

function cleancontent_layout_classes( $classes ) {
    $options = get_theme_mod('cc_sidebar_control');
    if ($options && 'left' == $options)
        $classes[] = $options;
    if ($options && 'right' == $options)
        $classes[] = $options;
    if ($options && 'nosidebar' == $options)
        $classes[] = $options;
    return $classes;
}

add_filter( 'body_class', 'cleancontent_layout_classes' );
add_action( 'customize_register', 'cc_register_theme_customizer' );

function clean_content_sanitize_sidebar($value) {
    if ( ! isset($value) || ! in_array( $value, array( 'left', 'right', 'nosidebar' ) ) )
       $value = 'right';
    return $value;
}

function clean_content_sanitize_checkbox($value) {
	    if ( ! isset($value) || ! in_array( $value, array( 'true', 'false') ) )
	    	$value = false;
	    return $value;
}


/** Theme customize CSS **/
function cc_customizer_css() {
    ?>
    <style type="text/css">
        body, a {color: <?php echo wp_kses(get_theme_mod( 'cc_text_color')); ?>;}
        h1, h2, h1 a, h2 a, .menu-toggle { color: <?php echo wp_kses(get_theme_mod( 'cc_link_color' )); ?>; }
        .entry-meta a:hover, .nav-links, button, input[type="submit"] {background-color: <?php echo wp_kses(get_theme_mod( 'cc_link_color' )); ?>;}
    </style>
    <?php
}
add_action( 'wp_head', 'cc_customizer_css' );



/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function clean_content_customize_preview_js() {
	wp_enqueue_script( 'clean_content_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'clean_content_customize_preview_js' );
