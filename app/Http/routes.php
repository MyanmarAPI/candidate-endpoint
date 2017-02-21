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
    'prefix'    => '/health-check',
], function () use ($app)
{
    $app->get('/', function() {
        return response_ok(['message' => 'Ok.']);
    });
});

$app->group([
    'middleware'=> 'auth',
    'prefix'    => 'candidate/v1',
    'namespace' => 'App\Http\Controllers'
], function () use ($app)
{
    $app->get('/versions', function() use ($app) {
        $dataVersion = app('data_version');
        $versions['candidate'] = $dataVersion->current('candidate');
        $versions['party'] = $dataVersion->current('party');
        return response_ok($versions);
    });

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

    //Call with Year Indicators
    $app->get('{year}/list', [
        'as'    => $pre . 'year.list',
        'uses'  => 'CandidateController@candidateList'
    ]);

    $app->get('{year}/search', [
        'as'    => $pre . 'year.search',
        'uses'  => 'CandidateController@search'
    ]);

});

$app->group([
    'middleware'=> 'auth',
    'namespace' => 'App\Http\Controllers'
], function () use ($app) {

    //Party with Year Indicators
    $app->get('contesting-party/{year}', [
        'as' => 'party.electionyear',
        'uses' => 'PartyController@getPartyByYear'
    ]);

    $app->get('contesting-party/{year}/search', [
        'as' => 'party.electionyear',
        'uses' => 'PartyController@search'
    ]);

});
