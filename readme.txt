=== Frontity Embedded Mode ===
Contributors: frontity
Tags: rest, api, embedded, decoupled, frontity
Requires at least: 5.6
Tested up to: 5.7
Stable tag: trunk
Requires PHP: 7.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

Enables the Embedded Mode implementation of Frontity, replacing the active WordPress theme. Made by [Frontity](https://frontity.org?utm_source=plugin-repository&utm_medium=readme&utm_campaign=embedded-mode-plugin).

== Description ==

This plugin enables an **Embedded Mode** implementation of Frontity. It can be contrasted with **Decoupled Mode**. In Decoupled Mode the primary domain points to the Frontity site, with the WordPress site being on a secondary domain or on a subdomain of the primary domain.

In Embedded Mode the primary domain points to the WordPress site, and the Frontity site can be on another domain.

This plugin replaces the active WordPress theme with the Frontity installation. Frontity therefore effectively becomes the WordPress sites' theme. It works by substituting it's own template.php in place of any call made to the WordPress template hierarchy.

== Support ==

For a more detailed explanation please refer to its own [documentation](https://api.frontity.org/frontity-plugins/embedded-mode). If you have any questions related to the plugin feel free to share them in [Frontity community forum](https://community.frontity.org/) and, if you want to contribute to the code, Pull Requests are welcome on [GitHub](https://github.com/frontity/frontity-embedded).

== Settings ==

#### Frontity server URL

This plugin only has 1 setting, the URL of the Frontity Server. It can be defined in the plugin interface, with an environment variable or with a WordPress constant.

== Installation ==

1. First of all you have to install the plugin. You can do it:
    * **Automatic**: from within WordPress dashboard go to Plugins, click Add New button, search for Frontity Embedded Mode by Frontity and click Install Now.
    * **Manual**: this method requires to download the plugin and upload it to your web server via FTP. For a more detailed explanation, WordPress explains how to do this [on this guide](https://wordpress.org/support/article/managing-plugins/#manual-plugin-installation).
    
2. Once installed, you have to activate it, go to Settings -> Frontity Embedded Mode, and define the proper Frontity Server Url. and it will be running! 

== Screenshots ==

1. Frontity Embedded Mode Settings

== Changelog ==

= 1.0.0 =

Major Changes: Release the first version of the Frontity Embedded Mode plugin.