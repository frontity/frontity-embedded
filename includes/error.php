<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo get_bloginfo( 'name' ); ?> - Server Error</title>
    <?php
      $site_icon = get_site_icon_url();
      if ( "" !== $site_icon ) {
        echo "<link rel='icon' type='image/png' href='{$site_icon}' sizes='32x32' />";
      }
    ?>
    <style>
      html,
      body,
      .container {
        height: 100%;
      }

      body {
        font-family: "Roboto", "Helvetica", "Segoe UI", Tahoma, Geneva, Verdana,
          sans-serif;
        margin: 0;
      }

      .container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        max-width: 600px;
        padding: 24px;
        margin: auto;
        box-sizing: border-box;
      }

      .custom-logo {
        margin-bottom: 8px;
      }

      h1 {
        margin-bottom: 4px;
      }

      h2 {
        font-size: 22px;
        font-weight: normal;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <?php
        $logo = get_custom_logo();
        if ( "" !== $logo ) {
          echo $logo;
        } else {
          echo "<h1>" . get_bloginfo( 'name' ) . "</h1>";
        }
      ?>
      <?php 
        if ( "" !== $frontity_server) {
          echo "<h2>There was a problem loading this page. Try again or come back later.<h2>";
        } else {
          echo "<h2>Please enter a valid <a href='https://api.frontity.org/frontity-plugins/embedded-mode#settings'>Frontity Server URL.</a></h2>";
        }
      ?>
    </div>
  </body>
</html>