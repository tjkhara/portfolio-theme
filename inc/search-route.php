<?php

add_action( 'rest_api_init', 'univeristyRegisterSearch' );

function univeristyRegisterSearch() {
  register_rest_route( 'university/v1', 'search', array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'universitySearchResults'
  ) );
}

function universitySearchResults($data) {
  // Main query searches the title and body field for keyword
  $mainQuery = new WP_Query(array(
    'post_type' => array('post', 'page', 'project', 'client', 'skill'),
    's' =>  sanitize_text_field( $data["term"] ) 
  ));

  $results = array(
    'generalInfo' => array(),
    'projects' => array(),
    'clients' => array(),
    'skills' => array()
  );

  while($mainQuery->have_posts()) {
    $mainQuery->the_post();
    if(get_post_type(  ) == 'post' OR get_post_type(  ) == 'page') {
      array_push($results["generalInfo"], array(
        'title' => get_the_title(  ),
        'permalink' => get_the_permalink(  ),
        'postType' => get_post_type(  ),
        'authorName' => get_the_author(  )
      ));
    }

    if(get_post_type(  ) == 'project') {

      $projectDate = new DateTime(get_field('project_date'));
      
      $description = null;

      if (has_excerpt()) {
        $description = get_the_excerpt();
      } else {
        $description = wp_trim_words(get_the_content(), 18);
      }


      array_push($results["projects"], array(
        'title' => get_the_title(  ),
        'permalink' => get_the_permalink(  ),
        'month' => $projectDate->format('M'),
        'day' => $projectDate->format('d'),
        'year' => $projectDate->format('Y'),
        'description' => $description
      ));
    }

    if(get_post_type(  ) == 'client') {
      array_push($results["clients"], array(
        'title' => get_the_title(  ),
        'permalink' => get_the_permalink(  ),
        'image' => get_the_post_thumbnail_url( 0, 'client_card' )
      ));
    }

    if(get_post_type(  ) == 'skill') {
      array_push($results["skills"], array(
        'title' => get_the_title(  ),
        'permalink' => get_the_permalink(  ),
        'id' => get_the_ID(  )
      ));
    }
    
  }

  // For the related skills query below
  // Build a meta query array dynamically
  // Loop through all the found related skills
  // and add a filter for each one in the query
  $skillsMetaQuery = array('relation' => 'OR');

  forEach($results["skills"] as $item) {
    array_push($skillsMetaQuery, array(
      // name of the ACF you want to look inside
      'key' => 'related_skills',
      'compare' => 'LIKE',
      'value' => '"' . $item["id"] . '"'
    ));
  }
  
  // Query based on relationships
  // ********** What are we doing here? **********
  // Look for all the clients where the related skill is what is entered in the search term
  // You will get the id of the skill you are searching for from the data produced by first query
  // it is the first item in the skills array
  $skillRelationshipQuery = new WP_Query(array(
    // What are you looking for?
    'post_type' => 'client',
    // Search based on value of custom field
    'meta_query' => $skillsMetaQuery
  ));

  // Loop and put results in return array
  while($skillRelationshipQuery->have_posts(  )) {
    $skillRelationshipQuery->the_post();

    if(get_post_type(  ) == 'client') {
      array_push($results["clients"], array(
        'title' => get_the_title(  ),
        'permalink' => get_the_permalink(  ),
        'image' => get_the_post_thumbnail_url( 0, 'client_card' )
      ));
    }
  }

  // Remove any duplicates
  $results["clients"] = array_values(array_unique($results["clients"], SORT_REGULAR));

  return $results;
}