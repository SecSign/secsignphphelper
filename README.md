# SecSign ID PHP Helper


**Overview**

SecSign ID Api is a ready to use two-factor authentication package for PHP web applications.
It allows a secure login using a private key on a smart phone running SecSign ID by SecSign Technologies Inc.

For a more detailed overview please refer to the [SecSign ID PHP Api tutorial](https://www.secsign.com/php-tutorial/) and to the [SecSign ID PHP Helper Bundle for Composer](https://www.secsign.com/php-helper-bundle-for-composer/)
**Installation**

Include this package in your `composer.json` and run `composer install`

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/SecSign/secsignphphelper",
      "minimum-stability":"dev"
    }],
  "require" : {
    "SecSign/secsignphphelper": "*",
  }
}
```


**Usage**

Include the SecSignHelper
```php
require_once __DIR__.'/vendor/secsign/secsignphphelper/SecSignHelper.php';
```

Print secsign login form with polling etc. Make sure that jQuery is available
```php
echo $secsignid->buildLoginForm("SecSign OAuth2.0 Provider Login", $extPath, "true");
```

The form submits when the user accepts the access pass on his smartphone. If the user is authenticated correctly, validateLogin will return true and the POST data will include the SecSign ID, which can be used to retrieve user data in the local database etc.
If the authentication fails, validateLogin will return an error message. 
```php
$authenticated = $secsignid->validateLogin($_POST);
```

Have a look at the [PHP-AAPI tutorial](https://www.secsign.com/php-tutorial/)
or visit <https://www.secsign.com> for more information.


**Info**

The SecSign ID PHP Api is also used in the wordpress plugin <http://wordpress.org/plugins/secsign/> 
as well as for the php bridge in the [SecSign ID Javascript Api](https://github.com/SecSign/secsign-js-api).

For further information about the wordpress plugin see the tutorial <https://www.secsign.com/wordpress-tutorial/>


===============

SecSign Technologies Inc. official site: <https://www.secsign.com>
