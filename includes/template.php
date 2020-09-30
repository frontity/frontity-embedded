<?php

/**
 * Plugin settings. Edit them to match your Frontity server configuration.
 */
$frontity_server = 'http://localhost:3000';

/**
 * Alternatively, you can use environment variables.
 */
if (getenv("FRONTITY_SERVER")) {
  $frontity_server = getenv("FRONTITY_SERVER");
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

// Add a token to the URL if the current page is a preview, but only if a user
// is logged in.
if ( is_preview() && is_user_logged_in() ) {
  // Get the entity ID.
  $id = get_the_ID();

  // Define capabilites for an specific post or page. Since WordPress 5.5.1,
  // here we need to use only `post` related capabilities for both post and page
  // types. See this commit:
  // https://github.com/WordPress/WordPress/commit/ed713194218792c9f7fda07179be44c46ced1d1d.
  // The issue solved by the commit was this one:
  // https://core.trac.wordpress.org/ticket/50128
  $capabilities = array(
    'read_post'   => $id,
    'edit_post'   => $id,
    'delete_post' => $id,
  );

  // Prior to WordPress 5.5.1, capabilities should be specified with `page` for
  // pages, so we are adding them as well to support older versions of
  // WordPress.
  if ( is_page() ) {
    $capabilities = array_merge( $capabilities, array(
      "read_page"   => $id,
      "edit_page"   => $id,
      "delete_page" => $id,
    ) );
  }

  // Generate a token that allows to only get a specific post and its revisions.
  // You also need to have permission to 'edit_post' or 'delete_post' for that.
  $token = Capability_Tokens::generate( 
    array(
      'allow_methods' => array( 'GET' ),
      'capabilities'  => $capabilities
    )
  );

  $url = $url . '&token=' . $token;
}

// Do the request to the Frontity server.
$response = wp_remote_get( $url );

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
