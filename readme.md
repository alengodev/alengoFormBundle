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
* Symfony >=4.3
* Swiftmailer

### Install the bundle

Execute the following [composer](https://getcomposer.org/) command

```bash
composer require alengo/alengo-form-bundle
```


### Enable the bundle

Enable the bundle by adding it to the list of registered bundles in the `config/bundles.php` file of your project:

 ```php
 return [
     /* ... */
     Alengo\Bundle\AlengoFormBundle\AlengoFormBundle::class => ['all' => true],
 ];
 ```

```bash
bin/console do:sch:up --force
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



### Use the Bundle

You can use and include the following two interfaces to save the forms and send an email with them


#### Alengo\Bundle\AlengoFormBundle\Service\SaveFormInterface
 ```php
   public function saveFormDataFromRequest(array $data, string $webspace, string $location, string $category, string $receiverMail = NULL, bool $copy = false): FormData;

 ```
#### Alengo\Bundle\AlengoFormBundle\Service\SendFormInterface
 ```php
    public function sendFormDataAsMail(FormData $formData, string $template, string $title);
 ```

### Example

Simple example which sends a copy to the person who filled in the form and his deposited mail
 ```php
$formData = $this->saveForm->saveFormDataFromRequest($request->request->all(),$request->get('_sulu')->getAttribute('webspace')->getKey(),$request->getLocale(),'contact',NULL,true);
$this->sendForm->sendFormDataAsMail($formData,'hello/email.txt.twig','Welcome Mail');
 ```