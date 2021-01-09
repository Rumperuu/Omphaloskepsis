<?php
	/**
	 * The template for displaying all single posts and attachments
	 *
	 * @package WordPress
	 * @subpackage Twenty_Sixteen
	 * @since Twenty Sixteen 1.0
	 */
	get_header();
?>
<?php
function withinDates( $jSDate, $jEDate ) {
	$endYear   = date( 'Y' );
	$endDate   = $endYear . '-12-31';
	$startDate = ( $endYear - 2 ) . '-01-01';
	$jEDate    = ( ! $jEDate ) ? date( 'Y-m-d' ) : ( ( $jEDate > $endDate ) ? $endDate : $jEDate );
	return ( ( ( strtotime( $jSDate ) < strtotime( $endDate ) ) && ( strtotime( $jSDate ) > strtotime( $startDate ) ) ) && ( strtotime( $jEDate ) > strtotime( $startDate ) ) );
}
	$args = array(
		'post_type' => array(
			'job',
		),
		'posts_per_page' => -1,
	);
	$loop = new WP_Query( $args );
	?>
		   
<header class="post-header-title">
	<h1 id="page-title">Experience</h1>
	<h2 id="page-subtitle">or, a brief history of Ben</h2>
<?php
while ( have_posts() ) :
	the_post();
	?>
	<div class="entry-content tile" id="taxonomy-description">
	<?php the_content(); ?>
	</div>  
<?php endwhile; ?>
</header>  
<div id="primary" class="content-area">
	<main id="company-main" class="site-main" role="main">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		$('#timeline').height($(window).height() - $('.post-header-title').height() - 50);
		});
		
		google.charts.load('current', {'packages':['timeline']});
		google.charts.setOnLoadCallback(drawChart);
		
		function drawChart() {
		var container = document.getElementById('timeline');
		var chart = new google.visualization.Timeline(container);
		var dataTable = new google.visualization.DataTable();
		
		dataTable.addColumn({ type: 'string', id: 'Type' });
		dataTable.addColumn({ type: 'string', id: 'Role' });
		dataTable.addColumn({ type: 'string', role: 'tooltip', 'p': {'html': true} });
		dataTable.addColumn({ type: 'date', id: 'Start' });
		dataTable.addColumn({ type: 'date', id: 'End' });
		dataTable.addRows([
		<?php
		while ( $loop->have_posts() ) :
			$loop->the_post();
			?>
			<?php
			$isCurrent = ( get_post_meta( get_the_ID(), 'end-date', true ) ) ? false : true;
			$company   = wp_get_object_terms(
				get_the_ID(),
				'company',
				array(
					'fields' => 'names',
				)
			);
			$title     = html_entity_decode( get_the_title() );
			$start     = get_the_date();
			$end       = ( ! get_post_meta( get_the_ID(), 'end-date', true ) ) ? date( 'D M d Y H:i:s O' ) : get_post_meta( get_the_ID(), 'end-date', true );
			?>
			[
			'<?php echo ( $isCurrent ) ? 'Current' : 'Current'; ?>',
			'<?php echo $title . ', ' . html_entity_decode( $company[0] ); ?>',
			'<div style="padding: 20px"><h1><?php echo $title; ?></h1><h2><?php echo html_entity_decode( $company[0] ); ?></h2><ul><li><?php echo $start; ?>&mdash;<?php echo ( $isCurrent ) ? 'present' : $end; ?></li></ul></div>',
			new Date('<?php echo $start; ?>'),
			new Date('<?php echo $end; ?>')
			],
		<?php endwhile; ?>
		]);
		
		var options = {
			tooltip: {isHtml: true},
			timeline: {
			showRowLabels: true,
			},
		};
		
		chart.draw(dataTable, options);
		}         
	</script>
	
	<div id="slider-range"></div>
	<div id="timeline"></div>
	</main>
</div>
<?php // get_sidebar(); ?>
<?php get_footer(); ?>
