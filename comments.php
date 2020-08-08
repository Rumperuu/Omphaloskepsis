<?php
   /**
    * The template for displaying comments.
    *
    * @package WordPress
    * @subpackage Omphaloskepsis
    * @since Omphaloskepsis 1.0
    */

   /*
    * If the current post is protected by a password and
    * the visitor has not yet entered the password we will
    * return early without loading the comments.
    */
   if (post_password_required()) return;
?>

<div id="comments" class="comments-area">
   <div class="row">
      <div class="col-7" id="comments-list">
	 <h3 id="comments-list-title">Replies</h3>
	 <?php if ( have_comments() ) : ?>
	    <?php the_comments_navigation(); ?>

	    <ol class="comment-list">
	    <?php
	       wp_list_comments( array(
		  'style'       => 'ol',
		  'short_ping'  => true,
		  'avatar_size' => 42,
	       ));
	    ?>
	    </ol><!-- .comment-list -->

	    <?php the_comments_navigation(); ?>
	 <?php else: ?>
	    <p id="no-comments">No comments yet.</p>
	 <?php endif; ?>
	 <?php	if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')): ?>
	    <p class="no-comments"><?php _e( 'Comments are closed.', 'twentysixteen' ); ?></p>
	 <?php endif; ?>
      </div>
      
      <div class="col-5" id="comments-reply">
      <?php
	 comment_form( array(
	    'title_reply_before' => '<h3 id="comments-reply-title">',
	    'title_reply_after'  => '</h3>',
	 ));
      ?>
      </div>
   </div>
</div><!-- .comments-area -->
