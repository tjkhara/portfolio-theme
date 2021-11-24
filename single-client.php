<?php
  
  get_header();

  while(have_posts()) {
    the_post(); 
    pageBanner();
    ?>


<div class="container container--narrow page-section">

  <div class="generic-content mb-3">
    <div class="container">
      <div class="row">
        <div class="col-sm-4">
          <?php the_post_thumbnail('client_portrait');  ?>
        </div>
        <div class="col-sm-8">
          <h4 class="mt-5">Project Details</h4>
          <p><?php the_content(); ?></p>
          <h4>Review</h4>
          <p><?php echo get_field('client_reviews') ?></p>
        </div>
      </div>
      <!-- Row end -->
    </div>
    <!-- Container end -->
  </div>
  <!-- Generic content div end -->

  <div class="container">
    <div class="row">

      <?php 
      
      // Skills start
      $relatedPrograms = get_field('related_skills');
      
      if($relatedPrograms) {
        echo "<hr class='section-break'>";
        echo "<h2 class='headline headline--medium'>Skill(s) Used:</h2>";
        echo "<ul class='link-list min-list'>";
        foreach($relatedPrograms as $program) { ?>
      <li>
        <a href="<?php echo get_the_permalink( $program ); ?>"><?php echo get_the_title($program); ?></a>
      </li>
      <?php
          
        }

        echo "</ul>";
      }
      // Skills end

      // Projects
      $pastProjects = get_field('past_projects');
      
      if($pastProjects) {
        echo "<hr class='section-break'>";
        echo "<h2 class='headline headline--medium'>Past Project(s):</h2>";
        echo "<ul class='link-list min-list'>";
        foreach($pastProjects as $project) { ?>
      <li>
        <a href="<?php echo get_the_permalink( $project ); ?>"><?php echo get_the_title($project); ?></a>
      </li>
      <?php
          
        }

        echo "</ul>";
      }
      
      ?>
    </div>
    <!-- Row End -->
  </div>
  <!-- Container End -->
  <hr class='section-break'>
  <!-- Back to archive button start -->
  <div>
    <a class="btn btn-primary" href="<?php echo get_post_type_archive_link('client'); ?>" role="button">Back to
      Clients</a>
  </div>
  <!-- Back to archive button end -->
</div>



<?php }

  get_footer();

?>