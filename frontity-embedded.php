<?php
/**
 * Plugin Name: Frontity Embedded Mode
 * Description: Replace the WordPress theme with an HTTP request to the Frontity server.
 * Plugin URI: https://github.com/frontity/frontity-embedded
 * Version: 1.1.0
 * 
 * Author: Frontity
 * Author URI: https://frontity.org
 * Text Domain: frontity
 * 
 * License: GPLv3
 * Copyright: Worona Labs SL
 */


/**
 * Load the Frontity Embedded plugin.
 */
function frontity_embedded_loader() {

	// Load php-jwt classes.
	foreach ( glob( plugin_dir_path( __FILE__ ) . '/includes/php-jwt/*.php' ) as $filename ) {
		require_once $filename;
  }

  // Load Capability_Tokens class.
  require_once plugin_dir_path( __FILE__ ) . '/includes/capability-tokens.php';

  // Start the Capability_Token class in each REST API request to see if it
  // contains a a token and it should be authenticated.
  add_action( 'rest_api_init', 'Capability_Tokens::setup' );
  
  // Add Frontity template.
  add_filter(
    'template_include',
    function( $template ) {
      if (!isset($_GET['frontity_bypass']))
        return plugin_dir_path( __FILE__ ) . '/includes/template.php';
      return $template;
    },
    20
  );
}

add_action( 'plugins_loaded', 'frontity_embedded_loader' );
