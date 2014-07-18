<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="DSW Team">
		<link rel="shortcut icon" href="../../assets/ico/favicon.ico">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<title>DSW Oddíl</title>

		<!-- Custom styles for this template -->
		<link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div class="container brand">
			<?php if ( is_active_sidebar( 'header-left' ) ) : ?>
				<div id="header-right" class="header-right widget-area pull-left" role="complementary">
					<?php dynamic_sidebar( 'header-left' ); ?>
				</div><!-- #header-left -->
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'header-right' ) ) : ?>
				<div id="header-right" class="header-right widget-area pull-right" role="complementary">
					<?php dynamic_sidebar( 'header-right' ); ?>
				</div><!-- #header-right -->
			<?php endif; ?>
			<h1><?php bloginfo('name'); ?></h1>
			<h4><?php bloginfo('description'); ?></h4>
		</div>
		<div class="main shadow">
			<div class="container">
				<?php if ( get_header_image() ) : ?>
				<div id="site-header">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img class="img-responsive" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
					</a>
				</div>
				<?php endif; ?>

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
						<div class="collapse navbar-collapse">
							<ul class="nav navbar-nav">
								<li class="home-icon">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
										<img src="/wp-content/themes/dsw-oddil/img/home.png" />
									</a>
								</li>
								<?php
									wp_nav_menu(
										array(
											'fallback_cb' => 'ter_navbar_fallback',
											'theme_location' => 'primary',
											'menu_class' => 'nav-menu',
											'container' => false,
											'items_wrap' => '%3$s',
											'walker' => new TerWalkerNavMenu()
										)
									);
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>