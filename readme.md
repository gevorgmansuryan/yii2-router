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
$auth = function () {
  if (Yii::$app->user->isGuest) {
      Yii::$app->response->redirect(Url::toRoute(['@login']));
  }
};

Route::prefix('/admin')->routePrefix('admin')->group(function () use ($auth) {
    Route::any('/login', 'default/login')->named('login');

    Route::middleware($auth)->group(function () {
        Route::post('/logout', 'default/logout')->named('logout');
        
        Route::any('/', 'pages/index')->named('admin.pages');
        Route::any('/pages/create', 'pages/create')->named('admin.pages.create');
        Route::any('/pages/<id>/edit/<lang>', 'pages/update')->defaults(['lang' => ''])->named('admin.pages.edit');
        Route::post('/pages/<id>/delete', 'pages/delete')->named('admin.pages.delete');

        Route::prefix('menu')->routePrefix('menu')->group(function () {
            Route::any('/', 'index')->named('admin.menu.index');
            Route::any('create', 'create')->named('admin.menu.create');
            Route::any('<id>/edit/<lang>', 'update')->defaults(['lang' => ''])->named('admin.menu.edit');
            Route::post('<id>/delete', 'delete')->named('admin.menu.delete');
        });

    });
});
```

after You can use Yii2 native methods for url creation

ex.

```php
echo \yii\helpers\Url::toRoute(['@admin.menu.edit', ['id' => 1, 'lang' => 'hy']);
```
output will be: `/admin/menu/1/edit/hy`