<?php
   /**
    * The template part for displaying single Posts.
    *
    * @package WordPress
    * @subpackage Omphaloskepsis
    * @since Omphaloskepsis 1.0
    */
?>

<article id="wrapper" <?php post_class(); ?>>
   <header style="background-image: url('<?php the_post_thumbnail_url(); ?>');">
      <div>
	 <h1 id="post-title"><?php echo get_the_title(); ?></h1>
      <?php if ($subtitle = get_post_meta(get_the_ID(), 'Subtitle', true)): ?>
	 <h2 id="post-subtitle"><?php echo $subtitle ?></h2>
      <?php endif; ?>
      <?php the_date('F j\<\s\u\p\>S\<\/\s\u\p\>, 1,Y \H\.\E\.', '<h3>', '</h3>'); ?>
      </div>
   </header><!-- .entry-header -->

   <main id="post-body" class="body">
   <?php if (has_category()): ?>
      <div id="details">
         <ul>
         <?php 
            if (has_category('thoughts')) $type = "thought";
            else if (has_category('reports')) $type = "report";
            else if (has_category('review')) $type = "review";
             
            if (has_category('series')) {
               $catag = "is a part of the following series";
               $series = [];
               $s = get_category_by_slug('series');
               $seriesIDs = get_term_children($s->term_id, 'category');
             
               foreach ($seriesIDs as $thisSeriesID) {
                  if (has_category($thisSeriesID)) {
                     array_push($series, get_category($thisSeriesID));
                  }
               }
               if (count($series) > 1) $catag .= "&rsquo;";
               $punct = ":";
               foreach ($series as $thisSeries) {
                  $catag .= $punct.' ';
                  if ($punct == ":") $punct = ";";
                  $catag .= '<a href="/category/series/'.$thisSeries->slug.'">'.$thisSeries->name.'</a>';
               }
               $catag .= '.';
            } else {
               $catag = "is not a part of any series.";
            }
         ?>
            <li>This <?php echo '<a href="/category/'.$type.'s">'.$type.'</a> '.$catag.'</li>'; ?>
         <?php if (has_tag('ohwhatohjeez')): ?>
            <li>This piece was originally written for my old site, Oh What? Oh Jeez! As such, it may not have transferred over properly and some images and links might be broken (and, to a lesser extent, my writing from years ago is about 80% run-on sentences).</li>
         <?php endif; ?>
         <?php if ($notes = get_post_meta(get_the_ID(), 'Note(s)', true)): ?>
            <li><?php echo $notes ?></li>
         <?php endif; ?>
         </ul>
      </div>
   <?php endif; ?>
   
   <?php
      if (get_the_content()):
         the_content();
      else: 
         echo get_the_excerpt();
      endif;
   ?>
   </main><!-- .entry-content -->
</article><!-- #post-## -->
