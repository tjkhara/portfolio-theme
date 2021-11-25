<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <header class="site-header">
    <div class="container">
      <h1 class="school-logo-text float-left"><a href="<?php echo esc_url( site_url() ) ?>"><strong>TJ</strong>
          Khara</a></h1>
      <a href="<?php esc_url( site_url( '/search' ) ) ?>" class="js-search-trigger site-header__search-trigger"><i
          class="fa fa-search" aria-hidden="true"></i></a>
      <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
      <div class="site-header__menu group">
        <nav class="main-navigation">
          <ul>
            <li <?php if (is_page('about-us') or wp_get_post_parent_id(0) == 16) echo 'class="current-menu-item"' ?>><a
                href="<?php echo esc_url( site_url('/about') ) ?>">About</a></li>
            <li <?php if (get_post_type() == 'project') echo 'class="current-menu-item"';  ?>><a
                href="<?php echo get_post_type_archive_link('project'); ?>">Projects</a></li>
            <li <?php if (get_post_type() == 'skill') echo 'class="current-menu-item"';  ?>><a
                href="<?php echo get_post_type_archive_link('skill'); ?>">Skills</a></li>
            <li <?php if (get_post_type() == 'client') echo 'class="current-menu-item"';  ?>><a
                href="<?php echo get_post_type_archive_link('client'); ?>">Clients</a></li>
            <li <?php if (get_post_type() == 'post') echo 'class="current-menu-item"' ?>><a
                href="<?php echo site_url('/blog'); ?>">Blog</a></li>
          </ul>
        </nav>
        <div class="site-header__util">
          <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a>
          <a href="#" class="btn btn--small  btn--dark-orange float-left">Sign Up</a>
          <a href="<?php echo esc_url( site_url( '/search' ) ) ?>" class="search-trigger js-search-trigger"><i
              class="fa fa-search" aria-hidden="true"></i></a>
        </div>
      </div>
    </div>
  </header>