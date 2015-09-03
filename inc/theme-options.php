<?php
/**
 * DSW_Oddil Theme Options
 *
 * @package WordPress
 * @subpackage DSW_oddil
 * @since DSW oddil 1.0
 */

/******************************************************************************
	ADMIN THEME SETTINGS
******************************************************************************/
add_action( 'admin_menu', 'dswoddil_theme_settings_menu' );
add_action( 'admin_init', 'dswoddil_theme_settings_init');

/**
 * Preparing theme settings into menu.
 *
 * @since DSW oddil 1.0
 */
function dswoddil_theme_settings_menu() {
	add_theme_page(
		__( 'Theme Settings', 'dswoddil' ),
		__( 'Theme Settings', 'dswoddil' ),
		'administrator',
		'dswoddil_theme_settings',
		'dswoddil_theme_settings_page_render'
	);
}

/**
 * Render theme settings page.
 *
 * @since DSW oddil 1.0
 */
function dswoddil_theme_settings_page_render() {
	// Create a header in the default WordPress 'wrap' container
	?>
	<div class="wrap">
		<h2><?php _e( 'DSW Oddil Theme Settings', 'dswoddil' )?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'dswoddil_theme_settings_page' ); ?>
			<?php do_settings_sections( 'dswoddil_theme_settings_page' ); ?>
			<?php submit_button(); ?>
		</form>

	</div>
	<?php
}

/**
 * Initialization of theme settings.
 *
 * @since DSW oddil 1.0
 */
function dswoddil_theme_settings_init() {
	if ( false == get_option( 'dswoddil_theme_settings_page' ) ) {
		add_option( 'dswoddil_theme_settings_page' );
	}

	add_settings_section(
		'dswoddil_general_settings_section',
		__( 'Layout Settings', 'dswoddil' ),
		'dswoddil_layout_settings_callback',
		'dswoddil_theme_settings_page'
	);

	add_settings_field(
		'dswoddil_layout_color',
		__( 'Layout color', 'dswoddil' ),
		'dswoddil_layout_color_switcher_render',
		'dswoddil_theme_settings_page',
		'dswoddil_general_settings_section',
		array(
			__( 'Change this setting to display different color.', 'dswoddil' )
		)
	);

	add_settings_field(
		'dswoddil_cache_menu',
		__( 'Cache menu', 'dswoddil' ),
		'dswoddil_cache_menu_form_render',
		'dswoddil_theme_settings_page',
		'dswoddil_general_settings_section',
		array(
			__( 'Zero for caching off, otherwise minutes.', 'dswoddil' )
		)
	);

	register_setting(
		'dswoddil_theme_settings_page',
		'dswoddil_layout_color'
	);

	register_setting(
		'dswoddil_theme_settings_page',
		'dswoddil_cache_menu'
	);
}

/**
 * Layout settings callback.
 *
 * @since DSW oddil 1.0
 */
function dswoddil_layout_settings_callback() {
	_e( '<p>Select which layout color you wish to display.</p>', 'dswoddil' );
}

/**
 * Render layout color switcher.
 *
 * @since DSW oddil 1.0
 */
function dswoddil_layout_color_switcher_render($args) {
	$options = array (
		"id"   	 => "dswoddil_layout_color",
		"colors" => array(
			"red" 		=> __( 'red', 'dswoddil' ),
			"blue"		=> __( 'blue', 'dswoddil' ),
			"violet"	=> __( 'violet', 'dswoddil' ),
			"green"		=> __( 'green', 'dswoddil' )
		),
	);

	$html = '<select style="width:200px;" name="'.$options['id'].'" id="'.$options['id'].'">';
				foreach ( $options['colors'] as $color_key => $color_value ) {
					$html .= '<option';
					if (get_option( $options['id'] ) == $color_key) {
						$html .= ' selected="selected"';
					}
					$html .= ' value = "'.$color_key.'">'.$color_value.'</option>';
				}
				$html .= '</select>';

	// Here, we will take the first argument of the array and add it to a label next to the checkbox
	$html .= '<label for="dswoddil_layout_color"> ' . $args[0] . '</label>';

	echo $html;
}

/**
 * Render layout color switcher.
 *
 * @since DSW oddil 1.0
 */
function dswoddil_cache_menu_form_render($args) {

	$value = get_option( 'dswoddil_cache_menu' ) ? get_option( 'dswoddil_cache_menu' ) : 0;

	$html = '<input style="width:200px;" name="dswoddil_cache_menu" id="dswoddil_cache_menu" type="text" value="' . $value . '" placeholder="0">';

	// Here, we will take the first argument of the array and add it to a label next to the checkbox
	$html .= '<label for="dswoddil_cache_menu"> ' . $args[0] . '</label>';

	echo $html;
}

/******************************************************************************
	ADMIN SCRIPTS
******************************************************************************/
/*
function dswoddil_load_custom_wp_admin_scripts()
{
	// Register the script like this for a theme:
	//wp_register_script( 'custom-script', get_template_directory_uri() . '/js/' . ((dswoddil_get_dev_enviroment() <> 1) ? 'bootstrap.js' : 'bootstrap.min.js') , array( 'jquery' ) );
	// For either a plugin or a theme, you can then enqueue the script:
	//wp_enqueue_script( 'custom-script' );
}
add_action( 'admin_enqueue_scripts', 'dswoddil_load_custom_wp_admin_scripts' );
*/
