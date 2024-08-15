<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Device;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
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
        $customers = Agent::all();
        return view('Admin.all_agents', compact('customers'));
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

        foreach ($devices as $device) {
            $product = Product::find($device['product_id']);

            $out[] = [
                'product_name' => $product->name,
                'product_code' => $product->product_code,
                'device_name' => $device['device_name'],
                'device_type' => $product->category,
            ];
        }

        return view('Admin.edit_agent', compact('agent'))->with('out', $out);
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
        Agent::where('id', $request->input('agentId'))
            ->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'phone_number' => $request->input('phone'),
                'address1' => $request->input('address1'),
                'address2' => $request->input('address2'),
                'address_city' => $request->input('address_city'),
                'address_state' => $request->input('address_state'),
                'address_zip' => $request->input('address_zip'),
                'is_active' => $request->input('active') === true ? true : false,
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
        Agent::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone_number' => $request->input('phone'),
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2'),
            'address_city' => $request->input('address_city'),
            'address_state' => $request->input('address_state'),
            'address_zip' => $request->input('address_zip')
        ]);
        return redirect()->route('all.agents');
    }
}
