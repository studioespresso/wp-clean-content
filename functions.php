<?php
/**
 * Clean Content functions and definitions
 *
 * @package Clean Content
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'clean_content_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function clean_content_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Clean Content, use a find and replace
	 * to change 'clean-content' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'clean-content', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'clean-content' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'clean_content_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // clean_content_setup
add_action( 'after_setup_theme', 'clean_content_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function clean_content_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'clean-content' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'clean_content_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function clean_content_scripts() {
	wp_enqueue_style( 'clean-content-style', get_stylesheet_uri() );

	wp_enqueue_script( 'clean-content-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'clean-content-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'clean_content_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


function cc_register_theme_customizer( $wp_customize ) {
    $wp_customize->add_section( 'cc_layout' , array(
        'title'      => __('Layout','clean-content'),
        'priority'   => 130,
    ) );

    $wp_customize->add_setting(
    	'cc_sidebar_control',
    	array (
    		'default'	=> 'sidebar-left',
    		)
    	);
    $wp_customize->add_control(
		'sidebar_control', array(
    			'label'		=>__('Sidebar Position', 'clean-content'),
    			'type'		=> 'radio',
    			'choices'	=> array(
    				'sidebar-left' => __('Sidebar on the left', 'clean-content'),
    				'sidebar-right' => __('Sidebar on the right', 'clean-content')
    				),
    			'section'	=> 'cc_layout',
    			'settings'	=> 'cc_sidebar_control'
    		)
    	);

    $wp_customize->add_setting(
    	'cc_show_tagline',
    	array (
    		'default' => 'y',)
    	);
    $wp_customize->add_control(
    	'show_tagline', array(
    		'label'		=> __('Hide tagline','clean-content'),
    		'type'		=> 'checkbox',
    		'section' 	=> 'title_tagline',
    		'settings'	=> 'cc_show_tagline',
    		)
    	);

    $wp_customize->add_setting(
    	'cc_sticky_menu',
    	array (
    		'default'	=> 'y',)
    	);
    $wp_customize->add_control(
    	'sticky_menu', array(
    		'label'		=> __('Sticky menu to top', 'clean-content'),
    		'section'	=> 'cc_layout',
    		'settings'	=> 'cc_sticky_menu',
    		'type'		=> 'checkbox',
    		)
    	);
}

function cleancontent_layout_classes( $classes ) {
	$options = get_theme_mod('cc_sidebar_control');
	if ($options && 'sidebar-left' == $options)
		$classes[] = $options;

	return $classes;
}
add_filter( 'body_class', 'cleancontent_layout_classes' );

add_action( 'customize_register', 'cc_register_theme_customizer' );

function cc_customizer_css() {
    ?>
    <style type="text/css">
        a { color: <?php echo get_theme_mod( 'cc_link_color' ); ?>; }
    </style>
    <?php
}
add_action( 'wp_head', 'cc_customizer_css' );

function cc_customizer_live_preview() {
 
    wp_enqueue_script(
        'cc-theme-customizer',
        get_template_directory_uri() . '/js/theme-customizer.js',
        array( 'jquery', 'customize-preview' ),
        '0.3.0',
        true
    );
 
}
add_action( 'customize_preview_init', 'cc_customizer_live_preview' );