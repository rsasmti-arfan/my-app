<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Device;
use Illuminate\Http\Request;

class WaController extends Controller
{
    public function send(Request $request)
    {
        $ids = explode('|', $request->ids);

        $customers = Customer::whereIn('id', $ids)->get();

        $params = [];
        foreach ($customers as $key => $val) {
            $params[] = [
                'receiver' => $val->hp,
                'message' => $request->message
            ];
        }

        # curl send wa
        $sessionId = (int) Device::first()->phone;
        $url = env('NODE_WA_URL') . '/chats/send-bulk2?id=' . $sessionId;

        $res = http_request('POST', $url, json_encode($params));
        return response()->json($res);
    }
}
