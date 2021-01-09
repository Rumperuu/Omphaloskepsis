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
         <?php //the_date('F j\<\s\u\p\>S\<\/\s\u\p\>, 1,Y \H\.\E\.', '<h3>', '</h3>'); ?>
      </div>
   </header><!-- .entry-header -->

   <main id="post-body" class="body">
   <?php $date1 = strtotime(get_the_date('Y-m-d')); ?>
   <?php $date2 = strtotime(date('Y-m-d'));  ?>
   <?php if (has_category('series') || has_tag('ohwhatohjeez') || get_post_meta(get_the_ID(), 'Note(s)', true) || get_post_meta(get_the_ID(), 'License', true) || ($date1 < $date2 - 31557600)): ?>
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
               
               echo "<li>This <a href='/category/{$type}s'>{$type}</a> {$catag}</li>";
            }
         ?>
            
         <?php if ($date1 < $date2 - 31557600): ?>
            <li>This piece was written over a year ago. It may no longer accurately reflect my views now, or may be factually outdated.</li>
		 <?php endif; ?>
         <?php if (has_tag('ohwhatohjeez')): ?>
            <li>This piece was originally written for my old site, Oh What? Oh Jeez! As such, it may not have transferred over properly and some images and links might be broken (and, to a lesser extent, my writing from years ago is about 80% run-on sentences).</li>
         <?php endif; ?>
         <?php if ($notes = get_post_meta(get_the_ID(), 'Note(s)', true)): ?>
			<li><?php echo $notes ?></li>
         <?php endif; ?>
         <?php if ($license = get_post_meta(get_the_ID(), 'License', true)): ?>
            <li>This work is licensed under <?php echo $license ?>. <a href="/2018/03/copywrong/">Sorry about that</a>.</li>
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
   
   <footer id="post-meta">
      <h1>Post Meta</h1>
   <?php if ($content = get_post_meta(get_the_ID(), 'ToC1', true)): ?>
      <section id="post-contents">
          <h2>Contents</h2>
          <ol>
          <?php $i = 1; ?>
          <?php while($content = get_post_meta(get_the_ID(), 'ToC'.$i, true)): ?>
             <li><a href="#section-<?php echo $i++ ?>"><?php echo $content ?></a></li>
          <?php endwhile; ?>
          </ol>
      </section>
   <?php endif; ?>
   <?php if ($tags = get_the_tags(get_the_ID())): ?>
      <section id="post-tags">
          <h2>Tags</h2>
      <?php foreach ($tags as $tag): ?>
          <a href="<?php echo get_tag_link($tag->term_id) ?>" title="<?php echo $tag->name ?> Tag" class="tag-link">
             <?php echo $tag->name ?>
          </a>
      <?php endforeach; ?>
      </section>
   <?php endif; ?>
   </footer>
</article><!-- #post-## -->
