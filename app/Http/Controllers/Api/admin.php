<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class admin extends Controller
{


    /**
     * Get Customer from API
     *
     * @param Request $r
     *
     * @return JsonResponse
     */
    public function getCustomer(Request $r): JsonResponse
    {
        $customer = Customer::find($r->id);
        return response()->json([
            'customer' => $customer,
            'msg' => 'success'
        ]);
    }
}
