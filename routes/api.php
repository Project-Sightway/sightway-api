<?php

use Illuminate\Support\Facades\Route;

Route::get('/info', function () {
    dd(phpinfo());
});

include 'route_web.php';
include 'route_mobile.php';
