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
	  <h1><?php echo wp_kses_post( ( 'post' === get_post_type() ) ? single_cat_title() : ucfirst( get_post_type() ) . 's' ); ?>.</h1>
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
   
   <section id="grid" class="row">
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
			get_template_part( 'template-parts/content', get_post_format() );
			// End the loop.
	 endwhile;
		// If no content, include the "No posts found" template.
	  else :
		  get_template_part( 'template-parts/content', 'none' );
	  endif;
		?>
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
