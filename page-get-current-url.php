<?php

// Method 1
global $wp;
echo home_url($wp->request);

echo "<hr>";

// Method 2
// global $wp;
// echo add_query_arg($wp->query_vars, home_url($wp->request));

echo "<hr>";

// Method 3
// global $wp;
// echo add_query_arg($wp->query_vars, home_url());