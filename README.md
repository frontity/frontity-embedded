# Frontity Embedded Mode - [Proof of Concept]

> ⚠️ This is only a proof of concept of the Embedded Mode idea, not the real plugin. Don't use this in production. This mode will be released as part of the upcoming [Frontity WordPress Plugin](https://github.com/frontity/wp-plugins). Once it's released, we will remove/update this proof of concept. If you want to know about the release you can subscribe to our newsletter at https://frontity.org.

## Install

If you want to test it out, you can download the zip file from GitHub.

- [Download the zip](https://github.com/frontity/frontity-embedded-proof-of-concept/archive/master.zip) or clone this repository.
- Unzip the plugin and edit the `includes/template.php` file to add the URL of your Frontity project.

```php
$frontity_server = "https://myfrontityserver.com";
```

- Compress it again and upload it to your WordPress.

## Environment Variables

You can also use an environment variable instead of changing the URL in the code.

```bash
> FRONTITY_SERVER=https://myfrontityserver.com
```

## Static Assets

> **This step won‘t be necessary in the final plugin.**

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

## Feature Discussion

If you want to give feedback or participate in the conversation before we release the final version of this mode, please join the [**Embedded Mode Feature Discussion**](https://community.frontity.org/t/embedded-mode/1432).

In our community, you can also join other discussions, vote for those you‘re interested in, or create new ones.

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
