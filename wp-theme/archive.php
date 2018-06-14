<?php
/**
 * The template for displaying archive pages.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
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
			if ( is_active_sidebar( 'left-sidebar' ) ) { $col -= 3; }
			if ( is_active_sidebar( 'right-sidebar' ) ) { $col -= 3; }
			?>
			<section class="col-md-<?php echo esc_attr( $col ); ?>">

				<?php if ( have_posts() ) : ?>

					<header class="page-header">
						<?php
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="taxonomy-description">', '</div>' );
						?>
					</header><!-- .page-header -->

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );
						?>

					<?php endwhile; ?>

					<?php the_posts_navigation(); ?>

				<?php else : ?>

					<?php get_template_part( 'template-parts/content', 'none' ); ?>

				<?php endif; ?>

			</section><!-- .col-md-9 -->
			<?php get_template_part( 'template-parts/sidebar', 'right' ); ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
