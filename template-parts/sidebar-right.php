<?php
/**
 * Template for displaying right sidebar
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage dsw_oddil
 * @since DSW oddil 1.0
 */
?>

<?php if ( is_active_sidebar( 'content' ) ) : ?>
<section class="col-md-3">
	<?php get_sidebar( 'content' ); ?>
</section><!-- .col-md-3 -->
<?php endif; ?>
