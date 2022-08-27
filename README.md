# Binary SMS Gateway
Binary SMS is a package for BinarySMS Gateway Service

# Installation
Run this command
```
composer require binarycaster/binarysms
```
# Laravel
If you are using **Laravel < 5.5** add provider class manually in `config/app`

```php
Binarycaster\Binarysms\ServiceProviders\BinarysmsServiceProvider::class,
```
For facade support add alias
```php
'Binarysms' => Binarycaster\Binarysms\Facades\BinarysmsManager::class,
```
Publish config file using this command
```
php artisan vendor:publish --provider="Binarycaster\Binarysms\ServiceProviders\BinarysmsServiceProvider"
```
# Lumen
Create a new config file `config/binarysms.php` and load configurations in `bootstrap/app.php`
```php
$app->configure('binarysms');
```
Register Service Provider class by adding this line in register section
```php
$app->register(Binarycaster\Binarysms\ServiceProviders\BinarysmsServiceProvider::class);
```
# Configuration
Required configs are:
- app-key => Generated App Key from the Binarysms Admin Panel,
- app-secret => Generated App Key from the Binarysms Admin Panel,
- default-sender-id => Check Binarysms Admin Panel,
# Usage
**In PHP**
```php
$binarySms = new Binarysms([]);

$binarySms->to(['01xxxxxxxxx'])
    ->text('Hello World')
    ->send();
```
**In Laravel**
```php
Binarysms::to('01xxxxxxxxx')->text('Hello World!')->send();
```
**In Lumen**
```php
use Binarycaster\Binarysms\Facades\BinarysmsManager;

BinarysmsManager::to('01xxxxxxxxx')->text('Hello World!')->send();
```

