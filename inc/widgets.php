<?php

/**
 * Count number of widgets in a sidebar
 * Used to add classes to widget areas so widgets can be displayed one, two, three or four per row
 *
 * @since DSW oddil 0.18.0
 */
function dswoddil_count_widgets( $sidebar_id ) {
	// If loading from front page, consult $_wp_sidebars_widgets rather than options
	// to see if wp_convert_widget_settings() has made manipulations in memory.
	global $_wp_sidebars_widgets;
	if ( empty( $_wp_sidebars_widgets ) ) {
		$_wp_sidebars_widgets = get_option( 'sidebars_widgets', array() );
	}

	$sidebars_widgets_count = $_wp_sidebars_widgets;

	if ( isset( $sidebars_widgets_count[ $sidebar_id ] ) ) {
		$widget_count = count( $sidebars_widgets_count[ $sidebar_id ] );
		$widget_classes = 'widget-count-' . count( $sidebars_widgets_count[ $sidebar_id ] );
		if ( $widget_count % 4 == 0 || $widget_count > 6 ) {
			// Four widgets er row if there are exactly four or more than six
			$widget_classes .= ' col-md-3';
		} elseif ( $widget_count >= 3 ) {
			// Three widgets per row if there's three or more widgets
			$widget_classes .= ' col-md-4';
		} elseif ( 2 == $widget_count ) {
			// Otherwise show two widgets per row
			$widget_classes .= ' col-md-6';
		}
		return $widget_classes;
	}
}

/**
 * Add "first" and "last" CSS classes to dynamic sidebar widgets. Also adds numeric index class for each widget (widget-1, widget-2, etc.)
 *
 * @since DSW oddil 0.18.0
 */
function dswoddil_widget_first_last_classes( $params ) {
	// Global a counter array
	global $my_widget_num;
	// Get the id for the current sidebar we're processing
	$this_id = $params[0]['id'];
	// Get an array of ALL registered widgets
	$arr_registered_widgets = wp_get_sidebars_widgets();
	// If the counter array doesn't exist, create it
	if ( !$my_widget_num ) {
		$my_widget_num = array();
	}

	// Check if the current sidebar has no widgets
	if ( !isset( $arr_registered_widgets[$this_id] ) || !is_array( $arr_registered_widgets[$this_id] ) ) {
		return $params; // No widgets in this sidebar... bail early.
	}

	// See if the counter array has an entry for this sidebar
	if ( isset( $my_widget_num[$this_id] ) ) {
		$my_widget_num[$this_id] ++;
	// If not, create it starting with 1
	} else {
		$my_widget_num[$this_id] = 1;
	}

	// Add a widget number class for additional styling options
	$class = 'class="widget-' . $my_widget_num[$this_id] . ' ';

	// If this is the first widget
	if ( $my_widget_num[$this_id] == 1 ) {
		$class .= 'widget-first ';
	// If this is the last widget
	} elseif ( $my_widget_num[$this_id] == count( $arr_registered_widgets[$this_id] ) ) {
		$class .= 'widget-last ';
	}

	// Insert our new classes into "before widget"
	$params[0]['before_widget'] = str_replace( 'class="', $class, $params[0]['before_widget'] );

	return $params;

}
add_filter( 'dynamic_sidebar_params', 'dswoddil_widget_first_last_classes' );

/**
 * Register three DSW oddil widget areas.
 *
 * @since DSW oddil 1.0
 */
function dswoddil_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Area above content', 'dswoddil' ),
		'id'            => 'top-widget',
		'description'   => __( 'Appears above the content section of the site.', 'dswoddil' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s content ' . dswoddil_count_widgets( 'top-widget' ) . '">',
		'after_widget'  => '</aside>',
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
		'before_widget' => '<aside id="%1$s" class="widget %2$s ' . dswoddil_count_widgets( 'top-widget' ) . ' fill">',
		'after_widget'  => '</aside>',
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
