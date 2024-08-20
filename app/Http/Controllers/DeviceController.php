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
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DeviceController extends Controller
{

    private const PRODUCT_CATEGORY = ['Laptop', 'Headset', 'Keyboard', 'Mouse'];


    /**
     * Get all devices from db for databale
     *
     * @return View
     */
    public function allDevices(): View
    {

        $devices = Device::select(
            'products.product_code',
            'device_name',
            'device_status',
            'is_assigned',
            'category',
            'devices.updated_at as last_update',
            'unique_id'
        )
            ->leftJoin('products', 'devices.product_id', '=', 'products.id')
            ->orderBy('devices.updated_at', 'desc')
            ->get();


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

        // Check for current assignment
        $currentAgentAr = Agent::find($device['agent_id']);
        if (!empty($currentAgentAr) && $currentAgentAr !== null) {
            $currentAgent = $currentAgentAr['first_name'] . ' ' . $currentAgentAr['last_name'] ?? null;
        } else {
            $currentAgent = '';
        }
        $product = Product::find($device['product_id']);

        $history = $this->getDeviceHistory($id);

        return view('Admin.assign_device')
            ->with('device', $device)
            ->with('agents', $agents)
            ->with('product', $product)
            ->with('current_agent', $currentAgent)
            ->with('history', $history);
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
     * Return view to add new product/model
     *
     * @return View
     */
    public function addNewProduct(): View
    {
        return view('Admin.add_product')->with('category', self::PRODUCT_CATEGORY);
    }

    /**
     * Return view of all products
     *
     * @return View
     */
    public function getAllProducts(): View
    {
        $productCounts = [];

        $devices = Device::selectRaw('product_id,
        count(*) as total_count,
        sum(case when is_assigned=1 then 1 else 0 end) as assigned, 
        sum(case when is_assigned=0 then 1 else 0 end) as unassigned')
            ->groupBy('product_id')
            ->get();

        foreach ($devices as $device) {
            $prod = Product::find($device['product_id']);
            $productCounts[] = [
                'category' => $prod->category,
                'name' => $prod->name,
                'code' => $prod->product_code,
                'assigned' => $device->assigned,
                'unassigned' => $device->unassigned,
                'totals' => $device->total_count,
                'last_update' => Carbon::parse($prod->updated_at)->tz('America/New_York')->toDateTimeString(),
            ];
        }

        return view('Admin.all_products')
            ->with('products', $productCounts);
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
                    'device_status' => 'assigned'

                ]);

            // Log Event
            $this->log('assign_device', [
                'device' => [
                    'unique_id' => $request->input('device_id'),
                    'is_assigned' => true,
                    'devcie_status' => 'assigned'
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
     * Unassign device from agent
     *
     * @param Request $request
     * @param string  $id
     *
     * @return RedirectResponse
     */
    public function unassign(Request $request, string $id): RedirectResponse
    {
        try {
            $device = Device::where('unique_id', $id)->get()->first();
            $agent = Agent::find($device['agent_id']);

            Device::where('unique_id', $id)
                ->update([
                    'is_assigned' => false,
                    'agent_id' => null,
                    'device_status' => 'instock'
                ]);

            // Log Event
            $this->log('unassign_device', [
                'device' => [
                    'unique_id' => $id,
                    'device_name' => $device['name'] ?? '',
                    'is_assigned' => false,
                    'device_status' => 'instock'
                ],
                'agent' => [
                    'previous_agent_id' => $agent['id'],
                    'agent_fname' => $agent['first_name'],
                    'agent_lname' => $agent['last_name']
                ]
            ]);
            return redirect()->route('all.devices')->with('results', []);
        } catch (Exception $e) {
            error_log('UnassignDevice Exception: ' . $e->getMessage());
            return redirect()->back()->with('results', json_encode(['exception' => $e->getMessage()]));
        }
    }

    /**
     * Create new product/device model in table
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function addProduct(Request $request): RedirectResponse
    {

        Product::create(
            [
                'product_code' => $request->input('code'),
                'name' => $request->input('name'),
                'category' => $request->input('category'),
                'stock' => 0,
                'unit_price' => $request->input('unit_cost'),
                'sales_unit_price' => 0
            ]
        );

        // Log Event
        $this->log('add_product', [
            'device' => [
                'product_code' => $request->input('code'),
                'name' => $request->input('name'),
                'category' => $request->input('category'),
                'unit_price' => $request->input('unit_cost'),
            ],
            'agent' => []
        ]);
        return redirect()->route('all.devices')->with('results', []);
    }

    private function getDeviceHistory(string $id): array
    {
        $logs = Log::where('transactions.notes->device->unique_id', $id)
            ->leftJoin('users', 'users.id', '=', 'transactions.user_id')
            ->orderBy('transactions.created_at', 'desc')
            ->limit(25)
            ->get()
            ->toArray();

        return $logs;
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
                'user_id' => Auth::id()
            ]);
        } catch (Exception $e) {
            error_log('LogTransaction Exception: ' . $e->getMessage());
        }
    }
}
