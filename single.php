<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage DSW_oddil
 * @since DSW oddil 1.0
 */

get_header(); ?>

<div class="container content">
	<div class="row">
		<div class="col-md-9">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

					// Previous/next post navigation.
					dswoddil_post_nav();

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>
		</div><!-- .col-md-9 -->
		<div class="col-md-3">
			<?php get_sidebar(); ?>
		</div><!-- .col-md-3 -->
	</div><!-- .row -->
</div><!-- .content -->

<?php
get_sidebar( 'content' );
get_footer();
