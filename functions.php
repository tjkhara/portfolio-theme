<?php

require get_theme_file_path( '/inc/search-route.php' );

// Customize REST API start
function university_custom_rest() {
  register_rest_field('post', 'authorName', array(
    'get_callback' => function() {
      return get_the_author();
    }
  ));
}


add_action('rest_api_init', 'university_custom_rest');
// Customize REST API end

// ***** pageBanner *****
// Taken in an option array as an argument
// This sets up sensible defaults in case no arguments are provided
// And sets up a value if no value is stored in DB (in ACF)
// When no title is provided the title of the page from db is taken
// Same with subtitle
// For image first see if argument was provided, if not check for db,
// otherwise default to the ocean image
function pageBanner($args = NULL) {
  
  if(!$args["title"]) {
    $args["title"] = get_the_title();
  }

  if(!$args["subtitle"]) {
    $args["subtitle"] = get_field("page_banner_subtitle");
  }

  // If no argument is sent, set default from db
  if(!$args["photo"]) {
    // Was image uploaded into custom field?
    if(get_field('page_banner_background_image') AND !is_archive() AND !is_home()) {
      // if yes, set that custom field value
      $args["photo"] = get_field("page_banner_background_image")["sizes"]["pageBanner"];
    }
    // No argument and no ACF photo
    else {
      // Set it to the ocean image
      $args["photo"] = get_theme_file_uri( '/images/ocean.jpg' );
    }
  }

  ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo $args["photo"]; ?>);">
  </div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title"><?php echo $args["title"] ?></h1>
    <div class="page-banner__intro">
      <p><?php echo $args["subtitle"]; ?></p>
    </div>
  </div>
</div>

<?php
} // pageBanner function end


function university_files() {
  // Bootstrap JS
  wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', array(), '5.0.2', true );
  // Bootstrap CSS
  // Javascript file from build
  wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);

  // CSS
  wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', array(), '5.0.2', 'all');
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
  wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));

  // Rest api get call
  wp_localize_script( 'main-university-js', 'universityData', array(
    'root_url' => get_site_url()
  ));
}

add_action('wp_enqueue_scripts', 'university_files');

// Set picture sizes
function university_features() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_image_size( 'client_landscape', 400, 460, true );
  add_image_size( 'client_portrait', 480, 650, true );
  add_image_size( 'client_card', 500, 460, true );
  add_image_size( 'pageBanner', 1500, 350, true );
}

add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query) {

  if(!is_admin() AND is_post_type_archive( "skill") AND is_main_query() ) {
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
  }
  
  
  if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
    $today = date('Ymd');
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', array(
              array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
              )
            ));
  }
}

add_action('pre_get_posts', 'university_adjust_queries');

// Login redirect
// Redirect subscribers directly to the home page (not to dashboard)
add_action( 'admin_init', 'redirectSubsToFrontEnd');

function redirectSubsToFrontEnd() {

  // Get info about current user
  $ourCurrentUser = wp_get_current_user(  );
  
  // If the role is subscriber
  if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
    // redirect to home page
    wp_redirect( site_url('/'));
    exit;
  }
}

// Do not show admin bar
add_action( 'wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar() {

  // Get info about current user
  $ourCurrentUser = wp_get_current_user(  );
  
  // If the role is subscriber
  if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
    // do not show admin bar
    show_admin_bar( false );
  }
}

// Customize login screen
add_filter( 'login_headerurl', 'ourHeaderUrl' );

function ourHeaderUrl() {
  return esc_url( site_url( '/' ) );
}

add_action( 'login_enqueue_scripts', 'ourLoginCSS' );

function ourLoginCSS() {
 // CSS
 wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', array(), '5.0.2', 'all');
 wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
 wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
 wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
 wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css')); 
}

// Login screen name of site
add_filter('login_headertitle', 'ourLoginTitle');

function ourLoginTitle() {
  return get_bloginfo('name');
}