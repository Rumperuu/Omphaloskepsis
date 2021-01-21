<?php
/*
 * Template Name: Experience Timeline
 * /
 
/**
 * The template for displaying all roles in a timeline.
 *
 * @package Omphaloskepsis
 * @since Omphaloskepsis 1.0
 */
get_header(); ?>

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
		   
<main id="experience-wrapper" class="content-area col-10 col-m-12">
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
    
    <div class="entry-content tile" id="settings">
        <h3 style="margin-bottom: 14px;" class="subheading">Settings</h3>
        <form action="/experience-timeline" id="settings" method="GET">
            <input class="checkbox" type="checkbox" id="separate" value="separate" checked="checked">
            <label for="separate">Separate past and current roles</label>
            <input class="ui-button ui-widget ui-corner-all" id="refresh" type="submit" value="Refresh">
        </form>
	 </div>
  <?php endwhile; ?>
  </header>  
  
  <div id="primary" class="content-area">
    <main id="company-main" class="site-main" role="main">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">   
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
        jQuery(document).ready(function($) {
          $('input:checkbox').checkboxradio();
          $('.refresh').button();
          
          google.charts.load('current', {'packages':['timeline']});
          google.charts.setOnLoadCallback(drawChart);
          
          $('input[type="checkbox"]').change(function() {
            alert("Feature in progress");
	        $('#refresh').css('border-width', '5px');
          });
        
          $('#refresh').click(function(event) {
		    $(this).css('border-width', '1px');
		    event.preventDefault();
		    drawChart();
		  });
		});
        
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
            $end       = ( ! get_post_meta( get_the_ID(), 'end-date', true ) ) ? date( 'c' ) : get_post_meta( get_the_ID(), 'end-date', true );
          ?>
            [
              '<?php echo ( $isCurrent ) ? 'Current' : 'Past'; ?>',
              '<?php echo $title . ', ' . html_entity_decode( $company[0] ); ?>',
              '<div style="padding: 20px"><h1 class="timeline-entry-title"><?php echo $title; ?></h1><h2><?php echo html_entity_decode( $company[0] ); ?></h2><ul><li><?php echo $start; ?>&mdash;<?php echo ( $isCurrent ) ? 'present' : $end; ?></li></ul></div>',
              new Date('<?php echo $start; ?>'),
              new Date('<?php echo $end; ?>')
            ],
          <?php endwhile; ?>
          ]);
          
          var rowHeight = 15;
          var chartHeight = dataTable.getNumberOfRows() * rowHeight + 50;
          var options = {
            tooltip: {isHtml: true},
            timeline: {
              showRowLabels: true,
            },
            height: chartHeight,
            width: window.innerWidth - 200,
          };
          
          chart.draw(dataTable, options);
        }         
      </script>
      
      <div id="slider-range"></div>
      <section id="timeline">
        <div class="row">
          <div id="timeline" class="col-12">
            <img class="loading" src="/wp-content/uploads/2016/12/ajax-loader.gif">
          </div>
        </div>
      </section>
    </main>
  </div>
</main>
<?php // get_sidebar(); ?>
<?php get_footer(); ?>
