<?php

/**
 * Plugin settings. Edit them to match your Frontity server configuration.
 */
$frontity_settings = get_option( 'frontity_embedded_plugin_settings' );
$frontity_server = $frontity_settings['frontity_server'];

/**
 * Alternatively, you can use PHP constants or environment variables.
 * 
 * Note that, if the PHP constant exists, it would take precedence over
 * the corresponding environment variable.
 */
if ( defined( "FRONTITY_SERVER" ) ) {
  $frontity_server = FRONTITY_SERVER;
} else if ( getenv( "FRONTITY_SERVER" ) ) {
  $frontity_server = getenv( "FRONTITY_SERVER" );
}

/***********************************************************************/

// Redirect Webpack HMR to the Frontity server. Only for development.
if ( $_SERVER['REQUEST_URI'] === '/__webpack_hmr' ) {
  header( 'Location: ' . $frontity_server . '/__webpack_hmr' );
  status_header( 301 );
  exit();
} 

// Build the URL to do the request to the Frontity server.
$url = $frontity_server . $_SERVER['REQUEST_URI'];
// Add the `frontity_embedded` query.
$url .= ( wp_parse_url( $url, PHP_URL_QUERY ) ? '&' : '?' ) . 'frontity_embedded=true';

// Get the entity ID.
$id = get_the_ID();

// Add a token to the URL if the current page is a preview, but only if a user
// is logged in and can edit the post.
if ( $id && is_preview() && is_user_logged_in() && current_user_can( 'edit_post', $id ) ) {

  // Generate a token that allows only to preview a specific post or page.
  $type = get_post_type();
  $token = Capability_Tokens::generate( 
    array(
      'type'      => 'preview',
      'post_type' => $type,
      'post_id'   => $id,
    )
  );

  $url = $url . '&frontity_source_auth=Bearer ' . $token;
}

// Do the request to the Frontity server.
$args = array( 'timeout' => 30 );
$response = wp_remote_get( $url, $args );

if ( !is_wp_error( $response ) ) {
  global $wp_query;

  // Consider static all kind of files Webpack returns as static.
  $isStatic = preg_match(
    '/\.(js|png|jpe?g|gif|svg|woff(2)?|ttf|eot)(\?v=\d+\.\d+\.\d+)?$/i',
    $_SERVER['REQUEST_URI']
  );
  
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
  // TODO: Return pretty HTML instead of PHP exception.
  status_header( 500 );
  throw new Exception( $response->get_error_message() );
}
