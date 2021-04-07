<?php
/**
 * The template for displaying the header.
 *
 * @package Omphaloskepsis
 * @since Omphaloskepsis 1.0
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php $index = get_post_meta( get_the_ID(), 'Index', true ); ?>
	<?php if ( ! ( is_single() && ! is_page() && $index ) ) : ?>
		<meta name="robots" content="noindex">
	<?php endif; ?>
		<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
		<?php wp_head(); ?>
		<?php // phpcs:disable WordPress.WP.EnqueuedResources ?> 
		<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
		<?php // phpcs:enable ?>
	</head>

	<body <?php body_class(); ?> id="site-wrapper">
		<?php if ( ! is_page_template( 'centred-page.php' ) && ! is_404() ) : ?>
		<header id="site-header">
		<nav id="site-header-nav">
			<div class="site-header-nav-item"><a href="/"><h1>Ben Goldsworthy</a></div>
			<div class="site-header-nav-item"><h2>Views my own. Do try this at home.</h2></div>
			<div class="site-header-nav-item"><p>~ <a href="mailto:me+bg@bengoldsworthy.net"><i class="fa fa-envelope"></i></a> ~ <a href="bitcoin:1HApEg2robrRCx4rTKKeFj25unoaX65QUc"><i class="fa fa-btc"></i></a> ~ <a href="https://github.com/Rumperuu"><i class="fa fa-github"></i></a> ~ <a href="/0x30D22F41.asc"><i class="fa fa-key"></i></a> ~ <a href="/feed"><i class="fa fa-rss"></i></a> ~</p></div>
			<div class="site-header-nav-item"><a href="/blog">Blog</a></div>
			<div class="site-header-nav-item"><a href="/portfolios">Portfolios</a></div>
			<div class="site-header-nav-item"><a href="/social-cataloguing">Social Cataloguing</a></div>
		</nav>
		</header>
		<?php endif; ?>
