<?php
/**
 * Plugin Name: Frontity Embedded Mode
 * Description: Replace the WordPress theme with an HTTP request to the Frontity server.
 * Plugin URI: https://github.com/frontity/frontity-embedded
 * Version: 1.5.1
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
  $jwt_files = array(
    'BeforeValidException.php',
    'ExpiredException.php',
    'JWK.php',
    'JWT.php',
    'SignatureInvalidException.php',
  );
  
  foreach ( $jwt_files as $filename ) {
    require_once plugin_dir_path( __FILE__ ) . '/includes/php-jwt/' . $filename;
  }

  // Load Frontity_Embedded_Capability_Tokens class.
  require_once plugin_dir_path( __FILE__ ) . '/includes/capability-tokens.php';

  // Load the Admin page.
  require_once plugin_dir_path( __FILE__ ) . '/includes/admin-page.php';

  // Start the Capability_Token class in each REST API request to see if it
  // contains a a token and it should be authenticated.
  add_action( 'rest_api_init', 'Frontity_Embedded_Capability_Tokens::setup' );
  
  // Add Frontity template.
  add_filter(
    'template_include',
    function( $template ) {
      if (!isset($_GET['frontity_bypass']) && !isset($_GET['elementor-preview']))
        return plugin_dir_path( __FILE__ ) . '/includes/template.php';
      return $template;
    },
    20
  );
}
add_action( 'plugins_loaded', 'frontity_embedded_loader' );

/**
 * Add default settings upon activation.
 */
function frontity_embedded_activate() {
  add_option( 'frontity_embedded_plugin_settings', array(
    'frontity_server' => ''
  ) );
}
register_activation_hook( __FILE__, 'frontity_embedded_activate' );

/**
 * Delete settings on uninstall.
 */
function frontity_embedded_uninstall() {
  delete_option( 'frontity_embedded_plugin_settings' );
}
register_uninstall_hook( __FILE__, 'frontity_embedded_uninstall' );
