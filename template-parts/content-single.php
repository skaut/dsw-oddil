<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage DSW_oddil
 * @since DSW oddil 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php dswoddil_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'dswoddil' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<div class="entry-meta">
		<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && dswoddil_categorized_blog() ) : ?>
			<span class="cat-links"><?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'dswoddil' ) ); ?></span>
		<?php endif; ?>
			<?php
				if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
			?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'dswoddil' ), __( '1 Comment', 'dswoddil' ), __( '% Comments', 'dswoddil' ) ); ?></span>
			<?php
				endif;

				edit_post_link( __( 'Edit', 'dswoddil' ), '<span class="edit-link">', '</span>' );
			?>
			<?php the_tags( '<span class="tag-links">', '', '</span>' ); ?>
		</div><!-- .entry-meta -->
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->