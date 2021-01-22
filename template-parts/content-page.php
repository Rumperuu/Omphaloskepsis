<?php
/**
 * The template used for displaying page content.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?>

<article id="wrapper" <?php post_class(); ?>>
<header style="background-image: url('<?php the_post_thumbnail_url(); ?>');">
<div>
<h1 id="post-title"><?php echo esc_html( get_the_title() ); ?></h1>
<?php
$subtitle = get_post_meta( get_the_ID(), 'Subtitle', true );
if ( $subtitle ) :
	?>
<h2 id="post-subtitle"><?php echo esc_html( $subtitle ); ?></h2>
<?php endif; ?>
</div>
</header><!-- .entry-header -->

<main id="page-body" class="body">
<?php
if ( get_the_content() ) :
	the_content();
else :
	echo esc_html( get_the_excerpt() );
endif;
?>
</main><!-- .entry-content -->
</article><!-- #post-## -->
