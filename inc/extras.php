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
	function dswoddil_czech_comments( $output, $number ) {
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

	add_action('comments_number', 'dswoddil_czech_comments', 10, 2);
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

/**
 * Finds attachment by its name.
 *
 * @param string $post_name Name of the attachment.
 * @return array Attachment properties.
 */
if( ! ( function_exists( 'wp_get_attachment_by_post_name' ) ) ) {
	function dswoddil_get_attachment_by_post_name( $post_name ) {
		$args = array(
			'post_per_page' => 1,
			'post_type'	 => 'attachment',
			'name'		  => trim ( $post_name ),
		);
		$get_posts = new Wp_Query( $args );

		if ( ! empty ( $get_posts->posts[0] ) ) {
			return $get_posts->posts[0];
		} else {
			return false;
		}
	}
}
