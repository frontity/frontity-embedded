=== Frontity Embedded Mode ===
Contributors: frontity
Tags: rest, api, embedded, decoupled, frontity
Requires at least: 5.6
Tested up to: 5.9
Stable tag: 1.5.1
Requires PHP: 7.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

Enables the Embedded Mode implementation of Frontity, replacing the active WordPress theme. Made by [Frontity](https://frontity.org?utm_source=plugin-repository&utm_medium=readme&utm_campaign=embedded-mode-plugin).

== Description ==

This plugin enables an **Embedded Mode** implementation of Frontity. It can be contrasted with **Decoupled Mode**. In Decoupled Mode the primary domain points to the Frontity site, with the WordPress site being on a secondary domain or on a subdomain of the primary domain.

In Embedded Mode the primary domain points to the WordPress site, and the Frontity site can be on another domain.

This plugin replaces the active WordPress theme with the Frontity installation. Frontity therefore effectively becomes the WordPress site's theme. It works by substituting its own template.php in place of any call made to the WordPress template hierarchy.

== Support ==

For a more detailed explanation, please refer to its own [documentation](https://api.frontity.org/frontity-plugins/embedded-mode). If you have any questions related to the plugin, feel free to share them in [Frontity community forum](https://community.frontity.org/) and, if you want to contribute to the code, Pull Requests are welcome on [GitHub](https://github.com/frontity/frontity-embedded).

== Settings ==

#### Frontity server URL

This plugin only has 1 setting, the URL of the Frontity Server. It can be defined in the plugin interface, with an environment variable or with a WordPress constant.

== Installation ==

1. First of all you have to install the plugin. You can do it:
    * **Automatic**: from within WordPress dashboard go to Plugins, click Add New button, search for Frontity Embedded Mode by Frontity and click Install Now.
    * **Manual**: this method requires to download the plugin and upload it to your web server via FTP. For a more detailed explanation, WordPress explains how to do this [on this guide](https://wordpress.org/support/article/managing-plugins/#manual-plugin-installation).
    
2. Once installed, you have to activate it, go to Settings -> Frontity Embedded Mode, and define the proper Frontity Server URL and it will be running! 

== Screenshots ==

1. Frontity Embedded Mode Settings

== Changelog ==

= 1.5.1 =

- Fix Admin bar in WP 6.0 - [#30](https://github.com/frontity/frontity-embedded/pull/30) Thanks [@tobeycodes](https://github.com/tobeycodes)!

= 1.5.0 =

- Add `frontity_embedded_wp_head` and `frontity_embedded_wp_footer` hooks - [#26](https://github.com/frontity/frontity-embedded/pull/26) Thanks [@johnfrancisli](https://github.com/johnfrancisli)!

= 1.4.2 =

- Use [admin_print_scripts](https://developer.wordpress.org/reference/hooks/admin_print_scripts/) and [admin_print_styles](https://developer.wordpress.org/reference/hooks/admin_print_styles/) to echo scripts and styles in admin pages.
- Change Capability_Tokens class name to Frontity_Embedded_Capability_Tokens to be more specific.
- Change default setting value to an empty string and add a error message asking for the Frontity Server URL in case this is missing.
- Use untrailingslashit function in the server url setting.

= 1.4.1 =

- Add a link to the documentation in the Admin page - [#22](https://github.com/frontity/frontity-embedded/pull/22) Thanks [@mburridge](https://github.com/mburridge)!

= 1.4.0 =

- Add a `compose.json` - [#21](https://github.com/frontity/frontity-embedded/pull/21) Thanks [@dsawardekar](https://github.com/dsawardekar)!
- Add filters to change the request URL and arguments - [#20](https://github.com/frontity/frontity-embedded/pull/20) Thanks [@dsawardekar](https://github.com/dsawardekar)!

= 1.3.0 =

- Avoid using glob to load files - [#18](https://github.com/frontity/frontity-embedded/pull/18) Thanks [@SantosGuillamot](https://github.com/SantosGuillamot)!
- Improve handling of errors - [#17](https://github.com/frontity/frontity-embedded/pull/17) Thanks [@SantosGuillamot](https://github.com/SantosGuillamot) and [@luisherranz](https://github.com/luisherranz)!
- Restrict token capabilities - [#16](https://github.com/frontity/frontity-embedded/pull/16) Thanks [@Darerodz](https://github.com/Darerodz) and [@luisherranz](https://github.com/luisherranz)!
- Add a UI for the settings - [#15](https://github.com/frontity/frontity-embedded/pull/15) Thanks [@SantosGuillamot](https://github.com/SantosGuillamot) and [@luisherranz](https://github.com/luisherranz)!

= 1.2.0 =

- Add `frontity_embedded` query to Frontity request - [#11](https://github.com/frontity/frontity-embedded/pull/11) Thanks [@Darerodz](https://github.com/Darerodz) and [@luisherranz](https://github.com/luisherranz)!
- Increase timeout of request to the Frontity server - [#9](https://github.com/frontity/frontity-embedded/pull/9) Thanks [@luisherranz](https://github.com/luisherranz)!
- Add the option of defining the server URL using a PHP constant - [#5](https://github.com/frontity/frontity-embedded/pull/5) Thanks [@Darerodz](https://github.com/Darerodz)!
- Add the option of defining the server URL using a PHP constant - [#5](https://github.com/frontity/frontity-embedded/pull/5) Thanks [@Darerodz](https://github.com/Darerodz)!

= 1.1.0 =

- Add support for post previews - [#3](https://github.com/frontity/frontity-embedded/pull/3) Thanks [@Darerodz](https://github.com/Darerodz)!

= 1.0.0 =

- Release the first version of the Frontity Embedded Mode plugin - Thanks [@luisherranz](https://github.com/luisherranz)!
