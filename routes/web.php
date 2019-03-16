<?php

use App\Models\Category;

Route::get('/', function () {
    $categories = Category::get();

    dd($categories);
});