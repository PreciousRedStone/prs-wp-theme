<?php
/**
 * prs functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package prs
 */

if ( ! function_exists( 'prs_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function prs_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on prs, use a find and replace
		 * to change 'prs' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'prs', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'prs-thumbnails', 250, 150, array('cetner','center') );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'prs_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 256,
			'width'       => 80,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// Register nav menus
		register_nav_menus( array(
			'header-nav' => esc_html__( 'Header', 'prs' ),
			'footer-nav' => esc_html__( 'Footer', 'prs' ),
			'social-nav' => esc_html__( 'Social', 'prs' )
		) );

		add_filter( 'nav_menu_css_class', 'prs_nav_items_custom_class', 10, 3 );
		function prs_nav_items_custom_class( $classes, $menuItem, $args ) {
			$customClasses = array('header__nav-item');

			if ( is_object( $args ) && $args->theme_location === 'header-nav' ) {
				if (in_array('current-menu-item', $classes) ) {
					$customClasses[] = 'header__nav-item--active';
				} else if (in_array('featured', $classes)) {
					$customClasses[] = 'header__nav-item--featured';
				}

				return $customClasses;
			}

			return $classes;
		}

		add_filter( 'nav_menu_link_attributes', 'prs_nav_items_anchor_custom_class', 100, 3 );
		function prs_nav_items_anchor_custom_class( $attr, $menuItem, $args ) {
			if ( is_object( $args ) && $args->theme_location === 'header-nav' ) {
				return array_merge( $attr, array( 'class' => 'header__nav-link' ) );
			}
			return $attr;
		}
	}
endif;
add_action( 'after_setup_theme', 'prs_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function prs_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'prs_content_width', 640 );
}
add_action( 'after_setup_theme', 'prs_content_width', 0 );

/**
 * Custom post type for public events
 */
function create_custom_post_type() {
	register_post_type( 'event',
		array(
			'labels' => array(
				'name' => __( 'Events' ),
				'singular_name' => __( 'Event' ),
				'add_new_item' => __( 'Add new Event' ),
				'edit_item' => __( 'Edit Event' ),
				'new_item' => __( 'New Event' ),
				'view_item' => __( 'View Event' ),
				'view_items' => __( 'View Events' ),
				'search_items' => __( 'Search Events' ),
				'not_found' => __( 'No events found' ),
				'not_found_in_trash' => __( 'No events found in Trash' ),
			),
			'public' => true,
			'has_archive' => true,
			'taxonomies' => array(
				'category'
			),
			'supports' => array(
				'title', 'excerpt', 'comments', 'revisions'
			)
		)
	);
}
add_action( 'init', 'create_custom_post_type' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function prs_widgets_init() {
	if (function_exists('register_sidebar')) {
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'prs' ),
			'id'            => 'prs-sidebar-primary',
			'description'   => esc_html__( 'Add widgets here.', 'prs' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
}
add_action( 'widgets_init', 'prs_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function prs_scripts() {
//	wp_enqueue_style( 'prs-webfonts', 'https://fonts.googleapis.com/css?family=Montserrat:700|Roboto:400,500' );
	wp_enqueue_style( 'prs-style', get_stylesheet_uri() );
	wp_enqueue_script('prs-vendor-script', get_template_directory_uri() . '/assets/js/lib/vendor.js', array(), '14112017', true);
	wp_enqueue_script('prs-script', get_template_directory_uri() . '/assets/js/main.js', array(), '14112017', true);
//	wp_enqueue_script( 'prs-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
//	wp_enqueue_script( 'prs-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'prs_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


define('PRS_VERSION', '1.0.0');
define('PRS_PRODUCTION', 'preciousredstone.com');
define('PRS_ENV', getenv('WP_ENV'));

//add_filter( 'show_admin_bar', '__return_false' );
add_theme_support('automatic-feed-links' );
add_theme_support('post-thumbnails');
add_theme_support('post-formats', array('image', 'video', 'audio', 'gallery'));
add_theme_support('custom-background', apply_filters('twentyfourteen_custom_background_args', array(
	'default-color' => 'cc3300'
)));

add_filter('user_contactmethods', 'set_custom_contactmethod', 10, 1);
function set_custom_contactmethod($contactmethods) {
	$contactmethods['instagram'] = 'Instagram';
	$contactmethods['facebook'] = 'Facebook';
	$contactmethods['twitter'] = 'Twitter';
	$contactmethods['gplus'] = 'Google Plus';
	unset($contactmethods['yim']);
	unset($contactmethods['jabber']);
	unset($contactmethods['aim']);
	return $contactmethods;
}

add_filter('excerpt_more', 'prs_excerpt_more');
function prs_excerpt_more($more) {
	global $post;
	$newMore = '...';
	$newMore .= '<p class="prs-read-more">';
	$newMore .= '<a class="btn btn-sm btn-success" href="' . get_the_permalink($post->id) . '" rel="bookmark">Read more...</a>';
	$newMore .= '</p>';
	return $newMore;
}

add_action( 'send_headers', 'prs_header_xua' );
function prs_header_xua() {
	header('X-UA-Compatible: IE=edge,chrome=1');
}


// remove p tag from category description
remove_filter('term_description', 'wpautop');

// remove generator information
add_filter('the_generator', '__return_empty_string');
