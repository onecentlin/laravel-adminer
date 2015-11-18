<?php

Route::any('/', [
    'as' => 'index',
    'uses' => 'AdminerController@index',
]);
