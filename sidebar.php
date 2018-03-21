<?php
   /**
    * The template for the sidebar.
    *
    * @package WordPress
    * @subpackage Omphaloskepsis
    * @since Omphaloskepsis 1.0
    */
?>

<nav class="col-2" id="sidebar">
   <ul id="sidebar-list">
      <li <?php echo $wp->request == 'blog' ? 'class="current"' : ''; ?>>
	 <a href="/blog">Blog</a>
	 <a href="/feed"><i class="fa fa-rss"></i></a>
      </li>
      <li><p>~</p></li>
      <li <?php echo $wp->request == 'website' ? 'class="current"' : ''; ?>><a href="/website">Websites</a></li>
      <li <?php echo $wp->request == 'program' ? 'class="current"' : ''; ?>><a href="/program">Programs</a></li>
      <li <?php echo $wp->request == 'writing' ? 'class="current"' : ''; ?>><a href="/writing">Writings</a></li>
      <li <?php echo $wp->request == 'video' ? 'class="current"' : ''; ?>><a href="/video">Videos</a></li>
      <li <?php echo $wp->request == 'other' ? 'class="current"' : ''; ?>><a href="/other">Other</a></li>
      <li><p>~</p></li>
      <li <?php echo $wp->request == 'experience' ? 'class="current"' : ''; ?>><a href="/experience">Experience (by organisation)</a></li>
   </ul>
</nav>
