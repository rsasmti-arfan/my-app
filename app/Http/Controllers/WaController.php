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

        $res = $this->curl_request('POST', $url, json_encode($params));
        return response()->json($res);
    }


    /** CURL */
    public function curl_request($method, $url, $data = [])
    {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        // 'authorization: ' . config('message.token'),
        // 'cache-control: no-cache',
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure");
        }
        curl_close($curl);
        return json_decode($result, true);
    }
}
