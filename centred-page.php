<?php
/**
 * Template Name: Centred Page
 *
 * Displays a full-screen page with content in the center.
 *
 * @package Omphaloskepsis
 * @since Omphaloskepsis 1.0
 */

get_header(); ?>

<main id="centred-page" role="main">
<?php
while ( have_posts() ) :
	the_post();
	?>
   <h1><?php echo wp_kses_post( get_the_title() ); ?></h1>
   <h2><?php the_content(); ?></h2>
<?php endwhile; ?>
</main>

<?php get_footer(); ?>
