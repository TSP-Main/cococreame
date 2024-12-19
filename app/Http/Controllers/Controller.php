<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\View;

abstract class Controller
{
    public function __construct()
    {
        $currencySymbol = restaurant_detail()['restaurantDetail']['currency_symbol'];
        View::share('currencySymbol', $currencySymbol);
    }
}
