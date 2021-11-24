<?php get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image"
    style="background-image: url(<?php echo get_theme_file_uri('/images/website-hero.jpg') ?>);"></div>
  <div class="page-banner__content container t-center c-white">
    <h1 class="headline headline--large">Welcome!</h1>
    <h2 class="headline headline--medium">Need a hand with your next web dev project?</h2>
    <h3 class="headline headline--small">Check out some of the recent projects I've worked on...
    </h3>
    <a href="<?php echo get_post_type_archive_link('project') ?>" class="btn btn--large btn--blue">Recent Projects</a>
  </div>
</div>

<div class="full-width-split group">
  <div class="full-width-split__one">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">Latest Projects</h2>

      <?php 
          $today = date('Ymd');
          $homepageProjects = new WP_Query(array(
            'posts_per_page' => 2,
            'post_type' => 'project',
            'order' => 'ASC',
          ));

          while($homepageProjects->have_posts()) {
            $homepageProjects->the_post(); 
            
            get_template_part( 'template-parts/content', 'project');     
            
          }
        ?>

      <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('project') ?>"
          class="btn btn--blue">View All Projects</a></p>

    </div>
  </div>
  <div class="full-width-split__two">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">Latest Blog Posts</h2>
      <?php
          $homepagePosts = new WP_Query(array(
            'posts_per_page' => 2
          ));

          while ($homepagePosts->have_posts()) {
            $homepagePosts->the_post(); ?>
      <div class="event-summary">
        <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
          <span class="event-summary__month"><?php the_time('M'); ?></span>
          <span class="event-summary__day"><?php the_time('d'); ?></span>
        </a>
        <div class="event-summary__content">
          <h5 class="event-summary__title headline headline--tiny"><a
              href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
          <p><?php if (has_excerpt()) {
                    echo get_the_excerpt();
                  } else {
                    echo wp_trim_words(get_the_content(), 18);
                    } ?> <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
        </div>
      </div>
      <?php } wp_reset_postdata();
        ?>




      <p class="t-center no-margin"><a href="<?php echo site_url('/blog'); ?>" class="btn btn--yellow">View All Blog
          Posts</a></p>
    </div>
  </div>
</div>

<div class="hero-slider">
  <div data-glide-el="track" class="glide__track">
    <div class="glide__slides">
      <div class="hero-slider__slide"
        style="background-image: url(<?php echo get_theme_file_uri('/images/js-image.jpg'); ?>);">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">Custom Javascript Development</h2>
            <p class="t-center">Get custom functionality on your website.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="hero-slider__slide"
        style="background-image: url(<?php echo get_theme_file_uri('/images/react-image.jpg'); ?>);">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">A Blazing Fast Front End With React</h2>
            <p class="t-center">Leverage the power of React on your next app...</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="hero-slider__slide"
        style="background-image: url(<?php echo get_theme_file_uri('/images/wordpress-image-computer.jpg'); ?>); background-position: center center; min-height: 100%;">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">WordPress</h2>
            <p class="t-center">Have me build a custom backend for your business with WordPress.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]">
    </div>
  </div>
</div>

<?php get_footer();

?>