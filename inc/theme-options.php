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

/**
 * Register the form setting for our dswoddil_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, dswoddil_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are complete, properly
 * formatted, and safe.
 *
 * We also use this function to add our theme option if it doesn't already exist.
 *
 * @since DSW Oddil 1.0
 */
function dswoddil_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === dswoddil_get_theme_options() )
		add_option( 'dswoddil_theme_options', dswoddil_get_default_theme_options() );

	register_setting(
		'dswoddil_options',       // Options group, see settings_fields() call in poutnicikolin_theme_options_render_page()
		'dswoddil_theme_options', // Database option, see poutnicikolin_get_theme_options()
		'dswoddil_theme_options_validate' // The sanitization callback, see poutnicikolin_theme_options_validate()
	);

	// Register our settings field group
	add_settings_section(
		'general', // Unique identifier for the settings section
		'', // Section title (we don't want one)
		'__return_false', // Section callback (we don't want anything)
		'theme_options' // Menu slug, used to uniquely identify the page; see poutnicikolin_theme_options_add_page()
	);

	// Register our individual settings fields
	add_settings_field(
		'color_scheme',  // Unique identifier for the field for this section
		__( 'Color Scheme', 'dswoddil' ), // Setting field label
		'dswoddil_settings_field_color_scheme', // Function that renders the settings field
		'theme_options', // Menu slug, used to uniquely identify the page; see poutnicikolin_theme_options_add_page()
		'general' // Settings section. Same as the first argument in the add_settings_section() above
	);

}
add_action( 'admin_init', 'dswoddil_theme_options_init' );

/**
 * Change the capability required to save the 'dswoddil_options' options group.
 *
 * @see dswoddil_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see dswoddil_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * By default, the options groups for all registered settings require the manage_options capability.
 * This filter is required to change our theme options page to edit_theme_options instead.
 * By default, only administrators have either of these capabilities, but the desire here is
 * to allow for finer-grained control for roles and users.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function dswoddil_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_dswoddil_options', 'dswoddil_option_page_capability' );

/**
 * Add our theme options page to the admin menu, including some help documentation.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since DSW Oddil 1.0
 */
function dswoddil_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme Options', 'dswoddil' ),   // Name of page
		__( 'Theme Options', 'dswoddil' ),   // Label in menu
		'edit_theme_options',                    // Capability required
		'theme_options',                         // Menu slug, used to uniquely identify the page
		'dswoddil_theme_options_render_page' // Function that renders the options page
	);

	if ( ! $theme_page )
		return;

	add_action( "load-$theme_page", 'dswoddil_theme_options_help' );
}
add_action( 'admin_menu', 'dswoddil_theme_options_add_page' );

function dswoddil_theme_options_help() {

	$help = '<p>' . __( 'Some themes provide customization options that are grouped together on a Theme Options screen. If you change themes, options may change or disappear, as they are theme-specific. Your current theme, DSW Oddil, provides the following Theme Options:', 'dswoddil' ) . '</p>' .
			'<ol>' .
				'<li>' . __( '<strong>Color Scheme</strong>: You can choose a color palette of few color schemes for your site.', 'dswoddil' ) . '</li>' .
			'</ol>' .
			'<p>' . __( 'Remember to click "Save Changes" to save any changes you have made to the theme options.', 'dswoddil' ) . '</p>';

	$sidebar = '<p><strong>' . __( 'For more information:', 'dswoddil' ) . '</strong></p>' .
		'<p>' . __( '<a href="http://codex.wordpress.org/Appearance_Theme_Options_Screen" target="_blank">Documentation on Theme Options</a>', 'dswoddil' ) . '</p>' .
		'<p>' . __( '<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>', 'dswoddil' ) . '</p>';

	$screen = get_current_screen();

	if ( method_exists( $screen, 'add_help_tab' ) ) {
		// WordPress 3.3
		$screen->add_help_tab( array(
			'title' => __( 'Overview', 'dswoddil' ),
			'id' => 'theme-options-help',
			'content' => $help,
			)
		);

		$screen->set_help_sidebar( $sidebar );
	} else {
		// WordPress 3.2
		add_contextual_help( $screen, $help . $sidebar );
	}
}

/**
 * Returns the default options for DSW Oddil.
 *
 * @since DSW Oddil 1.0
 */
function dswoddil_get_default_theme_options() {
	$default_theme_options = array(
		'color_scheme' => 'green',
	);

	return apply_filters( 'dswoddil_default_theme_options', $default_theme_options );
}

