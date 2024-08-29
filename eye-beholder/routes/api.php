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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resources([
    'regions' => 'RegionController',
    'interest-zones' => 'InterestZoneController',
    'udes' => 'UdeController',
    'ude-classes' => 'UdeClassController',
    'emergencies' => 'EmergencyController',
    'mqtt-topics' => 'MqttTopicController',
    'sensors' => 'SensorController',
    'type-sensors' => 'TypeSensorController',
]);
// 'emergency-parameters' => 'EmergencyParameterController',
// Route::resource('user-roles', 'UserRoleController');
// Route::resource('user-role-actions', 'UserRoleActionController');