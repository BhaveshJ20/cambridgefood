<?php
/*
 * The header for our theme
 */
?>

<!doctype html>
<html <?php language_attributes(); ?> class="no-js no-svg">

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Cambridge Food <?php wp_title(); ?></title>
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<link rel="shortcut icon" href="<?php echo get_field('favicon_icon', 'option'); ?>">	
	<?php if (is_singular() && pings_open(get_queried_object())) : ?>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
	<div id="fb-root"></div>
	<script async defer src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.2"></script>
	<script type='text/javascript'>
		(function (d, t) {
		var bh = d.createElement(t), s = d.getElementsByTagName(t)[0];
		bh.type = 'text/javascript';
		bh.src = 'https://www.bugherd.com/sidebarv2.js?apikey=qbq6lpovsax9cuhexhnxbq';
		s.parentNode.insertBefore(bh, s);
		})(document, 'script');
	</script>
</head>
<body <?php body_class(); ?>>
<?php global $wp; ?>
<input type="hidden" name="page_url" id="page_url" value="<?php echo home_url( $wp->request ); ?>">
<div class="preloader">
	<div class="preloader-icon">
		<span class="loading-dot loading-dot-1"></span>
		<span class="loading-dot loading-dot-2"></span>
		<span class="loading-dot loading-dot-3"></span>
	</div>
</div>
<header class="main-nav">
	<nav>
		<div class="container">
			<!-- stellarnav -->
			<div class="stellarnav">
				<?php get_template_part( 'template-parts/header/header', 'image' ); ?>
				<?php get_template_part( 'template-parts/navigation/header', 'navigation' ); ?>
				<div class="clearfix"></div>
				</div>
			</div>
			<!-- .stellarnav -->
		</div>
	</nav>
</header>
