<?php
   /**
	* The template part for displaying content.
	*
	* @package WordPress
	* @subpackage Omphaloskepsis
	* @since Omphaloskepsis 1.0
	*/
?>

<a class="item" href="<?php echo ( $link = get_post_meta( get_the_ID(), 'External_Link', true ) ) ? $link : get_the_permalink(); ?>" <?php echo ( $link ) ? 'target="_blank"' : ''; ?>>
   <article id="post-<?php the_ID(); ?>" class="tile col-m-6 col-4 col-w-3" style="background-image: url('<?php the_post_thumbnail_url(); ?>');">
   <?php
	if ( strlen( get_the_title() ) > 70 ) {
		$small = 'vsmall';
	} elseif ( strlen( get_the_title() ) > 35 ) {
		$small = 'small';
	} elseif ( strlen( get_the_title() ) > 12 ) {
		$small = 'qsmall';
	}
	?>
	  <header>
		 <h1 class="<?php echo $small; ?> post-title"><?php echo get_the_title(); ?></h1>
	  <?php if ( $subtitle = get_post_meta( get_the_ID(), 'Subtitle', true ) ) : ?>
		 <h2><?php echo $subtitle; ?></h2>
	  <?php endif; ?>
	  </header>
   </article><!-- #post-## -->
</a>
