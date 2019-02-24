<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return view('/index');
});

$router->get('api/list', 'NoteController@index');
$router->post('api/list/create', 'NoteController@store');
$router->delete('api/list/{id}/destroy', 'NoteController@destroy');
$router->post('api/list/{id}/update', 'NoteController@update');

// $app->group(['prefix' => 'api/v1'], function () use ($app) {
//     $app->get('users', function ()    {
//         // Matches The "/admin/users" URL
//     });
// });
