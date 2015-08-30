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

get_header(); ?>

	<?php
		if ( is_front_page() && dswoddil_has_featured_posts() ) {
			// Include the featured content template.
			get_template_part( 'featured-content' );
		}
	?>

	<div id="primary" class="content-area container content">
		<main id="main" class="site-main row" role="main">
		<?php get_template_part( 'template-parts/sidebar', 'left' ); ?>
		<?php
			$col = 12;
			if ( is_active_sidebar( 'left-sidebar' ) ) $col -= 3;
			if ( is_active_sidebar( 'right-sidebar' ) ) $col -= 3;
		?>
			<section class="col-md-<?php echo $col; ?>">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();

						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );

					endwhile;
					// Previous/next post navigation.
					dswoddil_paging_nav();

				else:
					// If no content, include the "No posts found" template.
					get_template_part( 'template-parts/content', 'none' );
				endif;

				?>
			</section><!-- .col-md-9 -->
			<?php get_template_part( 'template-parts/sidebar', 'right' ); ?>
		</main><!-- #main .row -->
	</div><!-- #primary .content -->

<?php get_footer(); ?>
