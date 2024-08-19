<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\AgentController;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Product;
use App\Models\Transaction;

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


// Customer
Route::get('/add-customer', function () {
    return view('Admin.add_customer');
})->middleware(['auth'])->name('add.customer');

Route::post('/insert-customer', [CustomerController::class, 'store'])->middleware(['auth']);

Route::get('/all-customers', [CustomerController::class, 'customersData'])->middleware(['auth'])->name('all.customers');
Route::get('/edit-customer', function () {
    return view('Admin.edit_customer');
})->middleware(['auth'])->name('assignee.edit');

// Device
Route::controller(DeviceController::class)->middleware(['auth'])->group(function () {
    Route::get('/all-devices', 'allDevices')->name('all.devices');
    Route::get('/assign-device/{id}', 'assignNewDevice')->name('assign.device');
    Route::get('/device-edit/{id}', 'editDevice')->name('device.edit');
    Route::get('/add-device', 'addDevice')->name('add.device');
    Route::post('/device-assign', 'assign')->name('device.assign');
    Route::post('/create-device', 'create')->name('create.device');
    Route::post('/update-device', 'update')->name('edit.device');
});

// Agents
Route::controller(AgentController::class)->middleware(['auth'])->group(function () {
    Route::get('/new-agent', 'create')->name('add.agent');
    Route::get('/edit-agent/{id}', 'edit')->name('edit.agent');
    Route::get('/all-agents', 'view')->name('all.agents');
    Route::post('/update-agent', 'update')->name('update.agent');
    Route::post('/create-agent', 'createAgent')->name('create.agent');
});




Route::get('/dashboard', function () {

    $deviceCounts = [];

    $devices = Device::selectRaw('product_id,
    sum(case when is_assigned=1 then 1 else 0 end) as assigned, 
    sum(case when is_assigned=0 then 1 else 0 end) as unassigned')
        ->groupBy('product_id')
        ->get();

    foreach ($devices as $device) {
        $prod = Product::find($device['product_id']);
        $deviceCounts[] = [
            'category' => $prod->category,
            'name' => $prod->name,
            'code' => $prod->product_code,
            'assigned' => $device->assigned,
            'unassigned' => $device->unassigned
        ];
    }

    $transactions = Transaction::select('transaction_type', 'user_id', 'users.name', 'notes', 'transactions.updated_at')
        ->leftJoin('users', 'users.id', '=', 'transactions.user_id')
        ->orderBy('updated_at', 'desc')
        ->limit(100)
        ->get();

    return view('admin-dashboard')
        ->with('transactions', $transactions)
        ->with('devices', $deviceCounts);
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
