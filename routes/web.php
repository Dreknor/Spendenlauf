<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('stats/{full?}', [\App\Http\Controllers\StatsController::class, 'stats']);


Route::get('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return redirect(url('/'))->with('message', 'Link wurde versandt!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('projects', 'ProjectsController@index');

Auth::routes(['verify' => true]);
Route::get('image/{media_id}', 'ImageController@getImage');
Route::get('user/{user_id}/sendVerification', 'UserController@sendVerification');

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['verified'])->group(function () {
    Route::resource('laeufer', 'LaeuferController');
    Route::resource('teams', 'TeamsController');
    Route::resource('sponsoren', 'SponsorController');
    Route::resource('sponsorings', 'SponsoringController');

    Route::get('laeufer/{laeufer}/addTeam', 'LaeuferController@addTeam');
    Route::get('laeufer/{laeufer}/bestaetigung', 'LaeuferController@bescheinigung');
    Route::post('laeufer/{laeufer}/addTeam', 'LaeuferController@storeTeam');
    Route::put('laeufer/{laeufer}/removeTeam', 'LaeuferController@removeTeam');

    Route::group(['middleware' => ['permission:edit user']], function () {
        Route::resource('users', 'UserController');
    });

    Route::group(['middleware' => ['permission:show auswertung']], function () {
        Route::get('auswertung', 'AuswertungsController@index');
    });

    Route::group(['middleware' => ['permission:edit projekt']], function () {
        Route::resource('projects', 'ProjectsController', ['except'    => 'index']);
    });

    Route::group(['middleware' => ['permission:import export']], function () {
        Route::get('export/laeufer', 'ExportController@laeufer');
        Route::get('export/sponsoren', 'ExportController@sponsoren');
        Route::get('export/projects', 'ExportController@projects');
        Route::get('import/runden', 'ImportController@import');
        Route::post('import/runden', 'ImportController@importFile');
        Route::get('import/runden/url/{test?}', 'ImportController@importFromUrl');
    });

    Route::group(['middleware' => ['permission:send mail']], function () {
        Route::get('sponsor/sendMail/{sponsor}', 'SponsorController@sendMail');

    });

    Route::group(['middleware' => ['permission:edit startnummer']], function () {
        Route::get('startnummern', 'StartnummerController@index');
        Route::post('startnummern', 'StartnummerController@store');
        Route::get('startnummern/{startnummer}/delete', 'StartnummerController@destroy');

    });
});
