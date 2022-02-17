# Frontity - Embedded Mode

For a full explanation please refer to the [Embedded mode documentation](https://api.frontity.org/frontity-plugins/embedded-mode). If you have any questions related to the plugin feel free to share them in [Frontity community forum](https://community.frontity.org/).

## Install

1. First of all you have to install the plugin. [Download the plugin from GitHub](https://github.com/frontity/frontity-embedded/archive/refs/heads/master.zip) and upload it to your web server. For a more detailed explanation, WordPress explains how to do this [on this guide](https://wordpress.org/support/article/managing-plugins/#manual-plugin-installation).
2. Once installed, you have to activate it, go to Settings -> Frontity Embedded Mode, and define the proper Frontity Server Url. and it will be running!

> Revisions are necessary to do post previews, so make sure those are activated for both your posts, pages and any custom post types.

## Environment Variables

You can also use an environment variable instead of changing the URL in the plugin interface.

```php
> FRONTITY_SERVER=https://myfrontityserver.com
```

## WordPress Constant

Lastly a PHP constant can be defined. This would usually be done in the wp-config.php file.

```
define( 'FRONTITY_SERVER', 'https://myfrontityserver.com' );
```

Note that if the PHP constant exists, it takes precedence over both the environment variable and the settings page setting.

## Static Assets

If you need, you can change the folder or URL where your static assets are stored using the `--public-path` option of the `npx frontity build` command.

### Example: Frontity in the same WordPress server

If you are using the same server for both WordPress and Frontity, and your Frontity project is at `/wp-content/frontity`, your static folder will be at `https://yourdomain.com/wp-content/frontity/build/static`.

You can change the folder when you run `npx frontity build` like this:

```bash
> npx frontity build --public-path /wp-content/frontity/build/static
```

### Example: Frontity in an external server

If you deployed Frontity in an external hosting service, like for example Vercel, you can use the `--public-path` option to point directly to the Vercel URL:

```bash
> npx frontity build --public-path https://myfrontityapp.now.sh/static
```

## Local Development

If you want to use the Embedded mode while you are developing in your local environment, you can do so by using the `--public-path` parameter in the `npx frontity dev` command as well:

```bash
> npx frontity dev --public-path http://localhost:3000/static
```

---

## Frontity Channels 🌎

[![Community Forum Topics](https://img.shields.io/discourse/topics?color=blue&label=community%20forum&server=https%3A%2F%2Fcommunity.frontity.org%2F)](https://community.frontity.org/) [![Twitter: frontity](https://img.shields.io/twitter/follow/frontity.svg?style=social)](https://twitter.com/frontity) ![Frontity Github Stars](https://img.shields.io/github/stars/frontity/frontity?style=social)

We have different channels at your disposal where you can find information about the Frontity project, discuss it and get involved:

- 📖 **[Docs](https://docs.frontity.org)**: this is the place to learn how to build amazing sites with Frontity.
- 👨‍👩‍👧‍👦 **[Community](https://community.frontity.org/)**: use our forum to [ask any questions](https://community.frontity.org/c/dev-talk-questions), feedback and meet great people. This is your place too to share [what are you building with Frontity](https://community.frontity.org/c/community/showcases/19)!
- 🐞 **[GitHub](https://github.com/frontity)**: we use GitHub for bugs and pull requests. Questions are answered in the [community forum](https://community.frontity.org/)!
- 🗣 **Social media**: a more informal place to interact with Frontity users, reach out to us on [Twitter](https://twitter.com/frontity).
- 💌 **Newsletter**: do you want to receive the latest framework updates and news? Subscribe [here](https://frontity.org/)

### » Get involved 🤗

Got questions or feedback about Frontity? We'd love to hear from you. Use our [community forum](https://community.frontity.org) yo ! ❤️

Frontity also welcomes contributions. There are many ways to support the project! If you don't know where to start, this guide might help: [How to contribute?](https://docs.frontity.org/contributing/how-to-contribute)
