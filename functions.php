<?php

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since DSW oddil 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 680;
}

function dswoddil_wpbootstrap_scripts_with_jquery()
{
	// Register the script like this for a theme:
	wp_register_script( 'custom-script', get_template_directory_uri() . '/js/' . ((dswoddil_get_dev_enviroment() <> 1) ? 'bootstrap.js' : 'bootstrap.min.js') , array( 'jquery' ) );
	// For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'custom-script' );
}
add_action( 'wp_enqueue_scripts', 'dswoddil_wpbootstrap_scripts_with_jquery' );

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'id' => 'widget',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	)
);

if ( ! function_exists( 'dswoddil_setup' ) ) :
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
	//add_editor_style( array( 'css/editor-style.css', twentyfourteen_font_url() ) );

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
		'primary'   => __( 'Top primary menu', 'dswoddil' ),
		'secondary' => __( 'Secondary menu in right sidebar', 'dswoddil' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'dswoddil_custom_background_args', array(
		'default-color' => 'f5f5f5',
	) ) );

	// Add support for featured content.
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'dswoddil_get_featured_posts',
		'max_posts' => 6,
	) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
endif; // twentyfourteen_setup
add_action( 'after_setup_theme', 'dswoddil_setup' );

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
 * Register three DSW oddil widget areas.
 *
 * @since DSW oddil 1.0
 */
