<?php
   /**
	* The template for showing experience (by organisation).
	*
	* @package WordPress
	* @subpackage Omphaloskepsis
	* @since Omphaloskepsis 1.0
	*/
?>

<?php get_header(); ?>

<?php
   // Gets all of the roles attached to the given organisation.
   $company = get_queried_object();
   echo '<!-- ' . $company->name . '-->';
   $args = array(
	   'post_type' => array( 'job' ),
	   'tax_query' => array(
		   array(
			   'taxonomy' => 'company',
			   'field'    => 'slug',
			   'terms'    => $company->slug,
		   ),
	   ),
	   'posts_per_page' => -1,
   );

   $loop = new WP_Query( $args );
	?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
   google.charts.load('current', {'packages':['timeline']});
   
   <?php if ( $loop->have_posts() ) : ?>
   google.charts.setOnLoadCallback(drawChart);
   <?php endif; ?>
   
   function drawChart() {
	  var container = document.getElementById('timeline');
	  var chart = new google.visualization.Timeline(container);
	  var dataTable = new google.visualization.DataTable();
	 
	  dataTable.addColumn({ type: 'string', id: 'Type' });
	  dataTable.addColumn({ type: 'string', id: 'Job Title' });
	  dataTable.addColumn({ type: 'date', id: 'Start' });
	  dataTable.addColumn({ type: 'date', id: 'End' });
	  dataTable.addRows([
	  <?php
		while ( $loop->have_posts() ) :
			$loop->the_post();
			// Gets all of the roles associated with this organisation and its
			// child organisations.
			$companies = wp_get_object_terms( get_the_ID(), 'company' );
			$i = 0;
			$currSizeOf = -1;

			foreach ( $companies as $company ) {
				if ( sizeof( get_ancestors( $company->term_id, 'company' ) ) > $currSizeOf ) {
					$currSizeOf = sizeof( get_ancestors( $company->term_id, 'company' ) );
					$lowestDepthCompany = $i++;
				}
			}

			$title = html_entity_decode( get_the_title() );
			$start = get_the_date();
			$end = ( ! get_post_meta( get_the_ID(), 'end-date', true ) ) ? date( 'D M d Y H:i:s O' ) : get_post_meta( get_the_ID(), 'end-date', true );
			echo "[ '" . html_entity_decode( $companies[ $lowestDepthCompany ]->name ) . "', '$title', new Date('$start'), new Date('$end') ],\n";
	  endwhile;
		?>
	  ]);
	  
	  // Draws the table, then resizes the element height and re-draws it
	  // to avoid needing to scroll vertically.
	  chart.draw(dataTable);
	  var realheight = parseInt(jQuery("#timeline div:first-child div:first-child div:first-child div svg").attr("height"))+70;
	  var options = {};
	  options.height = realheight;
	  chart.draw(dataTable, options);
   }
</script>

<main id="split-page" role="main">
<?php
   $companyLogo = apply_filters( 'taxonomy-images-queried-term-image-url', '', array( 'image_size' => 'full' ) );
   $companyName = get_queried_object()->name;
