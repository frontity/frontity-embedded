<?php

/**
 * Plugin settings. Edit them to match your Frontity server configuration.
 */
$frontity_server = 'http://localhost:3000';
$frontity_static_folder = '/static/';

/***********************************************************************/

// Redirect Webpack HMR to the Frontity server.
if ( $_SERVER['REQUEST_URI'] === '/__webpack_hmr' ) {
  header( 'Location: http://localhost:3000/__webpack_hmr' );
  status_header( 301 );
  exit();
} 

// Build the URL to do the request to the Frontity server.
$url = $frontity_server . $_SERVER['REQUEST_URI'];

// Do the request to the Frontity server.
$response = wp_remote_get( $url );

if ( !is_wp_error( $response ) ) {
  global $wp_query;
  $isStatic = strpos( $_SERVER['REQUEST_URI'], $frontity_static_folder ) === 0;
  
  // Pass through the Content-Type header.
  header( 'content-type: ' . $response['headers']['content-type'] );

  // Pass through the status of the response.
  status_header( $response['response']['code'] );

  // Override is_404 of static assets.
  if ( $isStatic && $response['response']['code'] === 200 )
    $wp_query->is_404 = false;
  
  // Add the admin bar.
  if ( !$isStatic && is_admin_bar_showing() ) {
    // Divide the HTML to be able to insert things in the <head> and <body>.
    list($head, $rest) = preg_split('/(?=<\/head>)/', wp_remote_retrieve_body( $response ) );
    list($body, $end) = preg_split('/(?=<\/body>)/', $rest);

    // Echo the <head>, but don't echo </head> tag yet. 
    echo $head;
  
    // TODO: Don't hardcode the dependencies, get them from $wp_scripts->registered['admin-bar']->deps.
    $scripts = [
      $wp_scripts->registered['admin-bar']->src,
      $wp_scripts->registered['hoverintent-js']->src
    ];
    $styles = [
      $wp_styles->registered['admin-bar']->src,
      $wp_styles->registered['dashicons']->src
    ];

    foreach ( $scripts as $script ) {
      echo "<script src='" . site_url() . $script . "?ver=" . $wp_version . "'></script>";
    }
    foreach ( $styles as $style ) {
      echo "<link rel='stylesheet' href='" . site_url() . $style . "?ver=" . $wp_version . "' />";
    }

    // Echo the <body>, but don't echo the </body> tag yet.
    echo $body;
    
    // Echo the admin bar HTML.
    _admin_bar_bump_cb();
    wp_admin_bar_header();
    wp_admin_bar_render();
    
    // Echo the final </body> and </html> tags.
    echo $end;
  } else {
    echo wp_remote_retrieve_body( $response );
  }


} else {
  // TODO: Proper handling of errors.
  status_header( 500 );
  var_dump( $response );
}
