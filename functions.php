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

		// Add support for content width
		add_theme_support( 'content-width', 680 );

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );
	}
} // twentyfourteen_setup
add_action( 'after_setup_theme', 'dswoddil_setup' );

function dswoddil_check_for_updates($transient) {
	if (empty($transient->checked['dsw-oddil'])) {
		return $transient;
	}
	$opts = array(
		'http'=>array(
			'method'=>"GET",
			'header'=>"User-Agent: skaut\r\n"
		)
	);
	$context = stream_context_create($opts);

	$actual = json_decode(file_get_contents('https://api.github.com/repos/skaut/dsw-oddil/releases/latest', false, $context));
	$asset = null;
	foreach ($actual->assets as $a) {
		if (preg_match('/dsw-oddil-\d+\.\d+\.\d+-compiled\.zip/', $a->name) === 1) {
			$asset = $a;
		}
	}
	if (!empty($asset) && version_compare($transient->checked['dsw-oddil'], ltrim($actual->tag_name, 'v'), '<')) {
		$transient->response['dsw-oddil'] = ['new_version' => ltrim($actual->tag_name, 'v'), 'url' => $actual->html_url, 'package' => $asset->browser_download_url];
	}
	return $transient;
}

add_filter('pre_set_site_transient_update_themes', 'dswoddil_check_for_updates');


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function dswoddil_content_width() {
	//$GLOBALS['content_width'] = apply_filters( 'dswoddil_content_width', 680 );
	if ( ! isset( $content_width ) ) {
		$content_width = 680;
	}
}
add_action( 'after_setup_theme', 'dswoddil_content_width', 0 );

/**
 * Loading stylesheets.
 *
 * @since DSW oddil 1.0
 */
function dswoddil_load_styles() {
	// Main style for this theme
	wp_enqueue_style( 'dsw-oddil-style', get_stylesheet_uri(), array(), '20160424' );
	// wp_enqueue_style(
	// 	'dswoddil_stylesheet',
	// 	get_template_directory_uri() . '/css/' . ( ( dswoddil_get_dev_enviroment() <> 1 ) ? 'combined' : 'combined.min' ) .'.css',
	// 	array(),
	// 	'20151212'
	// );
}

/**
 * Loading scripts.
 *
 * @since DSW oddil 1.0
 */
function dswoddil_load_scripts() {
	if( !is_admin() ) {
		wp_enqueue_script( 'jquery' );
	}
	// Register the script like this for a theme - after jquery
	wp_register_script(
		'bootstrap',
		get_template_directory_uri() . '/js/bootstrap.js',
		array( 'jquery' ),
		'3.3.6',
		true
	);
	// For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'bootstrap' );

	wp_enqueue_script(
		'dswoddil_navigation',
		get_template_directory_uri() . '/js/navigation.js',
		array(),
		'20150809',
		true
	);

	wp_enqueue_script(
		'dswoddil_skip_link_focus_fix',
		get_template_directory_uri() . '/js/skip-link-focus-fix.js',
		array(),
		'20150809',
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

/**
 * Conditionally Enqueue Script for IE browsers less than IE 9
 *
 * @link http://php.net/manual/en/function.version-compare.php
 * @uses wp_check_browser_version()
 */
function dswoddil_enqueue_lt_ie9() {
	global $is_IE;

	// Return early, if not IE
	if ( ! $is_IE ) {
		return;
	}

	// Include the file, if needed
	if ( ! function_exists( 'wp_check_browser_version' ) ) {
		include_once( ABSPATH . 'wp-admin/includes/dashboard.php' );
	}

	// IE version conditional enqueue
	$response = wp_check_browser_version();
	if ( 0 > version_compare( intval( $response['version'] ) , 9 ) ) {
		wp_enqueue_script( 'dswoddil-html5shim', get_template_directory_uri() . '/js/html5.js', array(), '20151029', true );
	}
}

add_action( 'wp_enqueue_scripts', 'dswoddil_load_styles' );
add_action( 'wp_enqueue_scripts', 'dswoddil_load_scripts' );
add_action( 'wp_enqueue_scripts', 'dswoddil_enqueue_lt_ie9' );

// Load up our theme widget options.
require_once get_template_directory() . '/inc/widgets.php';

// Load up our theme options page and related code.
require_once get_template_directory() . '/inc/theme-options.php';

// Implement Custom Header features.
require_once get_template_directory() . '/inc/custom-header.php';

// Custom template tags for this theme.
require_once get_template_directory() . '/inc/template-tags.php';

// Register Custom Navigation Walker
require_once get_template_directory() . '/inc/bootstrap-navwalker.php';

// Add Theme Customizer functionality.
require_once get_template_directory() . '/inc/customizer.php';

// Custom functions that act independently of the theme templates.
require_once get_template_directory() . '/inc/extras.php';

// Load Jetpack compatibility file.
require_once get_template_directory() . '/inc/jetpack.php';

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

/**
 * Filter for adding aditional icon siye.
 *
 * @since DSW oddil 1.0
 *
 * @return array Site icon sizes.
 */
function dswoddil_custom_site_icon_size( $sizes ) {
	$sizes[] = 45;

	return $sizes;
}
add_filter( 'site_icon_image_sizes', 'dswoddil_custom_site_icon_size' );

/**
 * Header brand creator.
 *
 * @since DSW oddil 1.0
 * @param bool	Whether to return value or print it.
 *
 * @return string Html of site icon with link.
 */
function dswoddil_custom_brand_icon( $return = false ) {
	$brand_icon = sprintf( '<img class="attachment-full alignleft" src="%s" width="45" height="45" alt="%s" />', esc_url( get_site_icon_url( 45, null ) ), get_bloginfo( 'name' ) );

	$brand = sprintf( '<a href="/" id="" target="_self" class="widget_sp_image-image-link" title="%s">', get_bloginfo( 'name' ) );
	$brand .= $brand_icon;
	$brand .= '</a>';

	if ( $return ) {
		return $brand;
	} else {
		echo $brand;
	}
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
	get_template_part( $template_name, $part_name );
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
