<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif; ?>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div class="container brand">
			<?php if ( is_active_sidebar( 'header-left' ) || has_site_icon() ) : ?>
				<div id="header-right" class="header-right widget-area pull-left" role="complementary">
					<?php if ( is_active_sidebar( 'header-left' ) ) : dynamic_sidebar( 'header-left' ); ?>
					<?php elseif ( has_site_icon() ) : dswoddil_custom_brand_icon(); ?>
					<?php endif; ?>
				</div><!-- #header-left -->
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'header-right' ) ) : ?>
				<div id="header-right" class="header-right widget-area pull-right" role="complementary">
					<?php dynamic_sidebar( 'header-right' ); ?>
				</div><!-- #header-right -->
			<?php endif; ?>
		<?php
			if ( is_front_page() && is_home() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php else : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php endif;
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) :
		?>
			<h4 class="site-description"><?php echo $description; ?></h4>
		<?php endif; ?>
		</div>
		<div class="main shadow">
			<div class="container">
				<?php if ( get_header_image() ) : ?>
				<div id="site-header">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img class="img-responsive" src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
					</a>
				</div>
				<?php endif; ?>
				<?php if ( has_nav_menu( 'primary' ) ) { ?>
				<div class="navbar navbar-default" role="navigation">
					<div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
					 		</button>
					 	</div>
						<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
							<?php
								$dswoddil_menu_data = array(
									'echo'				=> true,
									'menu'              => 'primary',
									'theme_location'    => 'primary',
									'depth'             => 0,
									'container'         => 'div',
									'container_class'   => 'collapse navbar-collapse',
									'container_id'      => 'bs-example-navbar-collapse-1',
									'menu_class'        => 'nav navbar-nav',
									'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
									'walker'            => new wp_bootstrap_navwalker(),
								);
								wp_nav_menu( $dswoddil_menu_data );
							?>
						</nav>
					</div>
				</div>
				<?php } ?>
			</div>

			<?php if ( is_active_sidebar( 'top-widget' ) ) : ?>
			<div id="top-widget" class="top-widget widget-area container optional" role="complementary">
				<?php dynamic_sidebar( 'top-widget' ); ?>
			</div><!-- #content-widget -->
			<?php endif; ?>
