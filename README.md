# Kirby3 Mastodon
[![Release](https://img.shields.io/github/release/Fundevogel/kirby3-mastodon.svg)](https://github.com/Fundevogel/kirby3-mastodon/releases) [![License](https://img.shields.io/github/license/Fundevogel/kirby3-mastodon.svg)](https://github.com/Fundevogel/kirby3-mastodon/blob/main/LICENSE) [![Issues](https://img.shields.io/github/issues/Fundevogel/kirby3-mastodon.svg)](https://github.com/Fundevogel/kirby3-mastodon/issues)

This plugin provides access to your [Mastodon](https://joinmastodon.org) statuses, called 'toots'.


## Getting started

Use one of the following methods to install & use `kirby3-mastodon`:

### Git submodule

If you know your way around Git, you can download this plugin as a [submodule](https://github.com/blog/2104-working-with-submodules):

```text
git submodule add https://github.com/Fundevogel/kirby3-mastodon.git site/plugins/kirby3-mastodon
```

### Composer

```text
composer require fundevogel/kirby3-mastodon
```

### Clone or download

1. [Clone](https://github.com/Fundevogel/kirby3-mastodon.git) or [download](https://github.com/Fundevogel/kirby3-mastodon/archive/main.zip) this repository.
2. Unzip / Move the folder to `site/plugins`.


## Configuration

You may change certain options from your `config.php` globally (`'kirby3-mastodon.optionName'`):

| Option             | Type   | Default           | Description                           |
| ------------------ | ------ | ----------------- | ------------------------------------- |
| `'instance'`       | string | `mastodon.social` | Mastodon instance                     |
| `'client_key'`     | string | `''`              | Client key                            |
| `'client_secret'`  | string | `''`              | Client secret                         |
| `'access_token'`   | string | `''`              | Access token                          |
| `'app_name'`       | string | `'Test App'`      | Application name                      |
| `'app_url'`        | string | `''`              | Application URL                       |
| `'cache_duration'` | int    | `'auto'`          | Cache duration for toots (in minutes) |
| `'download_media'` | bool   | `'weit'`          | Whether images should be downloaded   |
| `'template'`       | string | `mastodon.image`  | File template for downloaded images   |

**Note:** For starters, register an application (Edit profile > Development > New Application) & enter its `fundevogel.mastodon.access_token` - otherwise, you'll *only* be granted application-level access.


## Usage

There's a snippet to get you started:

```php
# Timeline of currently active account
<?php snippet('mastodon') ?>

# Timeline of a different account
<?php snippet('mastodon', ['account' => '1234567890']) ?>

# Specific status (any account)
<?php snippet('mastodon', ['id' => '1234567890']) ?>
```

It's pretty much a boilerplate to get you started - enjoy!


## Methods

There are several ways to do this, you can either work with a `php-mastodon` API object (via site method) or two page methods:

### Site method: `$site->mastodon(): \Fundevogel\Mastodon\Api`

Grants access to a fully-enabled `Api` instance (see [here](https://github.com/Fundevogel/php-mastodon)).


### Page method: `$page->toot(string $id): array`

Get matching 'toot' for given `$id`.


### Page method: `$page->toots(string $id = '')`

Get last 20 'toots' of given account `$id` (defaults to currently active account).


## Roadmap

- [ ] Add tests


## Credits / License

Mastodon is owned and operated by [Eugen Rochko aka Gargron](https://mastodon.social/@Gargron) and his [Mastodon gGmbH](https://blog.joinmastodon.org/2021/08/mastodon-now-a-non-profit-organisation) (german non-profit limited liability company). Thanks, Eugen!

`kirby3-mastodon` is based on [`php-mastodon`](https://github.com/Fundevogel/php-mastodon) library, both licensed under the [GPL v3 License](LICENSE), but **using Kirby in production** requires you to [buy a license](https://getkirby.com/buy).

## Special Thanks

I'd like to thank everybody that's making great software - you people are awesome. Also I'm always thankful for feedback and bug reports :)