function dswoddil_widgets_init() {
	//require get_template_directory() . '/inc/widgets.php';
	//register_widget( 'Twenty_Fourteen_Ephemera_Widget' );

	register_sidebar( array(
		'name'          => __( 'Loga vpravo', 'dswoddil' ),
		'id'            => 'header-right',
		'description'   => __( 'Widget that appears on the right in header.', 'dswoddil' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => __( 'Loga vlevo', 'dswoddil' ),
		'id'            => 'header-left',
		'description'   => __( 'Widget that appears on the left in header.', 'dswoddil' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => __( 'Oblast nad obsahem', 'dswoddil' ),
		'id'            => 'above-content-widget',
		'description'   => __( 'Appears above the content section of the site.', 'dswoddil' ),
		'before_widget' => '<div class="content">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'dswoddil' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar that appears on the left.', 'dswoddil' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Content Sidebar', 'dswoddil' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Additional sidebar that appears on the right.', 'dswoddil' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Oblast pod obsahem', 'dswoddil' ),
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
		'description'   => __( 'Appears in the most bottom section of the site.', 'dswoddil' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'dswoddil_widgets_init' );

/******************************************************************************
	PLUGINS
******************************************************************************/

// Include the TGM_Plugin_Activation class.
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'dswoddil_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function dswoddil_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'      => 'Image Widget',
			'slug'      => 'image-widget',
			'required'  => true,
			'force_activation' => true,
		),
		array(
			'name'      => 'Tiled Galleries Carousel Without Jetpack',
			'slug'      => 'tiled-gallery-carousel-without-jetpack',
			'required'  => false,
		),
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'default_path' => '',                      // Default absolute path to pre-packaged plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
			'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
			'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
			'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);

	tgmpa( $plugins, $config );
}

// Implement Custom Header features.
require get_template_directory() . '/inc/custom-header.php';

// Custom template tags for this theme.
require_once get_template_directory() . '/inc/template-tags.php';

// Register Custom Navigation Walker
require_once get_template_directory() . '/inc/wp-bootstrap-navwalker.php';

// Add Theme Customizer functionality.
require get_template_directory() . '/inc/customizer.php';

$themename = "DSW Theme";
$shortname = "dsw";
$options = array (
array( "name" => "Style Sheet",
	"desc" => "Enter the Style Sheet you would like to use for DSW Theme",
	"id" => $shortname."_style_sheet",
	"type" => "select",
	"options" => array("default", "red", "blue", "violet", "green"),
	"std" => "blue"),
);

function dswoddil_add_admin() {
	global $themename, $shortname, $options;

	if (isset($_GET['page']) && ($_GET['page'] == basename(__FILE__))) {
		if ( isset($_REQUEST['action']) && ('save' == $_REQUEST['action']) ) {
			foreach ($options as $value) {
				update_option( $value['id'], $_REQUEST[ $value['id'] ] );
			}

			foreach ($options as $value) {
				if( isset( $_REQUEST[ $value['id'] ] ) ) {
					update_option( $value['id'], $_REQUEST[ $value['id'] ] );
				} else {
					delete_option( $value['id'] );
				}
			}

			header("Location: themes.php?page=functions.php&saved=true");
			die;
		} else if(isset($_REQUEST['action']) && ('reset' == $_REQUEST['action']) ) {
			foreach ($options as $value) {
				delete_option( $value['id'] );
			}
			header("Location: themes.php?page=functions.php&reset=true");
			die;
		}
	}

	add_theme_page($themename." Options", "".$themename." Options", 'edit_themes', basename(__FILE__), 'dswoddil_admin');
}

function dswoddil_admin() {
	global $themename, $shortname, $options;
	if (isset($_REQUEST['saved'])) {
		echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
	}
	if (isset($_REQUEST['reset'])) {
		echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
	}

	echo '<div class="wrap">';
	echo '<h2>'.$themename.' Settings</h2>';
	echo '<form method="post">';

	foreach ($options as $value) {
		switch ( $value['type'] ) {
			case "open":
				echo '<table width="100%" border="0" style="background-color:#eef5fb; padding:10px;">';
				break;
			case "close":
				echo '</table><br />';
				break;
			case "title":
				echo '<table width="100%" border="0" style="background-color:#dceefc; padding:5px 10px;"><tr>
	<td valign="top" colspan="2"><h3 style="font-family:Georgia,\'Times New Roman\',Times,serif;">'.$value['name'].'</h3></td>
	</tr>';
				echo '<!--custom-->';
				break;
			case "sub-title":
				echo '<h3 style="font-family:Georgia,\'Times New Roman\',Times,serif; padding-left:8px;">'.$value['name'].'</h3>';
				echo '<!--end-of-custom-->';
				break;
			case 'text':
				echo '<tr>
	<td valign="top" width="20%" rowspan="2" valign="middle"><strong>'.$value['name'].'</strong></td>
	<td width="80%"><input style="width:400px;" name="'.$value['id'].'" id="'.$value['id'].'" type="'.$value['type'].'" value="'.(get_option($value['id']) != "") ? get_option($value['id']) : $value['std'].'" /></td>
	</tr>';
				echo '<tr>
	<td><small>'.$value['desc'].'</small></td>
	</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>';
				break;
			case 'textarea':
				echo '<tr>
	<td valign="top" width="20%" rowspan="2" valign="middle"><strong>'.$value['name'].'</strong></td>
	<td width="80%"><textarea name="'.$value['id'].'" style="width:400px; height:200px;" type="'.$value['type'].'" cols="" rows="">'.(get_option($value['id']) != "") ? get_option($value['id']) : $value['std'].'</textarea></td>

	</tr>';
				echo '<tr>
	<td><small>'.$value['desc'].'</small></td>
	</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>';
				break;
			case 'select':
				echo '<tr>
	<td width="20%" rowspan="2" valign="middle"><strong>'.$value['name'].'</strong></td>
	<td width="80%"><select style="width:240px;" name="'.$value['id'].'" id="'.$value['id'].'">';
				foreach ($value['options'] as $option) {
					echo '<option';
					if (get_option( $value['id'] ) == $option) {
						echo ' selected="selected"';
					} elseif ($option == $value['std']) {
						echo ' selected="selected"';
					}
					echo '>'.$option.'</option>';
				}
				echo '</select></td></tr>';
				echo '<tr><td><small>'.$value['desc'].'</small></td></tr>';
				echo '<tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr>';
				echo '<tr><td colspan="2">&nbsp;</td></tr>';
				break;
			case "checkbox":
				echo '<tr>
	<td width="20%" rowspan="2" valign="middle"><strong>'.$value['name'].'</strong></td>
	<td width="80%">
	<input type="checkbox" name="'.$value['id'].'" id="'.$value['id'].'" value="true" '.(get_option($value['id'])) ? 'checked="checked"' : ''.' />
	</td>
	</tr>';
				echo '<tr>
	<td><small>'.$value['desc'].'</small></td>
	</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>';
				break;
			}
	}
	echo '<p class="submit">
	<input class="button button-primary" name="save" type="submit" value="Save changes" />
	<input type="hidden" name="action" value="save" />
	<input class="button" name="action" type="submit" value="reset" />
	</p>
	</form>';
}
add_action('admin_menu', 'dswoddil_add_admin');

/******************************************************************************
	SHORTCODES
******************************************************************************/

/**
 * Recent post shortcode function
 *
 * @since DSW oddil 1.0
 */
function dswoddil_recent_posts_function( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'posts' => 1,
		'linkonly' => false,
	), $atts) );

	$return_string = '<h3>'.$content.'</h3>';
	$return_string .= $linkonly ? '<ul>' : '';
	query_posts( array( 'orderby' => 'date', 'order' => 'DESC' , 'showposts' => $posts ) );
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			if ( $linkonly ) {
				$return_string .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
			} else {
				$return_string .= dswoddil_load_template_part( 'content', get_post_format() );
			}
		endwhile;
	endif;
	$return_string .= $linkonly ? '</ul>' : '';

	wp_reset_query();
	return $return_string;
}

/**
 * Link button shortcode
 *
 * @since DSW oddil 1.0
 */
function dswoddil_linkbutton_function( $atts, $content = null ) {
	return '<button type="button">'.do_shortcode($content).'</button>';
}

/**
 * Menu shortcode
 *
 * @since DSW oddil 1.0
 */
