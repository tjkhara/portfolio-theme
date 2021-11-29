<?php
  
  get_header();

  while(have_posts()) {
    the_post(); 
    pageBanner();
    ?>

<div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
    <p><a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>"><i class="fa fa-home"
          aria-hidden="true"></i> Blog Home</a> <span class="metabox__main">Posted by <?php the_author_posts_link(); ?>
        on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?></span></p>
  </div>

  <div class="generic-content">
    <?php 
    
    // How many likes does the page have?
    // Look for likes that have the id field equal to the id of this post
    $likeCount = new WP_Query(array(
      'post_type' => 'like',
      'meta_query' => array(
        array(
          'key' => 'liked_post_id',
          'compare' => '=',
          'value' => get_the_ID(  )
        )
      )
    ));

    $existStatus = 'no';

    if(is_user_logged_in(  )) {
      // Has the current user liked this post?
      // If the current user has already liked this post. then return results
      $existQuery = new WP_Query(array(
        'author' => get_current_user_id(  ),
        // Look in like posts
        'post_type' => 'like',
        'meta_query' => array(
          array(
            'key' => 'liked_post_id',
            'compare' => '=',
            'value' => get_the_ID(  )
          )
        )
      ));

      if($existQuery->found_posts) {
        $existStatus = "yes";
      }
    }
    
    
    
    ?>
    <span class="like-box" data-post="<?php the_ID(  ) ?>" data-exists="<?php echo $existStatus ?>">
      <i class="fa fa-heart-o" aria-hidden="true"></i>
      <i class="fa fa-heart" aria-hidden="true"></i>
      <span class="like-count"> <?php echo $likeCount->found_posts; ?> </span>
    </span>
    <?php the_content(); ?>
  </div>

</div>



<?php }

  get_footer();

?>