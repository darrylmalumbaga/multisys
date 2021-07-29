<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Product::class, function (Faker $faker)  {
    static $number = 1;
    return [
        'product_id' => $number++,
        'product_name' => $faker->unique()->name,
        'product_qty' => 100,
    ];
});
