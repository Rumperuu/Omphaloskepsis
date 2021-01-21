<?php
   /**
	* The template for displaying archive pages.
	*
	* @subpackage Omphaloskepsis
	* @since Omphaloskepsis 1.0
	*/
?>

<?php get_header(); ?>

<?php	$loop = new WP_Query( $args ); ?>    
<header class="entry-content tile location-block">
   <div class="post-header-title">
	  <h1 id="page-title">Experience</h1>
	  <h2 id="page-subtitle">by location</h2>
	  <?php
		while ( have_posts() ) :
			the_post();
			?>
	 <div class="entry-content" id="taxonomy-description">
			<?php the_content(); ?>
		<div>
		   <a class="hyperlink-button" href="?view=countries">Countries</a>
		   <!--<a class="hyperlink-button" href="?view=regions">Regions</a>-->
		   <a class="hyperlink-button" href="?view=locations">Locations</a>
		</div>
	 </div>
	  <?php endwhile; ?>
   </div>
</header>

<?php
   $locations = get_terms( 'location', array( 'hide_empty' => 0 ) );
   // Gets all of the top-level location terms.
$terms = get_terms(
	array(
		'taxonomy' => 'location',
		'term_args' => array( 'parent' => 0 ),
	)
);
?>

<div id="primary" class="content-area">
   <main id="company-main" class="site-main" role="main">
	  <div class="row">
	 <div id="map" style="height:100vh; width:100%;"></div>
	  </div>
	  <?php if ( ! empty( $locations ) ) : ?> 
			<?php if ( $_GET['view'] == 'countries' ) : ?>
				<?php
				$locationsSubset = array_filter(
					$locations,
					function ( $t ) {
						return $t->parent != 0 && get_term( $t->parent, 'location' )->parent == 0;
					}
				);
				?>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
		   google.charts.load('current', {'packages':['geochart']});
		   google.charts.setOnLoadCallback(drawMap);
		   
		   function drawMap() {
		  var data = google.visualization.arrayToDataTable([
			 ['Country'],
				<?php foreach ( (array) $locationsSubset as $term ) : ?>
			 ['<?php echo $term->description; ?>'],
		  <?php endforeach; ?>
		  ]);
		  var options = {};
		  var chart = new google.visualization.GeoChart(document.getElementById('map'));
		  
		  chart.draw(data, options);
		   }
		</script>
	 <?php elseif ( $_GET['view'] == 'locations' ) : ?>
		 <?php
			$locationsSubset = array_filter(
				$locations,
				function ( $t ) {
					return $t->parent != 0 && get_term( $t->parent, 'location' )->parent != 0 && get_term( get_term( $t->parent, 'location' )->parent, 'location' )->parent != 0 && get_term( get_term( get_term( $t->parent, 'location' )->parent, 'location' )->parent, 'location' )->parent == 0;
				}
			);
			?>
		<script type="text/javascript">
		   var locations = [
		   <?php foreach ( (array) $locationsSubset as $term ) : ?>
		  {<?php echo $term->description; ?>},
		   <?php endforeach; ?>
		   ]
		   
		   function initMap() {
		  var map = new google.maps.Map(document.getElementById('map'), {
			 zoom: 3,
			 center: {lat: 51.483462, lng: 0.0586198}
		  });
		  
		  // Create an array of alphabetical characters used to label the markers.
		  var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		  
		  // Add some markers to the map.
		  // Note: The code uses the JavaScript Array.prototype.map() method to
		  // create an array of markers based on a given "locations" array.
		  // The map() method here has nothing to do with the Google Maps API.
		  var markers = locations.map(function(location, i) {
			 return new google.maps.Marker({
			position: location,
			label: labels[i % labels.length]
			 });
		  });
		  
		  // Add a marker clusterer to manage the markers.
		  var markerCluster = new MarkerClusterer(map, markers, {
			 imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
		  });
		   }
		</script>
		<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBsMPnuCM59sC_n11CGxbpbqNY7FRUXnD0&callback=initMap"></script>
	 <?php endif; ?>
	  <?php endif; ?>
   </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
