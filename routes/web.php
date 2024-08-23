<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ConsoleController;
use Illuminate\Http\Request;

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


Route::get('/', function () {
    return view('auth.login');
});


// Device
Route::controller(DeviceController::class)->middleware(['auth'])->group(function () {
    Route::get('/all-devices', 'allDevices')->name('all.devices');
    Route::get('/assign-device/{id}', 'assignNewDevice')->name('assign.device');
    Route::get('/device-edit/{id}', 'editDevice')->name('device.edit');
    Route::get('/add-device', 'addDevice')->name('add.device');
    Route::get('/unassign-device/{id}', 'unassign')->name('unassign.device');
    Route::get('/add-new-product', 'addNewProduct')->name('product.add');
    Route::get('/all-products', 'getAllProducts')->name('all.products');
    Route::post('/device-assign', 'assign')->name('device.assign');
    Route::post('/create-device', 'create')->name('create.device');
    Route::post('/update-device', 'update')->name('edit.device');
    Route::post('/add-product', 'addProduct')->name('add.product');
    Route::post('/add-device-note', 'addNote')->name('add.device.note');
});

// Agents
Route::controller(AgentController::class)->middleware(['auth'])->group(function () {
    Route::get('/new-agent', 'create')->name('add.agent');
    Route::get('/edit-agent/{id}', 'edit')->name('edit.agent');
    Route::get('/all-agents', 'view')->name('all.agents');
    Route::post('/update-agent', 'update')->name('update.agent');
    Route::post('/create-agent', 'createAgent')->name('create.agent');
});



// Dashboard
Route::controller(ConsoleController::class)->middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/add-new-status', 'addStatusView')->name('add.status.view');
    Route::get('/all-statuses', 'allStatuses')->name('all.statuses');
    Route::post('/add-status', 'createStatus')->name('add.status');
});


require __DIR__ . '/auth.php';
