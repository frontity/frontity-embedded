<?php
/**
 * Plugin Name: Theme Bridge
 * Description: Substitute your theme with the response of an external server.
 * Plugin URI: 
 * Version: 1.0.0
 * 
 * Author: Frontity
 * Author URI: https://frontity.org
 * Text Domain: frontity
 * 
 * License: GPLv3
 * Copyright: Worona Labs SL
 * 
 * @package Frontity_ThemeBridge
 */

add_filter(
  'template_include',
  function( $template ) {
    if (!isset($_GET['bypass']))
      return plugin_dir_path( __FILE__ ) . '/includes/template.php';
    return $template;
  },
  PHP_INT_MAX
);