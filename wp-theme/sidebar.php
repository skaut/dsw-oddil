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
			$dswoddil_menu_data = wp_nav_menu( array(
				'menu'              => 'secondary',
				'theme_location'    => 'secondary',
				'depth'             => 0,
				'container'         => 'div',
				'container_class'   => 'collapse navbar-collapse',
				'container_id'      => 'bs-example-navbar-collapse-1',
				'menu_class'        => 'nav navbar-nav sidebar-bav',
				'fallback_cb'       => 'dswoddil_bootstrap_navwalker::fallback',
				'walker'            => new dswoddil_bootstrap_navwalker())
			);

			echo $dswoddil_menu_data;
		?>
	</nav>
	<?php endif; ?>


	<div id="content-sidebar" class="content-sidebar widget-area" role="complementary">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar( 'right-sidebar' ) ) : ?>
		<?php endif; ?>
	</div><!-- #primary-sidebar -->

</div><!-- #secondary -->
