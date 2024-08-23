<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Device;
use App\Models\Product;
use App\Models\Status;
use App\Models\Transaction as Log;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConsoleController extends Controller
{


    /**
     * Render dashboard
     *
     * @param Request $request
     *
     * @return View
     */
    public function dashboard(Request $request): View
    {
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

        $transactions = Log::select('transaction_type', 'user_id', 'users.name as user_name', 'notes', 'transactions.updated_at')
            ->leftJoin('users', 'users.id', '=', 'transactions.user_id')
            ->orderBy('updated_at', 'desc')
            ->limit(100)
            ->get();

        return view('admin-dashboard')
            ->with('transactions', $transactions)
            ->with('devices', $deviceCounts);
    }

    /**
     * Render add system status view
     *
     * @return View
     */
    public function addStatusView(): View
    {
        $statusCategories = ['Agent', 'Device'];

        return view('Admin.add_status')
            ->with('types', $statusCategories);
    }

    public function allStatuses(): View
    {

        $statuses = Status::all();
        return view('Admin.all_statuses')
            ->with('statuses', $statuses);
    }

    /**
     * Create new system status
     *
     * @param Request $request
     *
     * @return View|RedirectResponse
     */
    public function createStatus(Request $request): View|RedirectResponse
    {
        if (Status::where('name', $request->input('statusName'))->exists()) {
            return redirect()->back();
        }

        Status::create([
            'type' => Str::lower($request->input('statusType')),
            'name' => Str::title($request->input('statusName')),
        ]);

        // Log Event
        $this->log('add_status', [
            'device' => [],
            'agent' => [],
            'message' => [
                'type' => Str::lower($request->input('statusType')),
                'name' => Str::title($request->input('statusName')),
            ]
        ]);

        return redirect()->route('all.statuses');
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
