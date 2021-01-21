<?php
/*
 * Template Name: Experience by Companies
 * /
 
/**
 * The template for displaying all items, indexed by organisation.
 *
 * @package Omphaloskepsis
 * @since Omphaloskepsis 1.0
 */
get_header(); ?>

<main id="experience-wrapper" class="content-area col-10 col-m-12">
   <!--Page Title & Details-->
   <header class="post-header-title">
	  <h1 style="margin-bottom: 20px;" id="page-title">Experience.</h1>
   <?php
	while ( have_posts() ) :
		the_post();
		?>
	  <div class="entry-content tile" id="taxonomy-description">
		<?php the_content(); ?>
	  </div>
	
	  <div class="entry-content tile" id="settings">
		 <h3 style="margin-bottom: 14px;" class="subheading">Settings</h3>
		 <form action="/experience-by-companies" id="settings" method="GET">
			<input class="checkbox" type="checkbox" id="toplevel" value="toplevel" checked="checked">
			<label for="toplevel">Display only top-level organisations</label>
			<br>
			<fieldset>
			   <legend><p style="margin-top: 14px; margin-bottom: 14px;">Display only organisations with associated:</p></legend>
			   <div class="controlgroup" id="typestodisplay">
				  <label for="jobs">Roles <span class="dashicons dashicons-hammer"></span></label>
				  <input type="checkbox" name="jobs" id="jobs" checked="checked">
				  <label class="currentjobs" for="currentjobs">Display only current roles</label>
				  <input class="currentjobs" type="checkbox" name="currentjobs" id="currentjobs" checked="checked">
				  <label for="posts">Blog Posts <span class="dashicons dashicons-admin-post"></span></label>
				  <input type="checkbox" name="posts" id="posts">
				  <label for="websites">Websites <span class="dashicons dashicons-schedule"></span></label>
				  <input type="checkbox" name="websites" id="websites">
				  <label for="programs">Programs <span class="dashicons dashicons-desktop"></span></label>
				  <input type="checkbox" name="programs" id="programs">
				  <label for="writings">Writings <span class="dashicons dashicons-format-aside"></span></label>
				  <input type="checkbox" name="writings" id="writings">
				  <label for="videos">Videos <span class="dashicons dashicons-video-alt"></span></label>
				  <input type="checkbox" name="videos" id="videos">
				  <label for="other">Other <span class="dashicons dashicons-archive"></span></label>
				  <input type="checkbox" name="other" id="other">
				  <label for="qualifications">Qualifications <span class="dashicons dashicons-id"></span></label>
				  <input type="checkbox" name="qualifications" id="qualifications">
				  <label class="expired" for="expired">Show expired qualifications</label>
				  <input class="expired" type="checkbox" name="expired" id="expired">
				  <label for="awards">Awards <span class="dashicons dashicons-awards"></span></label>
				  <input type="checkbox" name="awards" id="awards">
			   </div>
			</fieldset>
			<br>
			<input class="ui-button ui-widget ui-corner-all" id="refresh" type="submit" value="Refresh">
		 </form>
	 </div>
   <?php endwhile; ?>
   </header>

   <!--Company Grid-->
   <table class="row" id="organisations-grid">
   </table>

   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script type="text/javascript">
	  // Populates the organisations grid.
	  jQuery(document).ready(function($) {
		 // Sets up jQueryUI elements.
		 $('input:checkbox').checkboxradio();
		 $('.controlgroup').controlgroup();
		 $('.refresh').button();

		 // Displays the initial organisations grid.
		 displayCompanies();

		 $('.expired').hide();

		 $('input[type="checkbox"]').change(function() {
			$('#refresh').css('border-width', '5px');
		 });
		 
		 $('#jobs').change(function() {
			if($(this).is(":checked")) {
			   $('.currentjobs').fadeIn(100);
			} else {
			   $('.currentjobs').fadeOut(100);
			}
		 });

		 $('#qualifications').change(function() {
			if($(this).is(":checked")) {
			   $('.expired').fadeIn(100);
			} else {
			   $('.expired').fadeOut(100);
			}
		 });

		 $('#refresh').click(function(event) {
			$(this).css('border-width', '1px');
			event.preventDefault();
			displayCompanies();
		 });

		 function displayCompanies() {
			$('#organisations-grid').html('<img class="loading" src="/wp-content/uploads/2016/12/ajax-loader.gif">');

			var settings = {
			   'action': 'display_companies',
			   'toplevel': $('#toplevel').is(':checked'),
			   'job': $('#jobs').is(':checked'),
			   'currentjobs': $('#currentjobs').is(':checked'),
			   'post': $('#posts').is(':checked'),
			   'website': $('#websites').is(':checked'),
			   'program': $('#programs').is(':checked'),
			   'writing': $('#writings').is(':checked'),
			   'video': $('#videos').is(':checked'),
			   'other': $('#other').is(':checked'),
			   'qualification': $('#qualifications').is(':checked'),
			   'showexpired': $('#expired').is(':checked'),
			   'award': $('#awards').is(':checked'),
			};

			$.post("/wp-admin/admin-ajax.php", settings, function(response) {
			   $('#organisations-grid').html(response);
			}); 
		 }
	  });
   </script>
</main>

<?php get_footer(); ?>
