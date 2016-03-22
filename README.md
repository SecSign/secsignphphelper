# SecSign ID PHP Helper


**Overview**

SecSign ID Api is a ready to use two-factor authentication package for PHP web applications.
It allows a secure login using a private key on a smart phone running SecSign ID by SecSign Technologies Inc.


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

Include the SecSignHelper and create a new SecSignHelper object. Extpath defines the public directory where the SecSign directory is located (usually it is /vendor with composer). The API php files should be externally available for ajax requests and polling to validate logins on the fly. Please make sure that jQuery is running, when building the SecSign ID login form with buildLoginForm.

The form will be submitted automatically when the user accepts the access pass on his smartphone. If the user is authenticated correctly, validateLogin will return true and the POST data will include the SecSign ID, which can be used to retrieve user data in the local database etc. If the authentication fails, validateLogin will return an error message. 

```php
<?php

require_once __DIR__.'/vendor/secsign/secsignphphelper/SecSignHelper.php';

$secsignid = new SecSignHelper;
$extPath = "http://localhost:8088/vendor";

if (empty($_POST)) {
    echo $secsignid->buildLoginForm("SecSign ID Login", $extPath, "true");
} else {
  $authenticated = $secsignid->validateLogin($_POST);
  if($authenticated === true){
    // User is logged in, do something
    $user_secsign_id = $_POST['secsigniduserid'];
  }
}
```

Have a look at the Php-Api tutorial <https://www.secsign.com/php-tutorial/>
or visit <https://www.secsign.com> for more information.


**Info**

The SecSign ID PHP Api is also used in the wordpress plugin <http://wordpress.org/plugins/secsign/> 
as well as for the php bridge in the SecSign ID Javascript Api <https://github.com/SecSign/secsign-js-api>.

For further information about the wordpress plugin see the tutorial <https://www.secsign.com/wordpress-tutorial/>


===============

SecSign Technologies Inc. official site: <https://www.secsign.com>
