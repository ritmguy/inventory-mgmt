<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Device;
use App\Models\Agent;
use Carbon\Carbon;
use DateTimeZone;
use DateTime;
use Exception;
use Illuminate\Http\RedirectResponse;
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
            'is_assigned',
            'devices.updated_at as last_update',
            'unique_id'
        )
            ->leftJoin('products', 'devices.product_id', '=', 'products.id')
            ->orderBy('devices.updated_at', 'desc')
            ->get();

        foreach ($rs as $device) {
            $lastUpdate = Carbon::parse($device['last_update'], 'America/New_York');
            $devices[] = [
                'device_uuid' => $device['unique_id'],
                'product_code' => $device['product_code'],
                'device_name' => $device['device_name'],
                'device_status' => $device['device_status'],
                'is_assigned' => $device['is_assigned'],
                'last_update' =>  $lastUpdate !== '' ? $lastUpdate->toDateTimeString() : null,
            ];
        }

        return view('Admin.all_devices')->with('devices', $devices);
    }

    /**
     * Show assign device view
     *
     * @param Request $request
     * @param string  $id
     *
     * @return View
     */
    public function assignNewDevice(Request $request, string $id): View
    {
        $device = Device::where('unique_id', $id)->first();

        return view('Admin.assign_device')->with('device', $device);
    }

    /**
     * Assign Device to agent
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function assign(Request $request): RedirectResponse
    {
        try {
            Agent::where('id', $request->input('assignee'))
                ->update([
                    'device_id' => $request->input('device_id'),
                ]);
            return redirect()->route('all.agents')->with('results', []);
        } catch (Exception $e) {
            error_log('AssignDevice Exception: ' . $e->getMessage());
            return redirect()->back()->with('results', []);
        }
    }

    /**
     * Add New devices view
     *
     * @return View
     */
    public function addDevice(): View
    {
        $categories = Product::all();

        return view('Admin.add_device')->with('category', $categories);
    }

    /**
     * Return available devices view
     *
     * @return View
     */
    public function availableDevices(): View
    {

        $devices = Device::where('is_assigned', false)
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('Admin.all_devices')->with('devices', $devices);
    }

    /**
     * Add new device to system
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        try {

            Device::create(
                [
                    'unique_id' => Str::uuid(),
                    'product_id' => $request->input('device_type'),
                    'device_name' => $request->input('device_name') ?? '',
                    'device_status' => 'instock'
                ]
            );
            return redirect()->route('all.devices')->with('results', []);
        } catch (Exception $e) {

            error_log('AddDevice Exception: ' . $e->getMessage());
            return redirect()->back()->with('results', json_encode(['exception' => $e->getMessage()]));
        }
    }
}
