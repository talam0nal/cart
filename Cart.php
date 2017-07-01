<?php

namespace Talam0nal\Cart;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    public static $user;

    public static $product;

    protected static $onlyInstance;

    public $timestamps = false;

    /**
     * Remains empty constructor for method chaining support
     */
    public function __construct ()
    {

    }

    /**
     * Returns total quantity of items in the cart
     *
     * @return int
     */
    public static function getTotalQuantity()
    {
        return Cart::where('user_id', self::$user)->count();
    }

    /**
     * Purges cart
     */
    public static function purge()
    {
        $items = Cart::where('user_id', self::$user)->get();
        foreach ($items as $item) {
            $item->delete();
        }
    }

    /**
     * Changes product count
     *
     * @param int $count
     */
    public static function setCount($count)
    {
        $item = Cart::where('user_id', self::$user)
                    ->where('product_id', self::$product)
                    ->first();
        if (is_null($item)) return false;
        $item->count = $item->count + $count;
        $item->count < 1 ? $item->delete() : $item->save();
    }

    /**
     * Adds product to cart
     */
    public static function add()
    {
        if (self::itemIsExists()) return false;
        $item = new Cart;
        $item->product_id = self::$product;
        $item->user_id = self::$user;
        $item->save();
    }

    /**
     * Removes product from cart
     */
    public static function remove()
    {
        if (!self::itemIsExists()) return false;
        Cart::where('product_id', self::$product)
            ->where('user_id', self::$user)
            ->first()
            ->delete();
    }

    /**
     * Checks for existance of product in cart
     *
     * @return bool
     */
    private static function itemIsExists()
    {
        return (bool) Cart::where('product_id', self::$product)
                          ->where('user_id', self::$user)
                          ->first();
    }

    /**
     * Returns instance of self
     *
     * @return object
     */
    protected static function getSelf()
    {
        if (static::$onlyInstance === null) {
            static::$onlyInstance = new Cart;
        }
        return static::$onlyInstance;
    }

    /**
     * Sets affected user
     *
     * @param int $user
     */
    public static function user($user)
    {
        static::$user = $user;
        return static::getSelf();
    }

    /**
     * Sets affected product
     *
     * @param int $product
     */
    public static function product($product)
    {
        static::$product = $product;
        return static::getSelf();
    }

    /**
     * Returns sum of cart after percentage discount
     *
     * @return int|float
     */
    public static function percentageDiscount($percentage)
    {
        return self::getSum() * ((100 - $percentage) / 100);
    }

    /**
     * Returns sum of cart after simple discount
     *
     * @return int|float
     */
    public static function simpleDiscount($amount)
    {
        $total = self::getSum() - $amount;
        if ($total < 0) return 0;
        return $total;
    }

    /**
     * Returns list of products in cart
     *
     * @return array
     */
    public static function getList()
    {

    }

    /**
     * Dummy method for getting product information by id
     *
     * @param int $id
     * @return object 
     */
    private static function getProduct($id)
    {
        $item = (object) [
            'cost'  => 220,
        ];
        return $item;
    }

    /**
     * Returns total sum of cart
     *
     * @return int|float
     */
    public static function getSum()
    {
        $items = Cart::where('user_id', self::$user)->get();
        $sum = 0;
        foreach ($items as $item) {
            $product = self::getProduct($item->product_id);
            $sum += $item->count * $product->cost;
        }
        return $sum;
    }

}