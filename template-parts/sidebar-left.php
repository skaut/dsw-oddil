<?php
/**
 * Template for displaying left sidebar
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage dsw_oddil
 * @since DSW oddil 1.0
 */
?>

<?php if ( is_active_sidebar( 'left-sidebar' ) ) : ?>
	<section class="col-md-3">
		<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
			<?php dynamic_sidebar( 'left-sidebar' ); ?>
		</div><!-- #primary-sidebar -->
	</section>
<?php endif; ?>
