<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\EdTechConnect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Gate;
use Exception;

class EdTechController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless(Gate::allows('edtech_connect_create'), 403);
        if ($request->ajax()) {

            $data = EdTechConnect::orderBy('id')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-xs btn-warning btn-sm editEdTechConnect"><i class="fas fa-edit"></i></a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-xs btn-danger btn-sm deleteEdTechConnect"><i class="fas fa-trash-alt"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        define('CLIENT_ID', 'lCKbpOejfXrkUuHuxk9fMt');
        define('LINE_API_URI', 'https://notify-bot.line.me/oauth/authorize?');
        define('CALLBACK_URI', url('admin/callbacks'));

        $queryStrings = [
            'response_type' => 'code',
            'client_id' => CLIENT_ID,
            'redirect_uri' => CALLBACK_URI,
            'scope' => 'notify',
            'state' => 'abcdef123456'
        ];
        $queryString = '';
        $queryString = 'https://notify-bot.line.me/oauth/authorize?' . http_build_query($queryStrings);

        return view('admin.edtech_connects.index', compact('queryString'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(Gate::allows('edtech_connect_create'), 403);
        EdTechConnect::updateOrCreate(
            [
                'id' => $request->edtech_connect_id
            ],
            [
                'username' => $request->username,
                'department_name' => Auth::user()->department_name,
                'access_token' => $request->access_token,
                'status' => $request->status,
            ]
        );

        return response()->json(['success' => 'EdTech Connect saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(Gate::allows('edtech_connect_edit'), 403);
        $edtech_connects = EdTechConnect::find($id);
        return response()->json($edtech_connects);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(Gate::allows('edtech_connect_delete'), 403);
        EdTechConnect::find($id)->delete();

        return response()->json(['success' => 'EdTech Connect deleted successfully.']);
    }
}
