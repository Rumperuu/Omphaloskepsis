<?php
	/**
	 * The template part for displaying single Posts.
	 *
	 * @package Omphaloskepsis
	 * @since Omphaloskepsis 1.0
	 */

?>

<article id="wrapper" <?php post_class(); ?>>
	<header style="background-image: url('<?php the_post_thumbnail_url(); ?>');">
		<div>
			<h1 id="post-title">
			<?php echo wp_kses_post( get_the_title() ); ?>
			</h1>

			<?php
			$subtitle = get_post_meta( get_the_ID(), 'Subtitle', true );
			if ( $subtitle ) :
				?>
			<h2 id="post-subtitle">
				<?php echo wp_kses_post( $subtitle ); ?>
			</h2>
			<?php endif; ?>
		</div>
	</header><!-- .entry-header -->

	<main id="post-body" class="body">

	<?php $date1 = strtotime( get_the_date( 'Y-m-d' ) ); ?>
	<?php $date2 = strtotime( gmdate( 'Y-m-d' ) ); ?>
	<?php if ( has_category( 'series' ) || has_tag( 'ohwhatohjeez' ) || get_post_meta( get_the_ID(), 'Note(s)', true ) || get_post_meta( get_the_ID(), 'License', true ) || ( $date1 < $date2 - 31557600 ) ) : ?>
		<div id="details">
			<ul>

			<?php
			if ( has_category( 'thoughts' ) ) {
				$post_category = 'thought';
			} elseif ( has_category( 'reports' ) ) {
				$post_category = 'report';
			} elseif ( has_category( 'review' ) ) {
				$post_category = 'review';
			}

			if ( has_category( 'series' ) ) {
				$category_text = 'is a part of the following series';
				$series        = array();
				$series_item   = get_category_by_slug( 'series' );
				$series_ids    = get_term_children( $series_item->term_id, 'category' );

				foreach ( $series_ids as $this_series_id ) {
					if ( has_category( $this_series_id ) ) {
						array_push( $series, get_category( $this_series_id ) );
					}
				}
				if ( count( $series ) > 1 ) {
					$category_text .= '&rsquo;';
				}
				$punct = ':';
				foreach ( $series as $this_series ) {
					$category_text .= $punct . ' ';
					if ( ':' === $punct ) {
						$punct = ';';
					}
					$category_text .= '<a href="/category/series/' . $this_series->slug . '">' . $this_series->name . '</a>';
				}
				$category_text .= '.';
				echo '<li>';
				echo wp_kses_post( "This <a href='/category/$post_category'>$post_category</a> $category_text" );
				echo '</li>';
			}
			?>

			<?php if ( $date1 < $date2 - 31557600 ) : ?>
				<li>This piece was written over a year ago. It may no longer accurately reflect my views now, or may be factually outdated.</li>
			<?php endif; ?>

			<?php if ( has_tag( 'ohwhatohjeez' ) ) : ?>
				<li>This piece was originally written for my old site, Oh What? Oh Jeez! As such, it may not have transferred over properly and some images and links might be broken (and, to a lesser extent, my writing from years ago is about 80% run-on sentences).</li>
			<?php endif; ?>

			<?php
				$notes = get_post_meta( get_the_ID(), 'Note(s)', true );
			if ( $notes ) :
				?>
				<li><?php echo wp_kses_post( $notes ); ?></li>
			<?php endif; ?>

			<?php
				$license = get_post_meta( get_the_ID(), 'License', true );
			if ( $license ) :
				?>
				<li>This work is licensed under <?php echo esc_html( $license ); ?>. <a href="/2018/03/copywrong/">Sorry about that</a>.</li>
			<?php endif; ?>

			</ul>
		</div>
	<?php endif; ?>

	<?php
	if ( get_the_content() ) :
		the_content();
	else :
		echo esc_html( get_the_excerpt() );
	endif;
	?>

	</main><!-- .entry-content -->

	<footer id="post-meta">

		<h1>Post Meta</h1>

		<?php
		$date_format_holocene  = 'F j\<\s\u\p\>S\</\s\u\p\>, 1Y \<\a\b\b\r \t\i\t\l\e\=\"\H\o\l\o\c\e\n\e \E\r\a\"\>\H\.\E\.\</\a\b\b\r\>';
		$date_format_gregorian = 'F jS, Y \C\.\E\. \(\G\r\e\g\o\r\i\a\n\)';

		$date_holocene  = get_the_date( $date_format_holocene );
		$date_gregorian = get_the_date( $date_format_gregorian );
		?>
		<section id="post-dates">
			<p><strong>Published:</strong>&nbsp;
				<span title="<?php echo esc_html( $date_gregorian ); ?>">
				<?php echo wp_kses_post( $date_holocene ); ?>
				</span>
			</p>
			<?php
			$modified_date_holocene  = get_the_modified_date( $date_format_holocene );
			$modified_date_gregorian = get_the_modified_date( $date_format_gregorian );
			if ( $modified_date_holocene ) :
				?>
			<p><strong>Last Modified:</strong>&nbsp;
				<span title="<?php echo esc_html( $modified_date_gregorian ); ?>">
				<?php echo wp_kses_post( $modified_date_holocene ); ?>
				</span>
			</p>
			<?php endif; ?>
		</section>

		<?php
		$content = get_post_meta( get_the_ID(), 'External_Link', false );
		if ( $content ) :
			?>
		<section id="post-links">
			<h2>External Link<?php echo ( count( $content ) > 1 ) ? 's' : ''; ?></h2>
			<?php foreach ( $content as $ext_link ) : ?>
				<?php
				$split_link = explode( ';;', $ext_link );
				$link_title = ( count( $split_link ) > 1 ) ? wp_kses_post( $split_link[0] ) : 'Link';
				$link_href  = ( count( $split_link ) > 1 ) ? $split_link[1] : $split_link[0];
				?>
			<a href="<?php echo esc_url( $link_href ); ?>" target="_blank" rel="noopener noreferrer">
				<?php echo wp_kses_post( $link_title ); ?>
			</a>
			<?php endforeach; ?>
		</section>
		<?php endif; ?>

		<?php
		$has_table_of_contents = ! ! get_post_meta( get_the_ID(), 'ToC1', true );
		if ( $has_table_of_contents ) :
			?>
		<section id="post-contents">
			<h2>Contents</h2>
			<ol>
			<?php
			// phpcs:disable WordPress.CodeAnalysis.AssignmentInCondition
			$i = 1;
			while ( $section_title = get_post_meta( get_the_ID(), 'ToC' . $i, true ) ) :
			?>
				<li>
					<a href="#section-<?php echo esc_attr( $i++ ); ?>">
					<?php echo wp_kses_post( $section_title ); ?>
					</a>
				</li>
			<?php
			endwhile;
			// phpcs:enable 
			?>
			</ol>
		</section>
		<?php endif; ?>

		<?php
		$tags = get_the_tags( get_the_ID() );
		if ( $tags ) :
			?>
		<section id="post-tags">
			<h2>Tags</h2>
			<?php foreach ( $tags as $post_tag ) : ?>
				<a href="<?php echo esc_url( get_tag_link( $post_tag->term_id ) ); ?>" title="<?php echo esc_attr( $post_tag->name ); ?> Tag" class="tag-link">
					<?php echo wp_kses_post( $post_tag->name ); ?>
				</a>
			<?php endforeach; ?>
		</section>
	<?php endif; ?>

	</footer>

</article><!-- #post-## -->
