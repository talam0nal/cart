Installation
-------
1. Add information of this repository to composer.json file:
```json
"repositories": [
    {
        "type": "git",
        "url": "https://github.com/talam0nal/cart.git"
    },
```

2. The preferred way to install Cart is through Composer. For this, add "talam0nal/cart": "*" to the requirements in your composer.json file


3. Add *CartServiceProvider::class* to config/app.php 
```php
Talam0nal\Cart\CartServiceProvider::class
```

4. Run 
```shell
php artisan vendor:publish
```

5. Run new migrations
```shell
php artisan migrate
```