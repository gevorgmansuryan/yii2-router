# Yii2 Elegant Route definitions


## Installation (using composer)

```bash
composer require gevman/yii2-router
```


##### Add this to `modules` section of Your Yii2 configuration

```php
'modules' => [
    //...
    'router' => [
        'class' => 'Gevman\Router\Module',
        'routeFolder' => '@app/config/routes' //directory where located route files
    ]
    //,...
]
```

##### and this to `bootstrap` section

```php
'bootstrap' => [
    //...
    'router'
    //,...
],
```

in `routeFolder` directory You need create Your route files.

ex. `web.php` with content

```php
Route::prefix('some')->group(function() {
    Route::prefix('test')->group(function() {
        Route::get('route', 'site/index')->named('home')->defaults(['a' => 'b']);
        Route::get('other-route', 'site/about')->named('about')->defaults(['c' => 'd']);
    });
});
```

or just

```php
Route::get('route', 'site/index')->named('home');
```

after You can use Yii2 native methods for url creation

ex.

```php
echo \yii\helpers\Url::toRoute('@about') //output will be: /some/test/other-route
```