<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="<?php echo theme_url();?>/assets/images/pavicon.png" title="Favicon" />
<title><?php echo site_title( $site_title ); ?></title>
<?php if ( isset( $meta_description ) ) { ?>
<meta name="description" content="<?php echo $meta_description; ?>" />
<meta property="og:description" content="<?php echo $meta_description; ?>" />
<?php } ?>

<meta property="og:site_name" content="<?php echo get_option( 'site_name' ); ?>" />
<meta property="og:title" content="<?php echo $site_title; ?>" />
<meta property="og:url" content="<?php echo canonical_url(); ?>" />

<?php if ( isset( $meta_robots ) ) { ?>
<meta name="robots" content="<?php echo $meta_robots; ?>" />
<?php } ?>

<?php if ( isset( $result[0]['image'] ) ) { ?>
<meta property="og:image" content="<?php echo photon_cdn($result[0]['image']); ?>" />
<?php } elseif ( isset( $result['image'] ) ) { ?>
<meta property="og:image" content="<?php echo photon_cdn($result['image']); ?>" />
<?php } ?>
<link rel="canonical" href="<?php echo canonical_url(); ?>" />
<?php register_stylesheet( theme_url() . '/assets/css/font-awesome.min.css' ); ?>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
<?php register_stylesheet( theme_url() . '/assets/css/bootstrap.min.css' ); ?>
<?php register_stylesheet( theme_url() . '/assets/css/style.css' ); ?>
<?php register_script( theme_url() . '/assets/js/jquery.min.js' ); ?>
<?php register_script( theme_url() . '/assets/js/bootstrap.min.js' ); ?>
<link href="<?php echo canonical_url(); ?>" rel="alternate" hreflang="<?php echo get_option('language'); ?>">
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
				</button> <a class="navbar-brand" href="/"><?php echo get_option( 'site_name' ); ?></a>
			</div>
			<div class="collapse navbar-collapse" id="menu">
				<ul class="nav navbar-nav">
					<li>
						<a href="<?php echo disclaimer_permalink(); ?>" title="Disclaimer">Disclaimer</a>
					</li>
					<li>
						<a href="<?php echo tos_permalink(); ?>" title="Term Of Services">TOS</a>
					</li>
					<li>
						<a href="https://dugagece.blogspot.com/2018/02/agc-mp3-gratis-2018.html" title="Download">Download Script</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div id="header">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="logo">
						<h1><a href="<?php echo site_url(); ?>"><?php echo get_option( 'site_name' ); ?></a></h1>
						<h2 class="description"><?php echo get_option( 'site_tagline' ); ?></h2>
					</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="search">
						<form id="autoform" method="get" action="<?php echo site_url(); ?>">
							<div class="input-group col-lg-12">
								
								<input type="text" name="searching" class="form-control input-lg ui-autocomplete-input" autofocus="autofocus" id="searching" value="<?php echo get_search_query(); ?>" autocomplete="off" placeholder="Search for your favorite song" required="">
<span class="input-group-btn"><button class="btn btn-primary btn-lg" type="submit">SEARCH</button></span>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>