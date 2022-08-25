<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Message;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use DB;


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
            'templates' => Message::all()
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
            Customer::updateOrCreate(
                ['id' => $request->id],
                [
                    'name' => $request->name,
                    'address' => $request->address,
                    'gender' => $request->gender,
                    'email' => $request->email,
                    'hp' => phone_number($request->hp),
                ]
            );
            $save = true;
            if ($save) {
                return response()->json(['status' => 1,]);
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
}
