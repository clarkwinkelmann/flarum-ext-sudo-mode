# Sudo Mode

[![MIT license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/clarkwinkelmann/flarum-ext-sudo-mode/blob/master/LICENSE.txt) [![Latest Stable Version](https://img.shields.io/packagist/v/clarkwinkelmann/flarum-ext-sudo-mode.svg)](https://packagist.org/packages/clarkwinkelmann/flarum-ext-sudo-mode) [![Total Downloads](https://img.shields.io/packagist/dt/clarkwinkelmann/flarum-ext-sudo-mode.svg)](https://packagist.org/packages/clarkwinkelmann/flarum-ext-sudo-mode) [![Donate](https://img.shields.io/badge/paypal-donate-yellow.svg)](https://www.paypal.me/clarkwinkelmann)

This Flarum extension requires users to enter their password again before performing security critical operations.
Sudo mode is then active for 1h before the password is required again.

This is mostly intended to protect admin accounts but some moderation actions are also protected.

[API keys](https://docs.flarum.org/rest-api#api-keys) are not subject to sudo mode and can still perform any administrative action.
[Access Tokens](https://docs.flarum.org/rest-api#access-tokens) are subject to sudo mode and can theoretically pass the gate but it probably doesn't make sense since those use cases won't know the password.

The following actions are protected by sudo mode:

- View admin panel info (list of extensions, PHP version, dashboard stats, etc.)
- Enable/disable extensions
- Edit settings
- Edit permissions
- Create/edit/delete group
- Create/edit/delete tag
- Edit user credentials, groups or delete user
- Any other action protected by `User::assertAdmin()` in a third-party extension

Once the UI for developer tokens is finalized in a future Flarum version, developer access tokens could be made to bypass sudo mode and at the same time creating new tokens could be protected by sudo mode.

It's possible that you may be unable to see some restricted content on the forum pages until you enable sudo mode by going to the admin panel.
Please open an issue if you notice any place where this happens.

## Installation

    composer require clarkwinkelmann/flarum-ext-sudo-mode

If there is an error that makes you unable to access the admin panel, remove the extension with Composer: `composer remove clarkwinkelmann/flarum-ext-sudo-mode`.

## Support

This extension is under **minimal maintenance**.

It was developed for a client and released as open-source for the benefit of the community.
I might publish simple bugfixes or compatibility updates for free.

You can [contact me](https://clarkwinkelmann.com/flarum) to sponsor additional features or updates.

Support is offered on a "best effort" basis through the Flarum community thread.

## Links

- [GitHub](https://github.com/clarkwinkelmann/flarum-ext-sudo-mode)
- [Packagist](https://packagist.org/packages/clarkwinkelmann/flarum-ext-sudo-mode)
- [Discuss](https://discuss.flarum.org/d/32006)
