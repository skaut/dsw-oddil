<?php
/**
 * Custom Site Icon
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package WordPress
 * @subpackage DSW_oddil
 * @since DSW oddil 1.0
 */

/**
 * Upload theme default site icon
 *
 * @return void
 */
function dswoddil_site_icon_upload() {
	$image_name = 'site-icon';

	if ( ! function_exists( 'wp_update_attachment_metadata' )
		|| ! function_exists( 'wp_generate_attachment_metadata' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
	}

	if ( ! function_exists( 'request_filesystem_credentials' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	/* you can safely run request_filesystem_credentials() without any issues and don't need to worry about passing in a URL */
	$creds = request_filesystem_credentials(site_url() . '/wp-admin/', '', false, false, array());

	/* initialize the API */
	if ( ! WP_Filesystem($creds) ) {
		/* any problems and we exit */
		return false;
	}

	global $wp_filesystem;

	if ( ! dswoddil_get_attachment_by_post_name( 'dswoddil-' . $image_name ) ) {
		$site_icon = get_template_directory() . '/img/' . $image_name . '.png';

		// create $file array with the indexes show below
		$file['name'] = $site_icon;
		$file['type'] = 'image/png';
		// get image size
		$file['size'] = filesize( $file['name'] );
		$file['tmp_name'] = $image_name . '.png';
		$file['error'] = 1;

		$file_content = $wp_filesystem->get_contents( $site_icon );
		$upload_image = wp_upload_bits( $file['tmp_name'], null, $file_content );
		// Check the type of tile. We'll use this as the 'post_mime_type'.
		$filetype = wp_check_filetype( basename( $upload_image['file'] ), null );
		$attachment = array(
			'guid'           => $upload_image['file'],
			'post_mime_type' => $filetype['type'],
			'post_title'     => 'dswoddil-' . $image_name,
			'post_content'   => '',
			'post_status'    => 'inherit',
		);
		//insert wordpress attachment of uploaded image to get attachmen ID
		$attachment_id = wp_insert_attachment( $attachment, $upload_image['file']);

		//generate attachment thumbnail
		wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $upload_image['file'] ) );

		add_post_meta( $attachment_id, '_wp_attachment_context', $image_name );
	}
}

/**
 * Activate default site icon
 *
 * @return void
 */
function dswoddil_site_icon_activate() {
	$attachment = dswoddil_get_attachment_by_post_name( 'dswoddil-site-icon' );
	update_option( 'site_icon', $attachment->ID );
}

/**
 * Deactivate site icon after them switching
 *
 * @return void
 */
function dswoddil_site_icon_deactivate() {
	update_option( 'site_icon', 0 );
}

add_action( 'after_switch_theme', 'dswoddil_site_icon_upload' );
add_action( 'after_switch_theme', 'dswoddil_site_icon_activate' );
add_action( 'switch_theme', 'dswoddil_site_icon_deactivate' );
