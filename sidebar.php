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
		<?php
			wp_nav_menu( array(
				'menu'              => 'secondary',
				'theme_location'    => 'secondary',
				'depth'             => 3,
				'container'         => 'div',
				'container_class'   => 'collapse navbar-collapse',
				'container_id'      => 'bs-example-navbar-collapse-1',
				'menu_class'        => 'nav navbar-nav sidebar-nav',
				'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
				'walker'            => new wp_bootstrap_navwalker())
			);
		?>
	</nav>
	<?php endif; ?>


	<div id="content-sidebar" class="content-sidebar widget-area" role="complementary">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar( 'sidebar-2' ) ) : ?>
		<?php endif; ?>
	</div><!-- #primary-sidebar -->

</div><!-- #secondary -->
