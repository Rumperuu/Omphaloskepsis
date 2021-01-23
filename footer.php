<?php
/**
 * The template for displaying the footer
 *
 * @package Omphaloskepsis
 * @since Omphaloskepsis 1.0
 */

?>
		<footer id="site-footer" class="show">
			<p>By <a href="/">Ben</a> | <a href="https://github.com/Rumperuu/Omphaloskepsis/issues" target="_blank" rel="noopener noreferrer">Report an Issue</a> | <a href="/privacy-policy">Privacy Policy</a></p>
		</footer>

		<script type="text/javascript">
			// Displays and hides the top header bar on page scroll.
			jQuery(document).ready(function($) {
				$(window).on("scroll", function() {
					var fromTop = $(window).scrollTop();
					$('body > header').toggleClass("show", (fromTop > 200));
				});

				$('blockquote').each(function() {
					if ($(this).children('p').children().first().is('q')) {
						$(this).addClass('no-first-quote');
					}

					if ($(this).children('p').children().last().is('q')) {
						$(this).addClass('no-last-quote');
					}
				});
			});

			function toggleCommentary() {
			var linkText = ["Click here to hide all commentary and leave only reportage.", "Click here to show commentary."];
			var commentaries = document.getElementsByClassName("article__text--commentary");
			var link = document.getElementById("toggleCommentary");

			for (var i = 0; i < commentaries.length; i++) {
				commentaries[i].style.display = (commentaries[i].style.display == 'none') ? 'inline' : 'none';
			}

			link.innerHTML = (link.innerHTML == linkText[0]) ? linkText[1] : linkText[0];
			}
		</script>

		<?php wp_footer(); ?>

	</body>
</html>
