<?php 

add_action( 'rest_api_init', 'universityLikeRoutes');

function universityLikeRoutes() {
  register_rest_route( 'university/v1', 'manageLike', array(
    'methods' => 'POST',
    'callback' => 'createLike'
  ) );
  register_rest_route( 'university/v1', 'manageLike', array(
    'methods' => 'DELETE',
    'callback' => 'deleteLike'
  ) );
}

function createLike($data) {

  if(is_user_logged_in(  )) {
    $post = sanitize_text_field( $data["postId"] );

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
            'value' => $post
          )
        )
      ));
    
    // Only one like allowed
    // If like does not exist
    if($existQuery->found_posts === 0 AND get_post_type( $post ) == 'post') {
      // Create the new like post
      return wp_insert_post( array(
        'post_type' => 'like',
        'post_status' => 'publish',
        'post_title' => 'Second php test',
        'meta_input' => array(
          'liked_post_id' => $post
        )
      ) );
    } else {
      // If like exists
      die("Invalid post id");
    }
  
    
  } else {
    die("Only logged in users can create a like.");
  }
  

  
}

function deleteLike() {
  return "Thanks for trying to delete a like";
}