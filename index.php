<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage DSW_oddil
 * @since DSW oddil 1.0
 */

get_header();

?>

<?php if ( is_active_sidebar( 'above-content-widget' ) ) : ?>
	<div id="above-content-widget" class="above-content-widget widget-area container optional" role="complementary">
		<?php dynamic_sidebar( 'above-content-widget' ); ?>
	</div><!-- #content-widget -->
<?php endif; ?>

<?php
	if ( is_front_page() && dswoddil_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>

<div class="container content">
	<div class="row">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div class="col-md-3">
			<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</div><!-- #primary-sidebar -->
		</div>
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) : ?>
		<div class="col-md-6">
	<?php else: ?>
		<div class="col-md-9">
	<?php endif; ?>
			<?php
			if ( have_posts() ) : 
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

				endwhile;
				// Previous/next post navigation.
				dswoddil_paging_nav();

			else:
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );
			endif;

			?>
		</div><!-- .col-md-9 -->
		<div class="col-md-3">
			<?php get_sidebar(); ?>
		</div><!-- .col-md-3 -->
	</div><!-- .row -->
</div><!-- .content -->

<?php
get_footer();