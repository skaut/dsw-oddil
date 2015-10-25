<?php

/******************************************************************************
	THEME INITIALIZATION
******************************************************************************/

if ( ! function_exists( 'dswoddil_setup' ) ) {
	/**
	 * DSW oddil setup.
	 *
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support post thumbnails.
	 *
	 * @since DSW oddil 1.0
	 */
	function dswoddil_setup() {
		/*
		 * Make Twenty Fourteen available for translation.
		 *
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on Twenty Fourteen, use a find and
		 * replace to change 'twentyfourteen' to the name of your theme in all
		 * template files.
		 */
		load_theme_textdomain( 'dswoddil', get_template_directory() . '/languages' );

		// This theme styles the visual editor to resemble the theme style.
		// editor-style.css to match the theme style.
		add_editor_style();

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails, and declare two sizes.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 150, 150, true );
		//add_image_size( 'twentyfourteen-full-width', 1038, 576, true );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary'   => esc_html__( 'Top primary menu', 'dswoddil' ),
			'secondary' => esc_html__( 'Secondary menu in right sidebar', 'dswoddil' ),
		) );

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

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'audio',
			'quote',
			'link',
			'gallery',
		) );

		// This theme allows users to set a custom background.
		add_theme_support( 'custom-background', apply_filters( 'dswoddil_custom_background_args', array(
			'default-color' => 'f5f5f5',
			'defautt-image' => '',
		) ) );

		// Add support for featured content.
		add_theme_support( 'featured-content', array(
			'featured_content_filter' => 'dswoddil_get_featured_posts',
			'max_posts' => 6,
		) );

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );
	}
} // twentyfourteen_setup
add_action( 'after_setup_theme', 'dswoddil_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function dswoddil_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'dswoddil_content_width', 680 );
}
add_action( 'after_setup_theme', 'dswoddil_content_width', 0 );

/**
 * Loading stylesheets.
 *
 * @since DSW oddil 1.0
 */
function dswoddil_load_styles() {
	// Main style for this theme
	wp_enqueue_style( 'dsw-oddil-style', get_stylesheet_uri() );
	wp_enqueue_style(
		'dswoddil_stylesheet',
		get_template_directory_uri() . '/css/' . ( ( dswoddil_get_dev_enviroment() <> 1 ) ? 'combined' : 'combined.min' ) .'.css'
	);
}

/**
 * Loading scripts.
 *
 * @since DSW oddil 1.0
 */
function dswoddil_load_scripts() {
	// Register the script like this for a theme - after jquery
	wp_register_script(
		'dswoddil_bootstrap',
		get_template_directory_uri() . '/js/' . ( ( dswoddil_get_dev_enviroment() <> 1 ) ? 'bootstrap.js' : 'bootstrap.min.js' ) , array( 'jquery' )
	);
	// For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'dswoddil_bootstrap' );

	wp_enqueue_script( 'dswoddil_navigation',
		get_template_directory_uri() . '/js/navigation.js',
		array(),
		'20150809',
		true
	);

	wp_enqueue_script( 'dswoddil_skip_link_focus_fix',
		get_template_directory_uri() . '/js/skip-link-focus-fix.js',
		array(),
		'20150809',
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'dswoddil_load_styles' );
add_action( 'wp_enqueue_scripts', 'dswoddil_load_scripts' );

/**
 * Register three DSW oddil widget areas.
 *
 * @since DSW oddil 1.0
 */
function dswoddil_widgets_init() {
	//require get_template_directory() . '/inc/widgets.php';
	//register_widget( 'Twenty_Fourteen_Ephemera_Widget' );

	register_sidebar( array(
		'name'          => __( 'Header right widget', 'dswoddil' ),
		'id'            => 'header-right',
		'description'   => __( 'Widget that appears on the right in header.', 'dswoddil' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => __( 'Header left widget', 'dswoddil' ),
		'id'            => 'header-left',
		'description'   => __( 'Widget that appears on the left in header.', 'dswoddil' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => __( 'Area above content', 'dswoddil' ),
		'id'            => 'top-widget',
		'description'   => __( 'Appears above the content section of the site.', 'dswoddil' ),
		'before_widget' => '<div class="content">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Left Sidebar', 'dswoddil' ),
		'id'            => 'left-sidebar',
		'description'   => __( 'Main sidebar that appears on the left.', 'dswoddil' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Right Sidebar', 'dswoddil' ),
		'id'            => 'right-sidebar',
		'description'   => __( 'Additional sidebar that appears on the right.', 'dswoddil' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Area under content', 'dswoddil' ),
		'id'            => 'bottom-widget',
		'description'   => __( 'Appears in the bottom section of the site.', 'dswoddil' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s col-md-4"><div class="block">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'dswoddil' ),
		'id'            => 'footer',
		'description'   => __( 'Appears in the footer section of the site.', 'dswoddil' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'dswoddil_widgets_init' );

// Load up our theme options page and related code.
require_once get_template_directory() . '/inc/theme-options.php';

// Implement Custom Header features.
require_once get_template_directory() . '/inc/custom-header.php';

// Custom template tags for this theme.
require_once get_template_directory() . '/inc/template-tags.php';

// Register Custom Navigation Walker
require_once get_template_directory() . '/inc/wp-bootstrap-navwalker.php';

// Add Theme Customizer functionality.
require_once get_template_directory() . '/inc/customizer.php';

// Custom functions that act independently of the theme templates.
require_once get_template_directory() . '/inc/extras.php';

// Load Jetpack compatibility file.
require_once get_template_directory() . '/inc/jetpack.php';

// Set theme site icon.
require_once get_template_directory() . '/inc/site-icon.php';

/**
 * Getter function for Featured Content Plugin.
 *
 * @since DSW oddil 1.0
 *
 * @return array An array of WP_Post objects.
 */
function dswoddil_get_featured_posts() {
	/**
	 * Filter the featured posts to return in Twenty Fourteen.
	 *
	 * @since DSW oddil 1.0
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'dswoddil_get_featured_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @since DSW oddil 1.0
 *
 * @return bool Whether there are featured posts.
 */
function dswoddil_has_featured_posts() {
	return ! is_paged() && (bool) dswoddil_get_featured_posts();
}

/******************************************************************************
	HELPERS
******************************************************************************/

/**
 * Load template part into variable
 *
 * @since DSW oddil 1.0
 */
function dswoddil_load_template_part( $template_name, $part_name = null ) {
	ob_start();
	get_template_part($template_name, $part_name);
	$var = ob_get_contents();
	ob_end_clean();
	return $var;
}

/**
 * Get development environment key
 */
function dswoddil_get_dev_enviroment() {
	$environment = 1; // production
	if ( false !== stripos( $_SERVER['HTTP_HOST'], 'staging.' ) ) {
		$environment = 2; // dev/staging
	} elseif ( preg_match( '/localhost|127.0.0.1|.local/', $_SERVER['HTTP_HOST'] ) ) {
		$environment = 3; // local
	} elseif ( isset( $_GET['debug'] ) ) {
		$environment = 4; // manual override (for production, ie. example.com?debug)
	}

	return $environment;
}