function dswoddil_menu_function( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array( 'name' => null, ),
			$atts
		)
	);
	return wp_nav_menu(
		array(
			'menu' => $name,
			'echo' => false
		)
	);
}

/**
 * Google maps embed shortcode
 *
 * @since DSW oddil 1.0
 */
function dswoddil_googlemap_function( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"width" => '640',
		"height" => '480',
		"src" => ''
	), $atts));
	return '<iframe width="'.$width.'" height="'.$height.'" src="'.$src.'&output=embed" ></iframe>';
}

/**
 * Chart embed shortcode
 *
 * @since DSW oddil 1.0
 */
function dswoddil_chart_function( $atts ) {
	extract( shortcode_atts( array(
		'data' => '',
		'chart_type' => 'pie',
		'title' => 'Chart',
		'labels' => '',
		'size' => '640x480',
		'background_color' => 'FFFFFF',
		'colors' => '',
	), $atts));

	switch ($chart_type) {
		case 'line' :
			$chart_type = 'lc';
			break;
		case 'pie' :
			$chart_type = 'p3';
			break;
		default :
			break;
	}

	$attributes = '';
	$attributes .= '&chd=t:'.$data.'';
	$attributes .= '&chtt='.$title.'';
	$attributes .= '&chl='.$labels.'';
	$attributes .= '&chs='.$size.'';
	$attributes .= '&chf='.$background_color.'';
	$attributes .= '&chco='.$colors.'';

	return '<img title="'.$title.'" src="http://chart.apis.google.com/chart?cht='.$chart_type.''.$attributes.'" alt="'.$title.'" />';
}

/**
 * PDF embed shortcode
 *
 * @since DSW oddil 1.0
 */
function dswoddil_pdf_function($attr, $url) {
	extract( shortcode_atts( array(
		'width' => '640',
		'height' => '480'
	), $attr) );
	return '<iframe src="http://docs.google.com/viewer?url=' . $url . '&embedded=true" style="width:' .$width. '; height:' .$height. ';">Your browser does not support iframes</iframe>';
}

/**
 * Register DSW shortcodes functions
 *
 * @since DSW oddil 1.0
 */
function dswoddil_register_shortcodes() {
	add_shortcode( 'recent-posts', 'dswoddil_recent_posts_function' );
	add_shortcode( 'linkbutton', 'dswoddil_linkbutton_function' );
	add_shortcode( 'menu', 'dswoddil_menu_function' );
	add_shortcode( 'googlemap', 'dswoddil_googlemap_function' );
	add_shortcode( 'chart', 'dswoddil_chart_function' );
	add_shortcode( 'pdf', 'dswoddil_pdf_function' );
}

/*** Recent posts button into TinyMCE ***/

/**
 * Register recent posts button
 *
 * @since DSW oddil 1.0
 */
function dswoddil_register_button( $buttons ) {
	array_push( $buttons, "|", "recentposts" );
	return $buttons;
}

/**
 * Localize TinyMCE recenposts plugin
 *
 * @since DSW oddil 1.0
 */
function dswoddil_mce_localize_recentposts_script() {
	$recentposts_vars = array(
		'title'			=> __( 'Recent posts', 'dswoddil' ),
		'posts'			=> __( 'Posts count', 'dswoddil' ),
		'text'		 	=> __( 'Title', 'dswoddil' ),
		'text_message'	=> __( 'This is title text', 'dswoddil' ),
		'link'			=> __( 'Show links only', 'dswoddil' ),
	);

	?>
	<script type="text/javascript">
		var recentposts_vars = <?php echo json_encode($recentposts_vars); ?>;
	</script>
	<?php
}

/**
 * Add plugin for recent posts
 *
 * @since DSW oddil 1.0
 */
function dswoddil_mce_add_recentposts_plugin( $plugin_array ) {
	$plugin_array['recentposts'] = get_template_directory_uri() . '/js/recentposts.js';
	return $plugin_array;
}

/**
 * Create own recent posts button
 *
 * @since DSW oddil 1.0
 */
function dswoddil_mce_recentposts_button() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
		return;
	}

	if ( get_user_option('rich_editing') == 'true' ) {
		add_filter( 'mce_external_plugins', 'dswoddil_mce_add_recentposts_plugin' );
		add_filter( 'mce_buttons', 'dswoddil_register_button' );
	}
}

/*** Add actions and filters ***/

// Add support into init
add_action( 'init', 'dswoddil_register_shortcodes' );
add_action( 'init', 'dswoddil_mce_recentposts_button' );
// Enqueue admin scripts
add_action( 'admin_enqueue_scripts', 'dswoddil_mce_localize_recentposts_script' );
// Add support for shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );
// Add support for shortcodes in comments
add_filter( 'comment_text', 'do_shortcode' );
// Add support for shortcodes in excerpts
add_filter( 'the_excerpt', 'do_shortcode');

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