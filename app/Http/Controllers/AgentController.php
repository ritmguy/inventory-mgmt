<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Device;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTimeZone;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AgentController extends Controller
{


    /**
     * Create agent before assigning devices
     *
     * @return View
     */
    public function create(): View
    {
        return view('Admin.create_agent');
    }

    public function view(): View
    {
        $customers = Agent::all();
        return view('Admin.all_agents', compact('customers'));
    }

    public function edit(Request $request, $id): View
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
