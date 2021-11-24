<?php
  
  get_header();

  while(have_posts()) {
    the_post(); 
    pageBanner();
    ?>

<div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
    <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('skill'); ?>"><i
          class="fa fa-home" aria-hidden="true"></i> Skills Home</a> <span
        class="metabox__main"><?php the_title(); ?></span></p>
  </div>

  <div class="generic-content mb-3">
    <?php the_field("main_body_content"); ?>
  </div>

  <?php 
  // We are trying to pull in projects that have this skill
          $today = date('Ymd');

          // Find projects and filter for the current skill
          // Skill on this page
          $homepageProjects = new WP_Query(array(
            'posts_per_page' => 10,
            'post_type' => 'project',
            'order' => 'ASC',
            'meta_query' => array(
              // If the array of related skills contains
              // the id of the current skill
              array(
                'key' => 'related_skills',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"'
              )
            )
          ));

          if($homepageProjects->have_posts()) {
            // Headline
          echo "<hr class='section-break'>";
          echo "<h2 class='headline headline--medium'>Recent " . get_the_title() . " Projects</h2>";

          while($homepageProjects->have_posts()) {
            $homepageProjects->the_post(); 
            get_template_part( 'template-parts/content-project');
          }
          }
        ?>

</div>

</div>



<?php }

  get_footer();

?>