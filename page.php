<?php
/**
 * The template for displaying pages.
 *
 * @package Omphaloskepsis
 * @since Omphaloskepsis 1.0
 */

?>

<?php get_header(); ?>

<main id="split-page" role="main">
	<?php
		// Start the loop.
	while ( have_posts() ) :
		the_post();

		// Include the page content template.
		get_template_part( 'template-parts/content', 'page' );

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}

			// End of the loop.
		endwhile;
	?>
</main>

<?php get_footer(); ?>
