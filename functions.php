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

//Fallback function
function ter_navbar_fallback(){	wp_list_pages(array('title_li' => '','walker' => new TerWalkerPage())); }

/* TerWalkerNavMenu
*  Use with wp_nav_menu */
class TerWalkerNavMenu extends Walker_Nav_Menu
{
	public function start_lvl(&$output,$depth)
	{
		$indent = str_repeat("\t",$depth);
		if($depth < 1) $dropdown_menu = ' dropdown-menu';
		$output .= "\n$indent<ul class=\"sub-menu$dropdown_menu\">\n";
	}

	public function start_el(&$output,$item,$depth,$args)
	{
		global $wp_query;
		$indent = ($depth) ? str_repeat("\t",$depth) : '';
		$class_names = $value = '';
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		if($args->has_children && (integer)$depth < 1) $classes[] = 'dropdown';
		$class_names = join(' ',apply_filters('nav_menu_css_class',array_filter($classes),$item,$args));
		$class_names = ' class="' . esc_attr($class_names) . '"';
		$id = apply_filters('nav_menu_item_id','menu-item-' . $item->ID,$item,$args);
		$id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';
		$output .= $indent . '<li' . $id . $value . $class_names .'>';
		$attributes  = ! empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) .'"' : '';
		$attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
		$attributes .= ! empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) .'"' : '';
		$attributes .= ! empty($item->url) ? ' href="' . esc_attr($item->url) .'"' : '';
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= ($args->has_children && (integer)$depth < 1) ? '<span class="caret"></span>' : '';
		$item_output .= '</a>';
		$item_output .= $args->after;
		$output .= apply_filters('walker_nav_menu_start_el',$item_output,$item,$depth,$args);
	}

	function display_element($element,&$children_elements,$max_depth,$depth = 0,$args,&$output)
	{
		if(!$element) return;
		$id_field = $this->db_fields['id'];
		if(is_array($args[0])) $args[0]['has_children'] = !empty($children_elements[$element->$id_field]);
		elseif(is_object($args[0]))	$args[0]->has_children = !empty($children_elements[$element->$id_field]); //** Add has_children value, only mod in method **
		$cb_args = array_merge(array(&$output,$element,$depth),$args);
		call_user_func_array(array(&$this,'start_el'),$cb_args);
		$id = $element->$id_field;
		if(($max_depth == 0 || $max_depth > $depth+1) && isset($children_elements[$id])){
			foreach($children_elements[$id] as $child){
				if(!isset($newlevel)){
					$newlevel = true;
					$cb_args = array_merge(array(&$output,$depth),$args);
					call_user_func_array(array(&$this,'start_lvl'),$cb_args);
				}
				$this->display_element($child,$children_elements,$max_depth,$depth + 1,$args,$output);
			}
			unset($children_elements[$id]);
		}
		if(isset($newlevel) && $newlevel){
			$cb_args = array_merge(array(&$output,$depth),$args);
			call_user_func_array(array(&$this,'end_lvl'),$cb_args);
		}
   		$cb_args = array_merge(array(&$output,$element,$depth),$args);
    	call_user_func_array(array(&$this,'end_el'),$cb_args);
	}
}

/* TerWalkerPage
*  Fallback, use with wp_list_pages */
class TerWalkerPage extends Walker_Page
{
	function start_lvl(&$output,$depth)
	{
		$indent = str_repeat("\t",$depth);
		if($depth < 1) $dropdown_menu = ' dropdown-menu';
		$output .= "\n$indent<ul class=\"sub-menu$dropdown_menu\">\n";
	}

	function start_el(&$output,$page,$depth,$args,$current_page)
	{
		if($depth) $indent = str_repeat("\t", $depth);
		else $indent = '';
		extract($args, EXTR_SKIP);
		$css_class = array('page_item', 'page-item-'.$page->ID);
		if(!empty($current_page)){
			$_current_page = get_page($current_page);
			_get_post_ancestors($_current_page);
			if(isset($_current_page->ancestors) && in_array($page->ID,(array)$_current_page->ancestors)) $css_class[] = 'current_page_ancestor';
			if($page->ID == $current_page) $css_class[] = 'current_page_item';
			elseif($_current_page && $page->ID == $_current_page->post_parent) $css_class[] = 'current_page_parent';
		}

		elseif($page->ID == get_option('page_for_posts')) $css_class[] = 'current_page_parent';

		if($args['has_children'] && (integer)$depth < 1) $css_class[] = 'dropdown';

		$css_class = implode(' ',apply_filters('page_css_class',$css_class,$page,$depth,$args,$current_page));

		if($args['has_children'] && (integer)$depth < 1) $link_after .= $link_after . '<span class="caret"></span>';

		$output .= $indent . '<li class="' . $css_class . '"><a href="' . get_permalink($page->ID) . '">' . $link_before . apply_filters('the_title',$page->post_title,$page->ID ) . $link_after . '</a>';

		if(!empty($show_date)){
			if('modified' == $show_date) $time = $page->post_modified;
			else $time = $page->post_date;
			$output .= " " . mysql2date($date_format,$time);
		}
	}
}

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
require get_template_directory() . '/inc/template-tags.php';

// Add Theme Customizer functionality.
require get_template_directory() . '/inc/customizer.php';