?>
   <div id="wrapper">
	  <header style="background-image: url('<?php echo $companyLogo; ?>'); background-color: <?php echo get_term_meta( get_queried_object()->term_id, 'color' )[0]; ?>; background-size: contain;">
		 <div>
		 <?php
			if ( strlen( $companyName ) > 70 ) {
				$small = '2em';
			} elseif ( strlen( $companyName ) > 35 ) {
				$small = '3em';
			} elseif ( strlen( $companyName ) > 12 ) {
				$small = '4em';
			} else {
				$small = '5em';
			}
			?>
			<h1 id="post-title" style="font-size: <?php echo $small; ?>;"><?php echo $companyName; ?></h1>
		 </div>
	  </header><!-- .entry-header -->
	
	  <main id="organisation-body" class="body">
		 <section id="description">
			<?php the_archive_description(); ?>
		 </section>
		 <?php if ( $loop->have_posts() ) : ?>
		 <section id="timeline">
			<div class="row">
			   <div id="timeline" class="col-12">
				  <img class="loading" src="/wp-content/uploads/2016/12/ajax-loader.gif">
			   </div>
			</div>
		 </section>
		 <?php endif; ?>
		 <section id="related" class="row">
			<div id="parents" class="col-6 col-m-12">
		 <?php
			if ( get_queried_object()->parent != 0 ) {
				$parents = apply_filters(
					'taxonomy-images-get-terms',
					'',
					array(
						'having_images' => false,
						'taxonomy' => 'company',
						'term_args' => array(
							'include' => get_term_by( 'id', get_queried_object()->parent, 'company' )->term_id,
						),
					)
				);
			}

			if ( count( $parents ) > 0 ) :
				?>
			   <h2 class="subheading">Parent</h2>
			   <ul class="index">
				<?php
				foreach ( (array) $parents as $parent ) :
					$imgURL = wp_get_attachment_image_src( $parent->image_id )[0];
					$colour = get_term_meta( $parent->term_id, 'color', true );
					$colour = ( $colour != '' ) ? $colour : 'transparent';
					?>
				
				  <li><a href="<?php echo esc_url( get_term_link( $parent, $parent->taxonomy ) ); ?>"><?php echo get_term( $parent->term_id, 'company' )->name; ?></a></li>
				<?php endforeach; ?>
			   </ul>
			<?php endif; ?>
			</div>
		
			<div id="children" class="col-6 col-m-12">
		 <?php
			$children = apply_filters(
				'taxonomy-images-get-terms',
				'',
				array(
					'having_images' => false,
					'taxonomy' => 'company',
					'term_args' => array( 'parent' => get_queried_object()->term_id ),
				)
			);
			if ( count( $children ) > 0 ) :
				?>
			   <h2 class="subheading">Child<?php echo ( count( $children ) != 1 ) ? 'ren' : ''; ?></h2>
			   <ul class="index">
				<?php
				foreach ( (array) $children as $child ) :
					$imgURL = wp_get_attachment_image_src( $child->image_id, 'detail' )[0];
					$colour = get_term_meta( $child->term_id, 'color', true );
					$colour = ( $colour != '' ) ? $colour : 'transparent';
					?>

				  <li><a href="<?php echo esc_url( get_term_link( $child, $child->taxonomy ) ); ?>"><?php echo get_term( $child->term_id, 'company' )->name; ?></a></li>
				<?php endforeach; ?>
			   </ul>
			<?php else : ?>
			   <p>No children.</p>
			<?php endif; ?>
			</div>
		 </section>
	<?php
		$pageOrder = array( 'post', 'website', 'program', 'writing', 'video', 'other' );
	foreach ( $pageOrder as $currSec ) {
		$args['post_type'] = array( $currSec );
		$i = 0;
		$loop = new WP_Query( $args );

		if ( $loop->have_posts() ) :
			echo '<section id="' . $currSec . '" class="org-items row">';
			  echo '<h2 class="subheading">' . ucwords( $currSec ) . 's <a href="/' . ( $currSec != 'post' ? $currSec : 'blog' ) . '?company=' . get_queried_object()->slug . '">View all ' . $loop->post_count . '</a></h2>';
			  echo '<div class="index">';
			while ( ( $loop->have_posts() ) && ( $i++ < 4 ) ) :
				$loop->the_post();
				get_template_part( 'template-parts/content', get_post_format() );
			  endwhile;
			  echo '</div>';
				echo '</section>';
			endif;
	}
		echo '<section id="quals-and-awards">';
			echo '<div id="qualifications" class="org-items row">';
			$args['post_type'] = 'qualification';
			$loop = new WP_Query( $args );
			echo '<h2 class="subheading">Qualifications</h2>';
	if ( $loop->have_posts() ) :
		echo '<ul class="index">';
		while ( $loop->have_posts() ) :
			$loop->the_post();
			$url = esc_url( get_permalink() );
			echo '<li><a href="' . $url . '">' . get_the_title() . '</a></li>';
		endwhile;
		echo '</ul>';
			else :
				echo '<p>No qualifications.</p>';
			endif;
			echo '</div>';

			echo '<div id="awards" class="org-items row">';
				$args['post_type'] = 'award';
				$loop = new WP_Query( $args );
				echo '<h2 class="subheading">Awards</h2>';
			if ( $loop->have_posts() ) :
				echo '<ul class="index">';
				while ( $loop->have_posts() ) :
					$loop->the_post();
					 $url = esc_url( get_permalink() );
					 echo '<li><a href="' . $url . '">' . get_the_title() . '</a></li>';
					endwhile;
				echo '</ul>';
				else :
					echo '<p>No awards.</p>';
				endif;
				echo '</div>';
				echo '</section>';

				$args['post_type'] = 'appearance';
				$loop = new WP_Query( $args );
				if ( $loop->have_posts() ) :
					echo '<section id="appearances" class="org-items row">';
						echo '<h2 class="subheading">Appearances <a href="/appearance?company=' . get_queried_object()->slug . '">View all ' . $loop->post_count . '</a></h2>';
						echo '<div class="index">';
					while ( ( $loop->have_posts() ) ) :
						$loop->the_post();
						get_template_part( 'template-parts/content', get_post_format() );
						endwhile;
					echo '</div>';
					echo '</section>';
	endif;

				$args['post_type'] = 'correspondence';
				$loop = new WP_Query( $args );
				if ( $loop->have_posts() ) :
					echo '<section id="correspondence" class="org-items row">';
						echo '<h2 class="subheading">Correspondence <a href="/correspondence?company=' . get_queried_object()->slug . '">View all ' . $loop->post_count . '</a></h2>';
						echo '<div class="index">';
					while ( ( $loop->have_posts() ) ) :
						$loop->the_post();
						get_template_part( 'template-parts/content', get_post_format() );
						endwhile;
					echo '</div>';
					echo '</section>';
	endif;
				?>
	  </main>
   </div>
</main>

<?php get_footer(); ?>
