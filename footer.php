<?php
   /**
    * The template for displaying the footer
    *
    * @package WordPress
    * @subpackage Omphaloskepsis
    * @since Omphaloskepsis 1.0
    */
?>
      
      <script type="text/javascript">
	 // Displays and hides the top header bar on page scroll.
	 jQuery(document).ready(function($) {
	    $(window).on("scroll", function() {
	       var fromTop = $(window).scrollTop();
	       $('body > header').toggleClass("show", (fromTop > 200));
	    });
	 });
      </script>

      <?php wp_footer(); ?>
   
   </body>
</html>
