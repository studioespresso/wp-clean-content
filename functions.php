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
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 672, 372, true );
    add_image_size( 'clean-content-full-width', 1038, 576, true );

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

// This theme uses its own gallery styles.
add_filter( 'use_default_gallery_style', '__return_false' );
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

add_action( 'init', 'cd_add_editor_styles' );
/**
 * Apply theme's stylesheet to the visual editor.
 *
 * @uses add_editor_style() Links a stylesheet to visual editor
 * @uses get_stylesheet_uri() Returns URI of theme stylesheet
 */
function cd_add_editor_styles() {
 
    add_editor_style( get_stylesheet_uri() );
 
}


/*-----------------------------------------------------------------------------
  RSS modification handling functions
-----------------------------------------------------------------------------*/
// Remove automatic links to feeds
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

// Disable automatic feeds
remove_action( 'do_feed_rdf', 'do_feed_rdf', 10, 1 );
remove_action( 'do_feed_rss', 'do_feed_rss', 10, 1 );
remove_action( 'do_feed_rss2', 'do_feed_rss2', 10, 1 );
remove_action( 'do_feed_atom', 'do_feed_atom', 10, 1 );

function create_custom_feed() {
    load_template( get_template_directory() . '/feed-rss2.php');
}
add_action('do_feed_custom_feed', 'create_custom_feed', 10, 1);

function customise_feed_rules($rules) {
    // Remove all feed related rules
    $filtered_rules = array_filter($rules, function($rule) {
        return !preg_match("/feed/i", $rule);
    });
    // Add the rule(s) for your custom feed(s)
    $new_rules = array(
        'feed\.xml$' => 'index.php?feed=custom_feed'
    );
    return $new_rules + $filtered_rules;
}

function add_custom_feed() {
    global $wp_rewrite;
    add_action('do_feed_custom_feed', 'create_custom_feed', 10, 1);
    add_filter('rewrite_rules_array','customise_feed_rules');
    $wp_rewrite->flush_rules();
}

add_action('init', 'add_custom_feed');

/*-----------------------------------------------------------------------------
  Theme customizer
-----------------------------------------------------------------------------*/
/** Add layout section**/
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
/** Colour control **/
    $wp_customize->add_setting(
            'cc_link_color',
            array(
                'default'     => '#0e2c6c'
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
    		'default' => 'y',)
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

/** Theme customize live preview **/

function cc_customizer_css() {
    ?>
    <style type="text/css">
        a, h1, h2, .menu-toggle { color: <?php echo get_theme_mod( 'cc_link_color' ); ?>; }
        .entry-meta a:hover, .nav-links, textarea, input, button, {background-color: <?php echo get_theme_mod( 'cc_link_color' ); ?>;}
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