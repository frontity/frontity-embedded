<?php
/**
 * Plugin Name: Frontity Embedded Mode - [Proof of Concept]
 * Description: Replace the WordPress theme with an HTTP request to the Frontity server.
 * Plugin URI: https://github.com/frontity/frontity-embedded-proof-of-concept
 * Version: 1.0.0
 * 
 * Author: Frontity
 * Author URI: https://frontity.org
 * Text Domain: frontity
 * 
 * License: GPLv3
 * Copyright: Worona Labs SL
 */

add_filter(
  'template_include',
  function( $template ) {
    if (!isset($_GET['frontity_bypass']))
      return plugin_dir_path( __FILE__ ) . '/includes/template.php';
    return $template;
  },
  PHP_INT_MAX
);