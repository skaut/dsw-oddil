<?php 

function wpbootstrap_scripts_with_jquery()
{
	// Register the script like this for a theme:
	wp_register_script( 'custom-script', get_template_directory_uri() . '/bootstrap/js/bootstrap.js', array( 'jquery' ) );
	// For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'custom-script' );
}
add_action( 'wp_enqueue_scripts', 'wpbootstrap_scripts_with_jquery' );

if ( function_exists('register_sidebar') )
	register_sidebar(array(
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

	// Add RSS feed links to <head> for posts and comments.
	//add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true );
	//add_image_size( 'twentyfourteen-full-width', 1038, 576, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'dswoddil' ),
		'secondary' => __( 'Secondary menu in left/right sidebar', 'dswoddil' ),
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
		'name'          => __( 'Header Right', 'dswoddil' ),
		'id'            => 'header-right',
		'description'   => __( 'Widget that appears on the right in header.', 'dswoddil' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => __( 'Header Left', 'dswoddil' ),
		'id'            => 'header-left',
		'description'   => __( 'Widget that appears on the left in header.', 'dswoddil' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
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
		'name'          => __( 'Footer Widget Area', 'dswoddil' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears in the footer section of the site.', 'dswoddil' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'dswoddil_widgets_init' );


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
	"options" => array("default", "red", "blue", "violet"), 
	"std" => "blue"),
);

function mytheme_add_admin() {
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

	add_theme_page($themename." Options", "".$themename." Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function mytheme_admin() {
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
add_action('admin_menu', 'mytheme_add_admin');
