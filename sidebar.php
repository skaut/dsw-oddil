<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage DSW_oddil
 * @since DSW oddil 1.0
 */
?>
<div id="secondary">
	<?php if ( has_nav_menu( 'secondary' ) ) : ?>
	<nav role="navigation" class="navigation site-navigation secondary-navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>
	</nav>
	<?php endif; ?>


	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
		<?php endif; ?>
	</div><!-- #primary-sidebar -->

</div><!-- #secondary -->
