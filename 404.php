<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package dsw-oddil
 */

get_header(); ?>

	<div id="primary" class="content-area container content">
		<main id="main" class="site-main row" role="main">
			<?php
				$col = 12;
				if ( is_active_sidebar( 'sidebar-1' ) ) $col -= 3;
				if ( is_active_sidebar( 'content' ) ) $col -= 3;
			?>
			<section class="error-404 not-found col-md-<?php echo $col; ?>">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'dswoddil' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'dswoddil' ); ?></p>

					<?php get_search_form(); ?>

					<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<?php if ( dswoddil_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
					<div class="widget widget_categories">
						<h2 class="widget-title"><?php _e( 'Most Used Categories', 'dswoddil' ); ?></h2>
						<ul>
						<?php
							wp_list_categories( array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
							) );
						?>
						</ul>
					</div><!-- .widget -->
					<?php endif; ?>

					<?php
						/* translators: %1$s: smiley */
						$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'dswoddil' ), convert_smilies( ':)' ) ) . '</p>';
						the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
					?>

					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

			<?php if ( is_active_sidebar( 'content' ) ) : ?>
			<section class="col-md-3">
				<?php get_sidebar( 'content' ); ?>
			</section><!-- .col-md-3 -->
			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
