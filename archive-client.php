<?php

get_header(); 

pageBanner(array(
  'title' => 'All Clients',
  'subtitle' => 'Here are some of the clients I\'ve worked with.'
))
?>

<div class="container container--narrow page-section">
  <ul class="link-list min-list">
    <?php
  while(have_posts()) {
    the_post(); ?>
    <li>
      <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
      <p><?php echo get_field('client_reviews'); ?></p>
    </li>
    <?php }
  echo paginate_links();
  ?>
  </ul>


</div>

<?php get_footer();

?>