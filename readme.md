# Yii2 url shortener with multi Tenant.

I´ve forked this for https://github.com/Eseperio/yii2-url-shortener

Its a particular features i needed.
And added some features like:
UUID
Modular Assets
Redirect to controller specific using modular.
Remove time_until.
Check if exist a short link with same params before create another.
And use MultiTenant.


## Installation

Add the module to your config file:

**First:** Run the migration included in @vendor/eseperio/yii2-url-shortener/src/migrations.

```php
  //...

'modules' => [
     'shortener' => [
            'class' => \eseperio\shortener\ShortenerModule::class
        ]
  ]

  //...

```

Add the bootstrap class to your bootstrap configuration.
```php

'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        \eseperio\shortener\Bootstrap::class,
    ],

    'aliases' => [
    //...
```

## Usage


Making a short link

```php
Yii::$app->getModule('shortener')->short('http://original.url/goes/here')

// An array can be provided too.

Yii::$app->getModule('shortener')->short(['controller/action','param' => 'value'])
```

A lifetime can be established. Link will stop working since that date.

```php
Yii::$app->getModule('shortener')->short($url, 3600)
```

Expanding a link

```php
Yii::$app->getModule('shortener')->expand('link id')
```

## Redirection
Module includes a controller to handle redirections. The only thing you need, to make it work, it is create a link to your app domain, followed by the short id of url.

`http://myapp.tld/gGyU`
