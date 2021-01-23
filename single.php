<?php
/**
 * The template for displaying all single Pages.
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
		// Include the single post content template.
		get_template_part( 'template-parts/content', 'single' );

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		// End of the loop.
		endwhile;
	?>
</main><!-- .site-main -->

<?php get_footer(); ?>
