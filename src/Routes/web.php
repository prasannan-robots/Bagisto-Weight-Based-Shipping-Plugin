
<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'admin']], function () {
    // Add your admin routes here
});
