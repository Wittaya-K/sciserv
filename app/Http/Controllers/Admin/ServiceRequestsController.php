<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ServiceRequestsController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless(Gate::allows('service_request_access'), 403);

        $tbl_departments = Department::orderBy('id')->get(); //ดึงข้อมูลจากตาราง tbl_departments มาแสดง
        // if ($request->ajax()) {
  
        //     $data = ServiceRequest::orderBy('id')->get();
            
        //     return Datatables::of($data)
        //             ->addIndexColumn()
        //             ->addColumn('action', function($row){
   
        //                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-xs btn-warning btn-sm editServiceRequest"><i class="fas fa-edit"></i></a>';
   
        //                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-xs btn-danger btn-sm deleteServiceRequest"><i class="fas fa-trash-alt"></i></a>';
    
        //                     return $btn;
        //             })
        //             ->rawColumns(['action'])
        //             ->make(true);
        // }
        
        // return view('admin.service_requests.index',compact('tbl_departments'));

            if ($request->ajax()) {
                $data = ServiceRequest::orderBy('id')->get();
                $result = [];
                $index = 1;

                foreach ($data as $row) {
                    $result[] = [
                        'id' => $row->id,
                        'service_request_name' => $row->service_request_name,
                        'department_id'=> $row->department_id,
                        'department_name' => $row->department_name,
                        'action' => '
                            <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-xs btn-warning btn-sm editDepartment">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-xs btn-danger btn-sm deleteDepartment">
                                <i class="fas fa-trash-alt"></i>
                            </a>'
                    ];
                }

                return response()->json(['data' => $result]);
            }

            // ถ้าไม่ใช่ AJAX request ให้แสดงหน้า view ปกติ
            return view('admin.service_requests.index',compact('tbl_departments'));
    }
       
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(Gate::allows('service_request_create'), 403);
        // ServiceRequest::updateOrCreate([
        //             'id' => $request->service_request_id
        //         ],
        //         [
        //             'service_request_name' => $request->service_request_name,
        //             'department_name' => $request->department_name,
        //         ]);        
     
        // return response()->json(['success'=>'ServiceRequests saved successfully.']);

        $validator = Validator::make($request->all(), [
			'service_request_name' => 'required',
			'department_id' => 'required',
		]);

		$department_id = $request->input('department_id');
		if(count($department_id) > 1){
			$val_department_id = implode(',',$department_id);
			if($validator->fails()){
				return response()->json(['status' => false, 'error' => $validator->errors() ]);
			}else{
			    $schedule = ServiceRequest::updateOrCreate(
			        [
			            'id' => $request->input('service_request_id'),
			        ],
			        [
                    'service_request_name' => $request->service_request_name,
                    'department_id' => $val_department_id,
                    'department_name' => $request->department_name,
			    ]);
			    if($schedule){
			        return response()->json(['status' => true, 'message' => 'บันทึกสำเร็จ!']);
			    }
			}
		} else {
			$val_department_id = implode(',',$department_id);
			if($validator->fails()){
				return response()->json(['status' => false, 'error' => $validator->errors() ]);
			}else{
			    $schedule = ServiceRequest::updateOrCreate(
			        [
			            'id' => $request->input('service_request_id'),
			        ],
			        [
                    'service_request_name' => $request->service_request_name,
                    'department_id' => $val_department_id,
                    'department_name' => $request->department_name,
			    ]);
			    if($schedule){
			        return response()->json(['status' => true, 'message' => 'บันทึกสำเร็จ!']);
			    }
			}
		}
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceRequests  $service_request
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(Gate::allows('service_request_edit'), 403);
        $service_request = ServiceRequest::find($id);
        return response()->json($service_request);
    }
    
    public function find($id){
		$schedule = ServiceRequest::findOrFail($id);
		return response()->json(['status' => true, 'data' => $schedule ]);
	}
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceRequests  $service_request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(Gate::allows('service_request_delete'), 403);
        ServiceRequest::find($id)->delete();
      
        return response()->json(['success'=>'ServiceRequests deleted successfully.']);
    }
}
