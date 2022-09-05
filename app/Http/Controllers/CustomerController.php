<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Device;
use App\Models\Message;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use DB;
use Illuminate\Support\Carbon;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('customers');
            // $data->orderBy('customers.updated_at', 'DESC');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    $checkbox = '<div class="custom-control custom-checkbox">';
                    $checkbox .= '<input type="checkbox" class="sub_chk custom-control-input" id="customer-' . $row->id . '" data-id="' . $row->id . '">';
                    $checkbox .= '<label class="custom-control-label" for="customer-' . $row->id . '"></label>';
                    $checkbox .= '</div>';
                    return $checkbox;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Show" class="show btn btn-primary btn-sm showData"><i class="far fa-eye"></i></a>';
                    $btn .= '&nbsp;';
                    $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-info btn-sm editData"><i class="far fa-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteData"><i class="far fa-trash-alt"></i> </a>';
                    return $btn;
                })
                ->rawColumns(['action', 'checkbox'])
                ->make(true);
        }

        return view('customer.index', [
            'templates' => Message::where('is_auto', '0')->get()
        ]);
    }

    public function store(Request $request)
    {
        if ($request->id == null) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'gender' => 'required',
                'email' => 'required',
                'hp' => 'required',
            ]);
        }
        if ($request->id != null) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'gender' => 'required',
                'email' => 'required',
                'hp' => 'required',
            ]);
        }
        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $customer = Customer::updateOrCreate(
                ['id' => $request->id],
                [
                    'name' => $request->name,
                    'address' => $request->address,
                    'gender' => $request->gender,
                    'email' => $request->email,
                    'hp' => phone_number($request->hp),
                ]
            );

            if ($customer->wasRecentlyCreated) {
                // on save
                $sendWa = $this->_sendWa($request); // send wa to saved customers
            } else {
                // on update
                $sendWa = null;
            }

            $save = true;
            if ($save) {
                return response()->json(['status' => 1, 'response' => $sendWa]);
            }
        }
    }

    public function edit($id)
    {
        $data = Customer::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        Customer::find($id)->delete();
    }

    /**
     * send whatsapp message
     * @param object $request
     */
    private function _sendWa($request)
    {
        $message = Message::where('is_auto', '1')->first()->message;

        $arrayDataSet = $this->_replaceArray([
            'name'       => $request->name,
            'address'    => $request->address,
            'gender'     => $request->gender,
            'email'      => $request->email,
            'hp'         => '+' . phone_number($request->hp),
            'created_at' => date_id(Carbon::now()) . ' - ' . time_id(Carbon::now()),
            'updated_at' => date_id(Carbon::now()) . ' - ' . time_id(Carbon::now()),
        ]);

        $convertedMsg = $this->_replaceKeywordMessage($arrayDataSet, $message);

        # curl send wa
        $params = [
            'receiver' => phone_number($request->hp),
            'message' => $convertedMsg
        ];

        $sessionId = (int) Device::first()->phone;
        $url = env('NODE_WA_URL') . '/chats/send?id=' . $sessionId;

        return http_request('POST', $url, json_encode($params));
    }

    /** replace array */
    private function _replaceArray($oldArray, $newArray = [], $theKey = null)
    {
        foreach ($oldArray as $key => $value) {
            if (is_array($value)) {
                $newArray = array_merge($newArray, replaceArray($value, $newArray, $key));
            } else {
                if (!is_null($theKey)) $key = $theKey . "." . $key;
                $newArray["{" . $key . "}"] = $value;
            }
        }
        return $newArray;
    }

    /**
     * replace msg autoreplay with keyword
     * @param array $array : dataset replace
     * @param string $string : find key in string
     */
    private function _replaceKeywordMessage($array, $string)
    {
        return str_replace(array_keys($array), array_values($array), $string);
    }
}
