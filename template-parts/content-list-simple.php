<?php
	/**
	 * The template part for displaying lists of simple items.
	 *
	 * @package Omphaloskepsis
	 * @since Omphaloskepsis 1.0
	 */

?>

<li id="<?php echo esc_attr( get_the_ID() ); ?>" <?php post_class(); ?>>
	<a class="item" href="<?php echo esc_url( get_the_permalink() ); ?>">
		<?php echo wp_kses_post( get_the_title() ); ?>
		<?php
		$subtitle = get_post_meta( get_the_ID(), 'Subtitle', true );
		if ( $subtitle ) :
			?>
		: <?php echo wp_kses_post( $subtitle ); ?>
			<?php
		endif;
		?>
	</a>
</li>
