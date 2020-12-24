<?php

Route::group(['prefix' => 'v1', 'namespace' => 'V1', 'middleware' => ['api-v1']], function() {
    
    Route::get('/me', 'UserController@me');
    
});