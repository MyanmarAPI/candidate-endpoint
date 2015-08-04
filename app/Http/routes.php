<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$app->get('/', function() use ($app) {
    return $app->welcome();
});

$app->group([
    'middleware'=> 'auth',
    'prefix'    => 'candidate',
    'namespace' => 'App\Http\Controllers'
], function () use ($app)
{

    $pre = 'v1.candidate.';

    $app->get('/list', [
        'as'    => $pre . 'list',
        'uses'  => 'CandidateController@candidateList'
    ]);

    $app->get('/search', [
        'as'    => $pre . 'search',
        'uses'  => 'CandidateController@search'
    ]);

    $app->get('/{id}', [
        'as'    => $pre . 'show',
        'uses'  => 'CandidateController@show'
    ]);

});
