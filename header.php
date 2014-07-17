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
	<body>
		<div class="container brand">
			<img class="logo pull-left img-responsive" src="<?php bloginfo('template_url'); ?>/img/logo-vetrnik.png" />
			<img class="logo pull-right img-responsive img-collapse" src="<?php bloginfo('template_url'); ?>/img/logo-skaut.png" />
			<img class="logo pull-right img-responsive img-collapse" src="<?php bloginfo('template_url'); ?>/img/logo-wosm.png" />
			<img class="logo pull-right img-responsive img-collapse" src="<?php bloginfo('template_url'); ?>/img/logo-wagggs.png" />
			<img class="logo pull-right img-responsive img-collapse" src="<?php bloginfo('template_url'); ?>/img/logo-vodni-skauting.png" />
			<h1><?php bloginfo('name'); ?></h1>
			<h4><?php bloginfo('description'); ?></h4>
		</div>
		<div class="main shadow">
			<div class="container">
				<img class="img-responsive" src="<?php bloginfo('template_url'); ?>/img/header3.png" />
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