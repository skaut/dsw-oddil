<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage dsw_oddil
 * @since DSW oddil 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php dswoddil_post_thumbnail(); ?>
		<?php
			if ( is_single() ) :
				the_title( sprintf( '<h2 class="entry-title">' ), '</h2>' );
			else :
				the_title( sprintf( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' ), '</a></h2>' );
			endif;
		?>
		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
					<?php dswoddil_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content media">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'dswoddil' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'dswoddil' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
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
	<?php endif; ?>
</article><!-- #post-## -->