/**
 * Returns the options array for DSW Oddil.
 *
 * @since DSW Oddil 1.0
 */
function dswoddil_get_theme_options() {
	return get_option( 'dswoddil_theme_options', dswoddil_get_default_theme_options() );
}

/**
 * Returns an array of layout color options registered for DSW Oddil.
 *
 * @since DSW Oddil 1.0
 */
function dswoddil_color_schemes() {
	$color_scheme_options = array(
		'red' => array(
			'value' => 'red',
			'label' => __( 'Red', 'dswoddil' ),
			'colors' => array('000', 'c1272d', 'ed1c24', 'fff'),
		),
		'blue' => array(
			'value' => 'blue',
			'label' => __( 'Blue', 'dswoddil' ),
			'colors' => array('000', '2e3192', '0071bc', 'fff'),
		),
		'violet' => array(
			'value' => 'violet',
			'label' => __( 'Violet', 'dswoddil' ),
			'colors' => array('000', '9e005d', 'd4145a', 'fff'),
		),
		'green' => array(
			'value' => 'green',
			'label' => __( 'Green', 'dswoddil' ),
			'colors' => array('000', '787600', 'b2ae00', 'fff'),
		),
	);

	return apply_filters( 'dswoddil_color_schemes', $color_scheme_options );
}

/**
 * Renders the color scheme setting field.
 *
 * @since DSW Oddil 1.0
 */
function dswoddil_settings_field_color_scheme() {
	$options = dswoddil_get_theme_options();
	?>

	<script type="text/javascript">
	(function($) {
		$(document).ready( function() {
			$(".color-option").on('click', function (e) {
				cb = $(this).children(":radio");
				cb.attr("checked", !cb.attr("checked"));
				$(".color-option.selected").removeClass("selected");
				$(this).addClass("selected");
			});
		});
	})(jQuery);
	</script>

	<fieldset id="scheme-picker" class="scheme-list">
		<legend class="screen-reader-text">
			<span>
				<?php __( 'Color Scheme', 'dswoddil' ); ?>
			</span>
		</legend>

	<?php foreach ( dswoddil_color_schemes() as $scheme ) { ?>

	<div class="color-option<?php echo $scheme['value'] == $options['color_scheme'] ? ' selected' : ''; ?>">
		<input id="scheme_color_<?php echo $scheme['value']; ?>" class="tog" type="radio" name="dswoddil_theme_options[color_scheme]" value="<?php echo esc_attr( $scheme['value'] ); ?>" <?php checked( $options['color_scheme'], $scheme['value'] ); ?> />
		<label for="scheme_color_<?php echo $scheme['value']; ?>" class="description"><?php echo $scheme['label']; ?></label>
		<table class="color-palette">
			<tbody>
				<tr>

				<?php foreach ( $scheme['colors'] as $color ) { ?>

					<td style="background-color: #<?php echo $color; ?>">&nbsp;</td>

				<?php }	?>

				</tr>
			</tbody>
		</table>
	</div>

	<?php }	?>

	</fieldset>

	<?php
}

/**
 * Returns the options array for DSW Oddil.
 *
 * @since DSW Oddil 1.0
 */
function dswoddil_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'dswoddil' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'dswoddil_options' );
				do_settings_sections( 'theme_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see dswoddil_theme_options_init()
 * @todo set up Reset Options action
 *
 * @since DSW Oddil 1.0
 */
function dswoddil_theme_options_validate( $input ) {
	$output = $defaults = dswoddil_get_default_theme_options();

	// Color scheme must be in our array of color scheme options
	if ( isset( $input['color_scheme'] ) && array_key_exists( $input['color_scheme'], dswoddil_color_schemes() ) )
		$output['color_scheme'] = $input['color_scheme'];

	return apply_filters( 'dswoddil_theme_options_validate', $output, $input, $defaults );
}

/**
 * Enqueue the styles for the current color scheme.
 *
 * @since DSW Oddil 1.0
 */
function dswoddil_enqueue_color_scheme() {
	$options = dswoddil_get_theme_options();
	$color_scheme = $options['color_scheme'];

	// Custom colored style for this theme
	wp_enqueue_style(
		'dswoddil_color-scheme',
		get_template_directory_uri() . '/css/' . $color_scheme . ( ( dswoddil_get_dev_enviroment() <> 1 ) ? '' : '.min' ) . '.css'
	);

	do_action( 'dswoddil_enqueue_color_scheme', $color_scheme );
}
add_action( 'wp_enqueue_scripts', 'dswoddil_enqueue_color_scheme' );
