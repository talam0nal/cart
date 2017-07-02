Installation
-------
1. Add information of this repository to composer.json file:
```json
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/talam0nal/cart.git"
        }
    ],
```

2. The preferred way to install *Cart* is through Composer. For this, add "talam0nal/cart": "*@dev" to the requirements in your composer.json file. Note: considering the features of this package its required GIT installation.


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

Usage
-------

```php
use Talam0nal\Cart\Cart;

Cart::user($id)->product($id)->add(); //Adds product
Cart::user($id)->product($id)->setCount(1); //Set amount of product
Cart::user($id)->product($id)->remove(); //Removes product from cart
Cart::user($id)->purge(); //Purges the cart
Cart::user($id)->getTotalQuantity(); //Returns amount of items in the cart
Cart::user($id)->getSum(); //Returns total sum of cart
Cart::user(1)->simpleDiscount(40); //Returns total sum of carty after simple discount
Cart::user(1)->percentageDiscount(40); //Returns total sum of cart after percentage discount
```
