<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage DSW_oddil
 * @since DSW oddil 1.0
 */

get_header(); ?>

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
					// Start the Loop.
					while ( have_posts() ) : the_post();

						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'single' );

						// Previous/next post navigation.
						dswoddil_post_nav();

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
					endwhile;
				?>
			</section><!-- .col-md-9 -->
			<?php get_template_part( 'template-parts/sidebar', 'right' ); ?>
		</main><!-- #main .row -->
	</div><!-- #primary .content -->

<?php get_footer(); ?>
