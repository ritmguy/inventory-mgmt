<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Device;
use App\Models\Product;
use App\Models\Transaction as Log;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
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
        $agents = Agent::all();
        $product = Product::find($device['product_id']);

        return view('Admin.assign_device')
            ->with('device', $device)
            ->with('agents', $agents)
            ->with('product', $product);
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
     * Edit Device View
     *
     * @param Request $request
     * @param string  $id
     *
     * @return View
     */
    public function editDevice(Request $request, string $id): View
    {
        $device = Device::where('unique_id', $id)->first();
        $product = Product::find($device['product_id']);

        return view('Admin.edit_device')
            ->with('device', $device)
            ->with('product', $product);
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

            // Update table with new assignment
            Device::where('unique_id', $request->input('device_id'))
                ->update([
                    'is_assigned' => true,
                    'agent_id' => $request->input('agent_id'),

                ]);

            // Log Event
            $this->log('assign_device', [
                'device' => [
                    'unique_id' => $request->input('device_id'),
                    'is_assigned' => true,
                ],
                'agent' => [
                    'agent_id' => $request->input('agent_id'),
                ]
            ]);

            return redirect()->route('all.devices')->with('results', []);
        } catch (Exception $e) {
            error_log('AssignDevice Exception: ' . $e->getMessage());
            return redirect()->back()->with('results', []);
        }
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

            // Log Event
            $this->log('add_device', [
                'device' => [
                    'unique_id' => Str::uuid(),
                    'product_id' => $request->input('device_type'),
                    'device_name' => $request->input('device_name') ?? '',
                ],
                'agent' => []
            ]);

            return redirect()->route('all.devices')->with('results', []);
        } catch (Exception $e) {

            error_log('AddDevice Exception: ' . $e->getMessage());
            return redirect()->back()->with('results', json_encode(['exception' => $e->getMessage()]));
        }
    }

    /**
     * Update Device in table
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            Device::where('unique_id', $request->input('device_id'))
                ->update([
                    'device_name' => $request->input('device_name')
                ]);

            // Log Event
            $this->log('update_device', [
                'device' => [
                    'unique_id' => $request->input('device_id'),
                    'device_name' => $request->input('device_name') ?? '',
                ],
                'agent' => []
            ]);
            return redirect()->route('all.devices')->with('results', []);
        } catch (Exception $e) {
            error_log('UpdateDevice Exception: ' . $e->getMessage());
            return redirect()->back()->with('results', json_encode(['exception' => $e->getMessage()]));
        }
    }

    /**
     * Log Event
     *
     * @param string       $eventType
     * @param string|array $message
     *
     * @return void
     */
    private function log(string $eventType, string|array $message): void
    {
        try {
            Log::create([
                'transaction_id' => Str::uuid(),
                'transaction_type' => $eventType,
                'notes' => json_encode($message),
            ]);
        } catch (Exception $e) {
            error_log('LogTransaction Exception: ' . $e->getMessage());
        }
    }
}
