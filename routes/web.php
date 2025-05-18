<?php

use Illuminate\Support\Facades\Route;

Route::get('/info', function () {
    dd(phpinfo());
});
