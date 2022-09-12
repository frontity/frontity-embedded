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
$url = untrailingslashit( $frontity_server ) . $_SERVER['REQUEST_URI'];
// Add the `frontity_embedded` query.
$url .= ( wp_parse_url( $url, PHP_URL_QUERY ) ? '&' : '?' ) . 'frontity_embedded=true';

// Get the entity ID.
$id = get_the_ID();

// Add a token to the URL if the current page is a preview, but only if a user
// is logged in and can edit the post.
if ( $id && is_preview() && is_user_logged_in() && current_user_can( 'edit_post', $id ) ) {

  // Generate a token that allows only to preview a specific post or page.
  $type = get_post_type();
  $token = Frontity_Embedded_Capability_Tokens::generate( 
    array(
      'type'      => 'preview',
      'post_type' => $type,
      'post_id'   => $id,
    )
  );

  $url = $url . '&frontity_source_auth=Bearer ' . $token;
}

/**
 * Filters the URL before doing the request. This allows external code to alter
 * the URL before the request is made.
 *
 * @hook frontity_embedded_request_url
 * @param string $url The frontity request url
 * @return string
 */
$url = apply_filters( 'frontity_embedded_request_url', $url );

/**
 * Filters the arguments before doing the request. This allows external code to
 * alter the `wp_remote_get` parameters before the request is made.
 *
 * @hook frontity_embedded_request_args
 * @param array $args The `wp_remote_get` args
 * @return array
 */
$args = apply_filters( 'frontity_embedded_request_args', array( 'timeout' => 30 ) );

// Do the request to the Frontity server.
$response = wp_remote_get( $url, $args );

if ( is_wp_error( $response ) ) {
  // If the request fails, set the status to 500.
  status_header( 500 );
  if ( WP_DEBUG === true ) {
    // If the WordPress is in debug mode, throw an error.
    throw new Exception( $response->get_error_message() );
  } else {
    // If not, send the error page.
    require_once plugin_dir_path( __FILE__ ) . 'error.php';
  }
} else if ( substr( (string) $response[ "response" ][ "code" ], 0, 1 ) === "5" ) {
  // If the request didn't fail, but Frontity returned an error, set the status
  // to 500.
  status_header( 500 );
  if ( isset( $response[ "headers" ][ "x-frontity-dev" ] ) ) {
    // If Frontity is in development mode, show the error.
    echo $response[ "body" ];
  } else {
    // If not, send the error page.
    require_once plugin_dir_path( __FILE__ ) . 'error.php';
  }
} else {
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
  
  // Add the Admin Bar.
  if ( !$isStatic) {
    // Divide the HTML to be able to insert things in the <head> and <body>.
    list($head, $rest) = preg_split('/(?=<\/head>)/', wp_remote_retrieve_body( $response ) );
    list($body, $end) = preg_split('/(?=<\/body>)/', $rest);

    // Echo the <head>, but don't echo </head> tag yet. 
    echo $head;
  
    /**
    * Fires a do_action hook similar to wp_head.
    * https://developer.wordpress.org/reference/functions/wp_head/
    */
    do_action('frontity_embedded_wp_head');

    if (is_admin_bar_showing()) {
        add_action( 'admin_print_styles', 'print_emoji_styles' );
        add_action( 'admin_print_styles', 'print_admin_styles', 20 );
        do_action( 'admin_print_styles' );
    }
    // Echo the <body>, but don't echo the </body> tag yet.
    echo $body;

    /**
    * Fires a do_action hook similar to wp_footer.
    * https://developer.wordpress.org/reference/functions/wp_footer/
    */
    do_action('frontity_embedded_wp_footer');
    
    // Echo the admin bar HTML.
    if (is_admin_bar_showing()) {
        // Get the scripts and styles of the Admin Bar and echo them.
        add_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        add_action( 'admin_print_scripts', 'print_head_scripts', 20 );
        do_action( 'admin_print_scripts' );
        _admin_bar_bump_cb();
        wp_admin_bar_header();
        wp_admin_bar_render();
    }
    
    // Echo the final </body> and </html> tags.
    echo $end;
  } else {
    echo wp_remote_retrieve_body( $response );
  }
} 
