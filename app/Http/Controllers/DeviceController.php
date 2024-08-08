<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Device;
use App\Models\Customer;
use Carbon\Carbon;
use DateTimeZone;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DeviceController extends Controller
{


    /**
     * Get all devices from db for databale
     *
     * @return View
     */
    public function allDevices(): View
    {
        $devices = [];
        $rs = Device::select(
            'products.product_code',
            'device_name',
            'device_status',
            'customers.name as assignee',
            'devices.updated_at as last_update',
            'unique_id'
        )
            ->leftJoin('customers', 'customers.device_id', '=', 'devices.unique_id')
            ->leftJoin('products', 'devices.product_id', '=', 'products.id')
            ->orderBy('devices.updated_at', 'desc')
            ->limit(25)
            ->get();

        foreach ($rs as $device) {
            $lastUpdate = Carbon::parse($device['last_update'], 'America/New_York');
            $devices[] = [
                'device_uuid' => $device['unique_id'],
                'product_code' => $device['product_code'],
                'device_name' => $device['device_name'],
                'device_status' => $device['device_status'],
                'assignee' => $device['assignee'],
                'last_update' =>  $lastUpdate !== '' ? $lastUpdate->toDateTimeString() : null,
            ];
        }
        info('Devices => ' . json_encode($devices));
        return view('Admin.all_devices')->with('devices', $devices);
    }

    /**
     * Show assign device view
     *
     * @return View
     */
    public function assignNewDevice(): View
    {

        return view('Admin.assign_device');
    }

    /**
     * Assign Device to agent
     *
     * @param Request $request
     * @param string  $id
     *
     * @return RedirectResponse
     */
    public function assign(Request $request, string $id): RedirectResponse
    {
        try {
            Customer::where('id', $request->input('assignee'))
                ->update([
                    'device_id' => $id,
                ]);
            return redirect()->route('all.customers');
        } catch (Exception $e) {
            error_log('AssignDevice Exception: ' . $e->getMessage());
        }
    }
}
