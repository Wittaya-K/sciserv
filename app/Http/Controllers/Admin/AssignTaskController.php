<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\AssignTask;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Gate;
use Exception;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class AssignTaskController extends Controller
{
	public function index(){
        $db_service_request = DB::table('service_request')->get();
        $db_username = DB::table('users')->where('username','!=',NULL)->get();
		$departments = DB::table('department')->get();

		return view('admin.assign_tasks.index',compact('db_service_request','db_username','departments'));
	}

	public function list(){
		$schedule = AssignTask::select('users.name','assign_tasks.id','service_request.service_request_name')->join('service_request','service_request.id','=','assign_tasks.service_id')
        ->join('users','users.username','=','assign_tasks.username')->groupBy('users.name','assign_tasks.id','service_request.service_request_name')->get();
		
        return response()->json(['status' => true, 'data' => $schedule ]);
	}

	public function save(Request $request, $id = ""){
		$validator = Validator::make($request->all(), [
			'username' => 'required',
			'service_id' => 'required',
		]);

		$service_id = $request->input('service_id');
		$department_id = $request->input('department_id');
		
		if(count($service_id) > 1 && $department_id != ""){
			$val_service_id = implode(',',$service_id);
			$val_department_id = implode(',',$department_id);
			if($validator->fails()){
				return response()->json(['status' => false, 'error' => $validator->errors() ]);
			}else{
			    $schedule = AssignTask::updateOrCreate(
			        [
			            'id' => $request->input('id'),
			        ],
			        [
			        'username' => $request->input('username'),
			        'service_id' => $val_service_id,
					'department_id' => $val_department_id,
			    ]);
			    if($schedule){
			        return response()->json(['status' => true, 'message' => 'บันทึกสำเร็จ!']);
			    }
			}
		} else {
			$val_service_id = implode(',',$service_id);
			$val_department_id = implode(',',$department_id);
			if($validator->fails()){
				return response()->json(['status' => false, 'error' => $validator->errors() ]);
			}else{
			    $schedule = AssignTask::updateOrCreate(
			        [
			            'id' => $request->input('id'),
			        ],
			        [
			        'username' => $request->input('username'),
			        'service_id' => $val_service_id,
					'department_id' => $val_department_id,
			    ]);
			    if($schedule){
			        return response()->json(['status' => true, 'message' => 'บันทึกสำเร็จ!']);
			    }
			}
		}
	}

	public function find($id){
		$schedule = AssignTask::findOrFail($id);
		return response()->json(['status' => true, 'data' => $schedule ]);
	}

	public function delete($id){
		$schedule = AssignTask::findOrFail($id);
		if($schedule->delete()){
			return response()->json(['status' => true, 'message' => 'Record deleted successfully!' ]);
		}
	}
}