<div class="event-summary">
  <a class="event-summary__date t-center" href="#">
    <span class="event-summary__month"><?php
                  $projectDate = new DateTime(get_field('project_date'));
                  echo $projectDate->format('M')
                ?></span>
    <span class="event-summary__day"><?php echo $projectDate->format('d') ?></span>
    <span class="event-summary__year"><?php echo $projectDate->format('Y') ?></span>
  </a>
  <div class="event-summary__content">
    <h5 class="event-summary__title headline headline--tiny"><a
        href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
    <p><?php if (has_excerpt()) {
                    echo get_the_excerpt();
                  } else {
                    echo wp_trim_words(get_the_content(), 18);
                    } ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
  </div>
</div>