<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Auth::routes(['verify' => true]);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['middleware' => 'api'])->group(function () {
    Route::resources([
        'regions' => 'RegionController',
        'interest-zones' => 'InterestZoneController',
        'udes' => 'UdeController',
        'ude-classes' => 'UdeClassController',
        'emergencies' => 'EmergencyController',
        'mqtt-topics' => 'MqttTopicController',
        'sensors' => 'SensorController',
        'type-sensors' => 'TypeSensorController',
        'events' => 'EventController',
    ]);

    Route::get('/event/eventsByDate', 'EventController@getEventsByDate');
});


// 'emergency-parameters' => 'EmergencyParameterController',
// Route::resource('user-roles', 'UserRoleController');
// Route::resource('user-role-actions', 'UserRoleActionController');