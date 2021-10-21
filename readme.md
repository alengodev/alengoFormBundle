<p align="center">
    <a href="https://github.com/sulu/sulu/blob/master/LICENSE" target="_blank">
        <img src="https://img.shields.io/github/license/alengodev/alengoFormBundle?style=flat-square" alt="GitHub license">
    </a>
    <a href="https://github.com/sulu/sulu/releases" target="_blank">
        <img src="https://img.shields.io/github/v/tag/alengodev/alengoFormBundle?style=flat-square" alt="GitHub tag (latest SemVer)">
    </a>
    <a href="https://github.com/TheCadien/SuluNewsBundle/actions" target="_blank">
        <img src="https://img.shields.io/github/workflow/status/alengodev/alengoFormBundle/PHP?style=flat-square" alt="workflows">
    </a>    
    <a href="https://github.com/sulu/sulu/releases" target="_blank">
        <img src="https://img.shields.io/badge/sulu%20compatibility-%3E=2.3-52b6ca.svg" alt="Sulu compatibility">
    </a>    
</p>

## Requirements

* PHP 8.0
* Sulu >=2.3.*
* Symfony >=4.3

### Install the bundle

Execute the following [composer](https://getcomposer.org/) command to add the bundle to the dependencies of your
project after you set the following lines in your Composer.json:

 ```yaml

"require": {
  ..
  "alengo/alengo-form-bundle": "dev-main"
},

...

"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/alengodev/alengoFormBundle"
  }
]

 ```


```bash
composer up
```



### Enable the bundle

Enable the bundle by adding it to the list of registered bundles in the `config/bundles.php` file of your project:

 ```php
 return [
     /* ... */
     Alengo\Bundle\AlengoFormBundle\AlengoFormBundle::class => ['all' => true],
 ];
 ```


### Configure the Bundle

Set the following config in your routes_admin.yaml

 ```yaml
app_form_data_api:
  type: rest
  prefix: /admin/api
  resource: Alengo\Bundle\AlengoFormBundle\Controller\Admin\FormDataController
  name_prefix: app.
 ```

Define you default Sender Email in ENV Config.
 ```.dotenv
    DEFAULT_SENDER_MAIL=test@test.de
 ```