<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package WordPress
 * @subpackage DSW_oddil
 * @since DSW oddil 1.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function dswoddil_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'dswoddil_body_classes' );

/**
 * Adds custom translation for comments plural forms.
 *
 * @param  string $output  Output string.
 * @param  int    $number  Number of comments
 * @return string
 */
if ( defined( 'WPLANG' ) && WPLANG == 'cs_CZ' ) {
	function czech_comments( $output, $number ) {
		if ( intval( $number ) === 0) {
			$output = 'Žádný komentář';
		} elseif ( intval( $number ) === 1 ) {
			$output = str_replace( '%', number_format_i18n( $number ), '1 komentář' );
		} elseif ( intval( $number ) > 1  && intval( $number ) < 5 ) {
			$output = str_replace( '%', number_format_i18n( $number ), '% komentáře' );
		} else {
			$output = str_replace( '%', number_format_i18n( $number ), '% komentářů' );
		}
		return $output;
	}

	add_action('comments_number', 'czech_comments', 10, 2);
}

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function dswoddil_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name.
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary.
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'dswoddil' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'dswoddil_wp_title', 10, 2 );

endif;

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

/******************************************************************************
	SHORTCODES
******************************************************************************/

/**
 * Recent post shortcode function
 *
 * @since DSW oddil 1.0
 */
/*
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
*/
/**
 * Link button shortcode
 *
 * @since DSW oddil 1.0
 */
/*
function dswoddil_linkbutton_function( $atts, $content = null ) {
	return '<button type="button">' . do_shortcode( $content ) . '</button>';
}
*/
/**
 * Menu shortcode
 *
 * @since DSW oddil 1.0
 */
/*
function dswoddil_menu_function( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array( 'name' => null, ),
			$atts
		)
	);

	if ( false === ( $dswoddil_menu_data = get_transient( 'dswoddil_menu_function_data' ) ) ) {
		$dswoddil_menu_data = wp_nav_menu(
			array(
				'menu' => $name,
				'echo' => false
			)
		);
		set_transient( 'dswoddil_menu_function_data', $dswoddil_menu_data, 10 * MINUTE_IN_SECONDS );
	}

	return $dswoddil_menu_data;
}
*/
/**
 * Google maps embed shortcode
 *
 * @since DSW oddil 1.0
 */
/*
function dswoddil_googlemap_function( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"width" => '640',
		"height" => '480',
		"src" => ''
	), $atts));
	return '<iframe width="' . intval( $width ) . '" height="' . intval( $height ) . '" src="' . esc_url( $src . '&output=embed' ) . '" ></iframe>';
}
*/
/**
 * Chart embed shortcode
 *
 * @since DSW oddil 1.0
 */
 /*
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

	$title = sanitize_title( $title );

	$attributes = '';
	$attributes .= '&chd=t:' . sanitize_text_field( $data ) . '';
	$attributes .= '&chtt=' . $title . '';
	$attributes .= '&chl=' . sanitize_text_field( $labels ) . '';
	$attributes .= '&chs=' . sanitize_text_field( $size ) . '';
	$attributes .= '&chf=' . sanitize_text_field( $background_color ) . '';
	$attributes .= '&chco=' . sanitize_text_field( $colors ) . '';

	$html_image = '<img title="' . $title . '" src="' . esc_url( 'http://chart.apis.google.com/chart?cht=' . $chart_type . $attributes ) .'" alt="'. $title . '" />';

	return $html_image;
}
*/
/**
 * PDF embed shortcode
 *
 * @since DSW oddil 1.0
 */
/*
function dswoddil_pdf_function($attr, $url) {
	extract( shortcode_atts( array(
		'width' => '640',
		'height' => '480'
	), $attr) );
	$html_iframe = '<iframe src="' . esc_url( 'http://docs.google.com/viewer?url=' . $url . '&embedded=true' ) . '" style="width:' . intval( $width ) . '; height:' . intval( $height ) . ';">' . __( 'Your browser does not support iframes', 'dswoddil' ) . '</iframe>';

	return $html_iframe;
}
*/
/**
 * Register DSW shortcodes functions
 *
 * @since DSW oddil 1.0
 */
/*
function dswoddil_register_shortcodes() {
	add_shortcode( 'recent-posts', 'dswoddil_recent_posts_function' );
	add_shortcode( 'linkbutton', 'dswoddil_linkbutton_function' );
	add_shortcode( 'menu', 'dswoddil_menu_function' );
	add_shortcode( 'googlemap', 'dswoddil_googlemap_function' );
	add_shortcode( 'chart', 'dswoddil_chart_function' );
	add_shortcode( 'pdf', 'dswoddil_pdf_function' );
}
*/
/*** Recent posts button into TinyMCE ***/

/**
 * Register recent posts button
 *
 * @since DSW oddil 1.0
 */
/*
function dswoddil_register_button( $buttons ) {
	array_push( $buttons, "|", "recentposts" );
	return $buttons;
}
*/
/**
 * Localize TinyMCE recenposts plugin
 *
 * @since DSW oddil 1.0
 */
/*
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
*/
/**
 * Add plugin for recent posts
 *
 * @since DSW oddil 1.0
 */
/*
function dswoddil_mce_add_recentposts_plugin( $plugin_array ) {
	$plugin_array['recentposts'] = get_template_directory_uri() . '/js/recentposts.js';
	return $plugin_array;
}
*/
/**
 * Create own recent posts button
 *
 * @since DSW oddil 1.0
 */
/*
function dswoddil_mce_recentposts_button() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
		return;
	}

	if ( get_user_option('rich_editing') == 'true' ) {
		add_filter( 'mce_external_plugins', 'dswoddil_mce_add_recentposts_plugin' );
		add_filter( 'mce_buttons', 'dswoddil_register_button' );
	}
}
*/
/*** Add actions and filters ***/

// Add support into init
//add_action( 'init', 'dswoddil_register_shortcodes' );
//add_action( 'init', 'dswoddil_mce_recentposts_button' );
// Enqueue admin scripts
//add_action( 'admin_enqueue_scripts', 'dswoddil_mce_localize_recentposts_script' );
// Add support for shortcodes in widgets
//add_filter( 'widget_text', 'do_shortcode' );
// Add support for shortcodes in comments
//add_filter( 'comment_text', 'do_shortcode' );
// Add support for shortcodes in excerpts
//add_filter( 'the_excerpt', 'do_shortcode');
