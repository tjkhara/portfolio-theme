<?php
  
  get_header();

  while(have_posts()) {
    the_post(); 
  pageBanner();
    ?>

<div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
    <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('project'); ?>"><i
          class="fa fa-home" aria-hidden="true"></i> Projects Home</a> <span
        class="metabox__main"><?php the_title(); ?></span></p>
  </div>

  <div class="generic-content mb-3">
    <h3>Project Description</h3>
    <?php the_content(); ?>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <div class="generic-content">
          <a href="<?php echo get_field('github_url');  ?>">Github Link</a>
        </div>
        <div class="generic-content">
          <a href="<?php echo get_field('project_url');  ?>">Live Project URL</a>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="generic-content mb-3">
          <img src="<?php echo get_field('project_image')["sizes"]["medium_large"];  ?>" alt="Project Image">
        </div>
      </div>
      <?php 
      
      $relatedPrograms = get_field('related_skills');
      
      if($relatedPrograms) {
        echo "<hr class='section-break'>";
        echo "<h2 class='headline headline--medium'>Related Skill(s):</h2>";
        echo "<ul class='link-list min-list'>";
        foreach($relatedPrograms as $program) { ?>
      <li>
        <a href="<?php echo get_the_permalink( $program ); ?>"><?php echo get_the_title($program); ?></a>
      </li>
      <?php
          
        }

        echo "</ul>";
      }

      // Client start
      // Query to see that the project of this page
      // Which client is it related to?
      // We search for clients where the project id is the id of this page
      $projectClient = new WP_Query(array(
        'posts_per_page' => 1,
        'post_type' => 'client',
        'meta_query' => array(
          // If the array of related skills contains
          // the id of the current skill
          array(
            'key' => 'past_projects',
            'compare' => 'LIKE',
            'value' => '"' . get_the_ID() . '"'
          )
        )
      ));

      if($projectClient->have_posts()) {
        // Headline
      echo "<hr class='section-break'>";
      echo "<h2 class='headline headline--medium'> Client</h2>";

      while($projectClient->have_posts()) {
        $projectClient->the_post(); 
        
        ?>
      <!-- Card start -->
      <div class="card" style="width: 18rem;">
        <img src="<?php the_post_thumbnail_url('client_card');?>" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title"><?php the_title(); ?></h5>
          <p class="card-text"><?php the_content(); ?></p>
          <a href="<?php the_permalink(); ?>" class="btn btn-primary">See Profile</a>
        </div>
      </div>
      <!-- Cart end -->
      <?php } // while end
      } // if end

      wp_reset_postdata();

      // Client end
      
      
      ?>
    </div>
  </div>









</div>



<?php }

  get_footer();

?>