# Frontity Embedded Mode - [Proof of Concept]

> ⚠️ This is only a proof of concept of the Embedded Mode idea, not the real plugin. Don't use this in production. This mode will be released as part of the upcoming [Frontity WordPress Plugin](https://github.com/frontity/wp-plugins). Once it's released, we will remove/update this proof of concept. If you want to know about the release you can subscribe to our newsletter at https://frontity.org.

## Install

If you want to test it out, you can download the zip file from GitHub.

- [Download the zip](https://github.com/frontity/frontity-embedded-proof-of-concept/archive/master.zip) or clone this repository.
- Unzip the plugin and edit the `includes/template.php` file to add the URL of your Frontity project.
- Compress it again and upload it to your WordPress.

## Static Folder

If you need, you can change the folder where your static assets are store in the `includes/template.php` file. If you do so, you also need to tell Frontity about the new folder.

For example, if you are using the same server for both WordPress and Frontity, and your Frontity project is at `/wp-content/frontity`, your static folder will be at `https://yourdomain.com/wp-content/frontity/build/static`.

You can change the folder when you run `npx frontity build` like this:

```bash
> npx frontity build --publicPath /wp-content/frontity/build/static`
```

And then edit the `includes/template.php` variable like this:

```php
$frontity_static_folder = '/wp-content/frontity/build/static/';
```

This configuration will be automatic in the final plugin.

## Environment Variables

## Feature Discussion

[**Feature Discussions**](https://community.frontity.org/c/feature-discussions/33) about Frontity are public. You can join the discussions, vote for those you're interested in or create new ones.

These are the ones related to this package: https://community.frontity.org/tags/c/feature-discussions/33/analytics

## Changelog

Have a look at the latest updates of this package in the [CHANGELOG](https://github.com/frontity/frontity/blob/dev/packages/analytics/CHANGELOG.md)

---

### » Frontity Channels 🌎

[![Community Forum Topics](https://img.shields.io/discourse/topics?color=blue&label=community%20forum&server=https%3A%2F%2Fcommunity.frontity.org%2F)](https://community.frontity.org/) [![Twitter: frontity](https://img.shields.io/twitter/follow/frontity.svg?style=social)](https://twitter.com/frontity) ![Frontity Github Stars](https://img.shields.io/github/stars/frontity/frontity?style=social)

We have different channels at your disposal where you can find information about the project, discuss about it and get involved:

- 📖 **[Docs](https://docs.frontity.org)**: this is the place to learn how to build amazing sites with Frontity.
- 👨‍👩‍👧‍👦 **[Community](https://community.frontity.org/)**: use our forum to [ask any questions](https://community.frontity.org/c/dev-talk-questions), feedback and meet great people. This is your place too to share [what are you building with Frontity](https://community.frontity.org/c/showcases)!
- 🐞 **[GitHub](https://github.com/frontity/frontity)**: we use GitHub for bugs and pull requests. Questions are answered in the [community forum](https://community.frontity.org/)!
- 🗣 **Social media**: a more informal place to interact with Frontity users, reach out to us on [Twitter](https://twitter.com/frontity).
- 💌 **Newsletter**: do you want to receive the latest framework updates and news? Subscribe [here](https://frontity.org/)

### » Get involved 🤗

[![GitHub issues by-label](https://img.shields.io/github/issues/frontity/frontity/good%20first%20issue)](https://github.com/frontity/frontity/issues?q=is%3Aissue+is%3Aopen+label%3A%22good+first+issue%22)

Got questions or feedback about Frontity? We'd love to hear from you. Use our [community forum](https://community.frontity.org) yo ! ❤️

Frontity also welcomes contributions. There are many ways to support the project! If you don't know where to start, this guide might help: [How to contribute?](https://docs.frontity.org/contributing/how-to-contribute)

If you're eager to start contributing to the code, maybe you'd like to open a pull request to address one of our [_good first issues_](https://github.com/frontity/frontity/issues?q=is%3Aissue+is%3Aopen+label%3A%22good+first+issue%22)
