<?php
/**
 * The template for displaying search results pages.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage DSW_oddil
 * @since DSW oddil 1.0
 */

get_header(); ?>

	<section id="primary" class="content-area container content">
		<main id="main" class="site-main row" role="main">
			<?php get_template_part( 'template-parts/sidebar', 'left' ); ?>
			<?php
			$col = 12;
			if ( is_active_sidebar( 'left-sidebar' ) ) { $col -= 3; }
			if ( is_active_sidebar( 'right-sidebar' ) ) { $col -= 3; }
			?>
				<section class="col-md-<?php echo $col; ?>">

				<?php if ( have_posts() ) : ?>

					<header class="page-header">
						<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'dswoddil' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</header><!-- .page-header -->

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );
						?>

					<?php endwhile; ?>

					<?php the_posts_navigation(); ?>

				<?php else : ?>

					<?php get_template_part( 'template-parts/content', 'none' ); ?>

				<?php endif; ?>

			</section><!-- .col-md-9 -->
			<?php get_template_part( 'template-parts/sidebar', 'right' ); ?>
		</main><!-- #main .row -->
	</section><!-- #primary .content -->

<?php get_footer(); ?>
