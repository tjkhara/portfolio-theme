<?php

get_header(); 

pageBanner(array(
  'title' => 'All Projects',
  'subtitle' => 'See some recent projects I\'ve worked on.'
));
?>

<div class="container container--narrow page-section">
  <?php
  
  while(have_posts()) {
    the_post(); 
    get_template_part( 'template-parts/content-project');
  }
  echo paginate_links();
?>


</div>

<?php get_footer();

?>