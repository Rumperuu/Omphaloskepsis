<?php
/**
 * The template for displaying portfolio archives.
 *
 * @package Omphaloskepsis
 * @since Omphaloskepsis 1.0
 */

get_header(); ?>

<main id="list-page" class="col-10 col-m-12" role="main">
	<header>
		<h1>Quotes.</h1>
		<?php
		echo wp_kses_post(
			get_the_posts_pagination(
				array(
					'screen_reader_text' => ' ',
					'mid_size'           => 20,
					'prev_text'          => '',
					'next_text'          => '',
				)
			)
		);
		?>
	</header>

	<section class="row">
		<ul>
		<?php
		if ( have_posts() ) :
			// Start the loop.
			while ( have_posts() ) :
				the_post();

				/*
				* Include the Post-Format-specific template for the content.
				* If you want to override this in a child theme, then include a file
				* called content-___.php (where ___ is the Post Format name) and that will be used instead.
				*/
				get_template_part( 'template-parts/content', 'list-simple' );
				// End the loop.
			endwhile;
			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		?>
		</ul>
	</section><!-- .site-main -->
	
	<footer>
		<?php
		echo wp_kses_post(
			get_the_posts_pagination(
				array(
					'screen_reader_text' => ' ',
					'mid_size'           => 20,
					'prev_text'          => '',
					'next_text'          => '',
				)
			)
		);
		?>
	</footer>
</main><!-- .content-area -->

<?php get_footer(); ?>
