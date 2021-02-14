<?php
	/**
	 * The template part for displaying content.
	 *
	 * @package Omphaloskepsis
	 * @since Omphaloskepsis 1.0
	 */

?>

<?php
	// For Posts with a) a single external link and b) no body content, just make
	// the item link directly to the external resource.
	$has_one_external_link = count( get_post_meta( get_the_ID(), 'External_Link', false ) ) === 1;
	$has_body_content      = ! ! get_the_content();
	$links_externally      = $has_one_external_link && ! $has_body_content;
	$split_link            = explode( ';;', get_post_meta( get_the_ID(), 'External_Link', true ) );
	$link_href             = ( count( $split_link ) > 1 ) ? $split_link[1] : $split_link[0];
	$post_link             = ( $links_externally ) ? $link_href : get_the_permalink( get_the_ID() );
?>
<a class="item" href="<?php echo esc_url( $post_link ); ?>"<?php echo ( $links_externally ) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
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
		<?php
		$post_status = get_post_meta( get_the_ID(), 'Status', true );
		if ( $post_status ) :
			?>
			<span class="status-banner status-banner--<?php echo esc_attr( lcfirst( $post_status ) ); ?>"><?php echo wp_kses_post( $post_status ); ?></span>
		<?php endif; ?>
			<h1 class="<?php echo esc_attr( $small ); ?> post-title">
			<?php echo wp_kses_post( get_the_title() ); ?>
			</h1>
		<?php
		$subtitle = get_post_meta( get_the_ID(), 'Subtitle', true );
		if ( $subtitle ) :
			?>
			<h2>
			<?php echo wp_kses_post( $subtitle ); ?>
			</h2>
		<?php endif; ?>
		</header>
	</article><!-- #post-## -->
</a>
