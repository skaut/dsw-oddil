<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage DSW_oddil
 * @since DSW oddil 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area container content">
		<main id="main" class="site-main row" role="main">
			<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
				<section class="col-md-3">
					<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
						<?php dynamic_sidebar( 'sidebar-1' ); ?>
					</div><!-- #primary-sidebar -->
				</section>
			<?php endif; ?>
			<?php
				$col = 12;
				if ( is_active_sidebar( 'sidebar-1' ) ) $col -= 3;
				if ( is_active_sidebar( 'content' ) ) $col -= 3;
			?>
			<section class="col-md-<?php echo $col; ?>">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'page' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // End of the loop. ?>
			</section><!-- .col-md-9 -->
			<?php get_template_part( 'template-parts/sidebar', 'right' ); ?>ndif; ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
