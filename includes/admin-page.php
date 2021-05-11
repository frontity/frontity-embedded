<?php

function frontity_embedded_register_menu() {
  add_options_page(
    'Frontity Embedded Mode',
    'Frontity Embedded Mode',
    'manage_options',
    'frontity-embedded-plugin',
    'frontity_embedded_render_admin_page'
  );
}
add_action( 'admin_menu', 'frontity_embedded_register_menu' );

function frontity_embedded_render_admin_page() {
  ?>
    <div class="wrap">
      <h2>Frontity Embedded Mode</h2>
      <p>For detailed information and usage instructions please refer to the <a href="https://api.frontity.org/frontity-plugins/embedded-mode" target="_blank">documentation page</a>.</p>
      <form method="POST" action="options.php">
          <?php
              settings_fields( 'frontity_embedded_plugin_settings' );
              do_settings_sections( 'frontity_embedded_plugin_page' );
          ?>
          <?php submit_button(); ?>
      </form>
    </div>
  <?php
}

function frontity_embedded_register_settings() {
  register_setting(
    'frontity_embedded_plugin_settings',
    'frontity_embedded_plugin_settings',
    array(
      'sanitize_callback' => 'frontity_embedded_validate_settings'
    )
  );

  add_settings_section(
    'frontity_embedded_plugin_section',
    '',
    '__return_empty_string',
    'frontity_embedded_plugin_page'
  );

  add_settings_field(
    'frontity_server',
    'Frontity Server URL',
    'frontity_embedded_frontity_server_input',
    'frontity_embedded_plugin_page',
    'frontity_embedded_plugin_section'
  );
}
add_action( 'admin_init', 'frontity_embedded_register_settings' );

function frontity_embedded_validate_settings( $input ) {
  $output['frontity_server'] = esc_url( sanitize_text_field( $input['frontity_server'] ) );
  return $output;
}

function frontity_embedded_frontity_server_input() {
  $options = get_option( 'frontity_embedded_plugin_settings' );
  printf(
    '<input type="text" name="%s" value="%s" style="width: 100%%; max-width: 500px;">',
    esc_attr( 'frontity_embedded_plugin_settings[frontity_server]' ),
    esc_attr( $options['frontity_server'] )
  );
}
