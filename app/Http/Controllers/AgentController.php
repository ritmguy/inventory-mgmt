<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Device;
use App\Models\Product;
use App\Models\Transaction as Log;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AgentController extends Controller
{


    /**
     * Create agent view
     *
     * @return View
     */
    public function create(): View
    {
        return view('Admin.create_agent');
    }

    /**
     * Show all agents view
     *
     * @return View
     */
    public function view(): View
    {
        $agents = Agent::all();

        foreach ($agents as $agent) {
            $devices = Device::where('is_assigned', true)
                ->where('agent_id', $agent['id'])
                ->count();

            $out[] = [
                'name' => $agent['first_name'] . ' ' . $agent['last_name'],
                'address' => $agent['address1'] . ' ' . $agent['address_city'] . ', ' . $agent['address_state'] . ' ' . $agent['address_zip'],
                'phone' => phone($agent['phone_number'], 'US', 'NATIONAL'),
                'updated_at' => $agent['updated_at'],
                'id' => $agent['id'],
                'device_count' => $devices,
            ];
        }

        return view('Admin.all_agents')
            ->with('agents', $out);
    }

    /**
     * Edit agent view with assigned devices
     *
     * @param Request $request
     * @param string  $id
     *
     * @return View
     */
    public function edit(Request $request, string $id): View
    {
        $agent = Agent::find($id);
        $devices = Device::where('agent_id', $id)->get();
        $out = [];
        $agentPhone = phone($agent->phone_number, 'US', 'NATIONAL');

        foreach ($devices as $device) {
            $product = Product::find($device['product_id']);

            $out[] = [
                'product_name' => $product->name,
                'product_code' => $product->product_code,
                'device_name' => $device['device_name'],
                'device_type' => $product->category,
                'device_id' => $device['unique_id'],
            ];
        }

        return view('Admin.edit_agent', compact('agent'))
            ->with('devices', $out)
            ->with('agent_phone', $agentPhone);
    }

    /**
     * Edit agent in table
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {

        $phone = $this->cleanInputString($request->input('phone_number'));

        $data = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone_number' => $phone,
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2'),
            'address_city' => $request->input('address_city'),
            'address_state' => $request->input('address_state'),
            'address_zip' => $request->input('address_zip'),
            'is_active' => $request->input('active') === true ? true : false,
        ];

        Agent::where('id', $request->input('agentId'))
            ->update($data);

        // Log Event
        $this->log('edit_agent', [
            'device' => [],
            'agent' => $data
        ]);

        return redirect()->route('all.agents');
    }

    /**
     * Create agent in table
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function createAgent(Request $request): RedirectResponse
    {

        $phone = $this->cleanInputString($request->input('phone'));

        $data = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone_number' => $phone,
            'address1' => $request->input('address1') ?? null,
            'address2' => $request->input('address2') ?? null,
            'address_city' => $request->input('address_city') ?? null,
            'address_state' => $request->input('address_state') ?? null,
            'address_zip' => $request->input('address_zip') ?? null
        ];

        Agent::create($data);

        // Log Event
        $this->log('add_agent', [
            'device' => [],
            'agent' => $data
        ]);

        return redirect()->route('all.agents');
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

    /**
     * Cleanup special/unwanted chars from string
     *
     * @param string $input
     *
     * @return string
     */
    private function cleanInputString(string $input): string
    {
        $input = preg_replace('/\s+|\(|\)|-|\+/', '', $input);
        $input = filter_var($input, FILTER_SANITIZE_STRING);
        return (string) $input;
    }
}
