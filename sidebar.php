<?php
   /**
	* The template for the sidebar.
	*
	* @package Omphaloskepsis
	* @since Omphaloskepsis 1.0
	*/

?>

<nav class="col-2" id="sidebar">
   <ul id="sidebar-list">
	  <li <?php echo 'blog' === $wp->request ? 'class="current"' : ''; ?>>
	 <a href="/blog">Blog</a>
	 <a href="/feed"><i class="fa fa-rss"></i></a>
	  </li>
	  <li><p>~</p></li>
	  <li <?php echo 'website' === $wp->request ? 'class="current"' : ''; ?>><a href="/website">Websites</a></li>
	  <li <?php echo 'program' === $wp->request ? 'class="current"' : ''; ?>><a href="/program">Programs</a></li>
	  <li <?php echo 'writing' === $wp->request ? 'class="current"' : ''; ?>><a href="/writing">Writings</a></li>
	  <li <?php echo 'video' === $wp->request ? 'class="current"' : ''; ?>><a href="/video">Videos</a></li>
	  <li <?php echo 'other' === $wp->request ? 'class="current"' : ''; ?>><a href="/other">Other</a></li>
	  <li><p>~</p></li>
	  <li <?php echo 'experience' === $wp->request ? 'class="current"' : ''; ?>><a href="/experience">Experience (by organisation)</a></li>
   </ul>
</nav>
