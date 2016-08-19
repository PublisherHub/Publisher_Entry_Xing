# XingEntry
Provides Entries for publisher/publisher to post to Xing.

XingUserEntry: post a status message as a user.
-> implements publisher/recommendation

XingForumEntry: post a message in a forum as a user.
-> implements publisher/recommendation


# Installation
The recommended way to install this is through [composer](http://getcomposer.org).

Edit your `composer.json` and add:

```json
{
    "require": {
        "publisher/xing-entry": "dev-master"
    }
}
```

And install dependencies:

```bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```