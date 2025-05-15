<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\RelatedDepartment;
use App\Models\Department;
use App\Models\EdTechConnect;
use App\Models\ServiceRequest;
use App\Models\RelatedServiceRequest;
use App\Models\LineSetting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Gate;
use Exception;
use App\Mail\SendEmail;
use App\Mail\JobStatus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class ScheduleController extends Controller
{
	public function index(){
        $db_category = DB::table('category')->where('status','=','1')->get();
        $db_department = Department::orderBy('id')->where('status', '=', '1')->get();
        $db_service_request = DB::table('service_request')->get();
		$db_users = DB::table('users')->whereNotNull('username')->get();

		return view('admin.schedule.index',compact('db_department','db_service_request','db_category','db_users'));
	}

	public function list(){
		$schedule = Schedule::get();
		return response()->json(['status' => true, 'data' => $schedule ]);
	}

	public function save(Request $request, $id = ""){
		$validator = Validator::make($request->all(), [
			// 'category' => 'required',
			'title' => 'required',
			'description' => 'required',
			'department' => 'required',
			'service' => 'required',
			'schedule_from' => 'required',
			'schedule_to' => 'required',
		]);

		if($validator->fails()){
			return response()->json(['status' => false, 'error' => $validator->errors() ]);
		}else{
			// $files = [];
			// if ($request->file('file')){
			// 	foreach($request->file('file') as $key => $file)
			// 	{
			// 		$fileName = time().rand(1,99).'.'.$file->extension();  
			// 		// $file->move(public_path('uploads'), $fileName);
			// 		$file->storeAs('public/uploads', $fileName);
			// 		$files[]['name'] = $fileName;
			// 	}
			// }
			// foreach ($files as $key => $file) {
				// File::create($file);
			// }
			// $file = $request->file('file');
			// $file_name = implode(',',$file);

			if($request->file('file') != null){
				$file = $request->file('file');
				// Check if multiple files are uploaded
				if (is_array($file)) {
					// Loop through each file and get the original name
					$file_names = [];
					foreach ($file as $singleFile) {
						$fileName = $singleFile->getClientOriginalName();
						$file_names[] = $singleFile->getClientOriginalName();
						// $singleFile->storeAs('public/uploads', $fileName);
						$singleFile->move(public_path('uploads'), $fileName);
					}
					// Join file names with commas if you want a single string
					$file_name = implode(',', $file_names);
				} else {
					// Single file upload
					$file_name = $file->getClientOriginalName();
				}
			} else {
				$file_name = '-';
			}

			// $file = $request->file('file'); // Assign the file to $file
			// $fileName = $file->getClientOriginalName();
			// $file->storeAs('public/uploads', $fileName);

			$service_id = $request->input('service');
			$assign_tasks = DB::table('assign_tasks')->get();
			$arr_username = [];
			foreach ($assign_tasks as $assign_tasks_item) {
				$usernames = $assign_tasks->filter(function ($item) use ($service_id){
					return in_array($service_id, explode(',', $item->service_id));
				})->pluck('username')->all();
				$arr_username = $usernames;
				// array_push($arr_username,$usernames);
			}

			$department = $request->input('department');
			$department_id = DB::table('department')->where('department_name',$department)->first();
			$department_id = $department_id->id;
			$assigntasks = DB::table('assign_tasks')->get();
			// $arrusername = [];
			foreach ($assigntasks as $assigntask) {
				$usernameDepartment = $assigntasks->filter(function ($item) use ($department_id){
					return in_array($department_id, explode(',', $item->department_id));
				})->pluck('username')->all();
				// $arr_username = $usernames;
				// array_push($arr_username,$usernames);
			}

			// เช็คว่า username มีงานที่รับผิดชอบตรงกับหลักสูตรหรือไม่
			if($arr_username[0] == $usernameDepartment[0]){
				// dd($arr_username,$usernameDepartment);
			} else {
				// dd($arr_username,$usernameDepartment);
			}

			$arr_mails = [];
			foreach ($arr_username as $arr_username_item) {
				$db_emails = DB::table('users')->where('username',$arr_username_item)->first();
				array_push($arr_mails,$db_emails->email);
			}
			
			$emails = $arr_mails;
			$schedule = Schedule::updateOrCreate(
				[
					'id' => $request->input('id'),
				],
				[
				'category' => $request->input('category'),
				'title' => $request->input('title'),
				'description' => $request->input('description'),
				'file' => $file_name,
				'department' => $request->input('department'),
				'service' => $service_id,
				'schedule_from' => $request->input('schedule_from'),
				'schedule_to' => $request->input('schedule_to'),
				'user_service_required' => $request->input('user_service_required'),
			]);

			$service_name = DB::table('service_request')->where('id','=',$service_id)->first();
			$title = $request->input('title');
			$description = $request->input('description');
			$department = $request->input('department');
			$schedule_from = $request->input('schedule_from');
			$schedule_to = $request->input('schedule_to');
			$name = Auth()->user()->name;
			$filenames = explode(',',$file_name);

			$scheduleFromDateTimeFormat = Carbon::parse($schedule_from)->format('d-m-Y H:i');
			$scheduleToDateTimeFormat = Carbon::parse($schedule_to)->format('d-m-Y H:i');

			if($schedule){
				//After job logic is complete, send the email
				$details = [
					'message'           => 'ระบบแจ้งขอใช้บริการ',
					'to'                => $name,
					'title'             => $title,
					'description'		=> $description,
					'file' 				=> 'uploads/'.$file_name,
					'department' 		=> $department,
					'service' 			=> $service_name->service_request_name,
					'schedule_from'		=> $scheduleFromDateTimeFormat,
					'schedule_to'		=> $scheduleToDateTimeFormat,
					'messageContact'    => 'หากมีข้อสงสัยเพิ่มเติม กรุณาติดต่อที่อีเมล',
					'mail'              => 'wittaya.kh@psu.ac.th',
					'regard'            => 'ขอแสดงความนับถือ',
					'itsupport'         => 'วิทยา ควรวิไลย',
					'position'          => 'นักวิชาการคอมพิวเตอร์',
					'workgroup'         => 'สาขาวิทยาศาสตร์การคำนวณ',
					'faucultySci'       => 'คณะวิทยาศาสตร์ มหาวิทยาลัยสงขลานครินทร์',
					'more'              => 'ดูรายละเอียดเพิ่มเติม',
					'tel'               => '093-639-8064',
					'cookie_policy'     => 'ข้อกำหนดการใช้งาน',
					'privacy_policy'    => 'นโยบายความเป็นส่วนตัว',
				];

				Mail::send(new SendEmail($details,$emails,$filenames));

				return response()->json(['status' => true, 'message' => 'บันทึกสำเร็จ!']);
			}
		}
	}

	public function selectdepartments(Request $request){
		$validator = Validator::make($request->all(), [
			'department' => 'required',
			'service' => 'required',
		]);

		if($validator->fails()){
			return response()->json(['status' => false, 'error' => $validator->errors() ]);
		}else{

			$service_id = $request->input('service');
			$assign_tasks = DB::table('assign_tasks')->get();
			$arr_username = [];
			foreach ($assign_tasks as $assign_tasks_item) {
				$usernames = $assign_tasks->filter(function ($item) use ($service_id){
					return in_array($service_id, explode(',', $item->service_id));
				})->pluck('username')->all();
				$arr_username = $usernames;
			}

			$department = $request->input('department');
			$department_id = DB::table('department')->where('department_name',$department)->first();
			$department_id = $department_id->id;
			$assigntasks = DB::table('assign_tasks')->get();

			foreach ($assigntasks as $assigntask) {
				$usernameDepartment = $assigntasks->filter(function ($item) use ($department_id){
					return in_array($department_id, explode(',', $item->department_id));
				})->pluck('username')->all();
			}

			// เช็คว่า username มีงานที่รับผิดชอบตรงกับหลักสูตรหรือไม่
			$users = DB::table('users')->where('username','=',$arr_username[0])->first();
			$data = [
				'status' => true,
				'message' => 'บันทึกสำเร็จ!',
				'data' => ['services' => $users->name],
			];

			return response()->json(['status' => true, 'data' => $data ]);
		}
	}

	public function find($id){
		$schedule = Schedule::findOrFail($id);
		return response()->json(['status' => true, 'data' => $schedule ]);
	}

	public function delete($id){
		$schedule = Schedule::findOrFail($id);
		if($schedule->delete()){
			return response()->json(['status' => true, 'message' => 'Record deleted successfully!' ]);
		}
	}

	public function download($id)
    {
		// Assuming you have the file path or file name based on $id
		// $filePath = storage_path("app/public/uploads/{$id}"); // Adjust path as needed
		$filePath = public_path("uploads/{$id}"); // Adjust path as needed
		// dd($filePath);
		if (!file_exists($filePath)) {
			abort(404, 'File not found');
		}
	
		// Dynamically get the MIME type
		$mimeType = mime_content_type($filePath);
	
		return Response::download($filePath, basename($filePath), [
			'Content-Type' => $mimeType,
		]);
    }

	public function job_status(Request $request)
    {
		
		$job_status = $request->input('job_status');
		$id = $request->input('dataId');
		$schedule = Schedule::updateOrCreate(
			[
				'id' => $request->input('dataId'),
			],
			[
			'job_status' => $request->input('job_status'),
		]);

		if($job_status == 'Received'){
			$message = 'รับเรื่องแล้ว';
		}
		if($job_status == 'InProcess'){
			$message = 'กำลังดำเนินการ';
		}
		if($job_status == 'Completed'){
			$message = 'เสร็จสิ้น';
		}

		$db_schedule = Schedule::where('id',$id)->first();
		$emails = DB::table('users')->where('username',$db_schedule->user_service_required)->first();
		
		$email = $emails->email;
		$name = $emails->name;
		$title = $db_schedule->title;
		$description = $db_schedule->description;
		$file_name = $db_schedule->file;
		$department = $db_schedule->department;
		$schedule_from = $db_schedule->schedule_from;
		$schedule_to = $db_schedule->schedule_to;
		$filenames = explode(',',$file_name);
		$service_name = DB::table('service_request')->where('id','=',$db_schedule->service)->first();

		$scheduleFromDateTimeFormat = Carbon::parse($schedule_from)->format('d-m-Y H:i');
		$scheduleToDateTimeFormat = Carbon::parse($schedule_to)->format('d-m-Y H:i');

		if($schedule){
			//After job logic is complete, send the email
			$details = [
				'message'           => 'ระบบแจ้งขอใช้บริการ  '. $message,
				'messageSuccess'    => $message,
				'jobStatus'         => $job_status,
				'to'                => $name,
				'title'             => $title,
				'description'		=> $description,
				'file' 				=> 'uploads/'. $file_name,
				'department' 		=> $department,
				'service' 			=> $service_name->service_request_name,
				'schedule_from'		=> $scheduleFromDateTimeFormat,
				'schedule_to'		=> $scheduleToDateTimeFormat,
				'messageContact'    => 'หากมีข้อสงสัยเพิ่มเติม กรุณาติดต่อที่อีเมล',
				'mail'              => 'wittaya.kh@psu.ac.th',
				'regard'            => 'ขอแสดงความนับถือ',
				'itsupport'         => 'วิทยา ควรวิไลย',
				'position'          => 'นักวิชาการคอมพิวเตอร์',
				'workgroup'         => 'สาขาวิทยาศาสตร์การคำนวณ',
				'faucultySci'       => 'คณะวิทยาศาสตร์ มหาวิทยาลัยสงขลานครินทร์',
				'more'              => 'ดูรายละเอียดเพิ่มเติม',
				'tel'               => '093-639-8064',
				'cookie_policy'     => 'ข้อกำหนดการใช้งาน',
				'privacy_policy'    => 'นโยบายความเป็นส่วนตัว',
			];

			Mail::send(new JobStatus($details,$email,$filenames));

			return response()->json(['status' => true, 'message' => $message]);
		}
    }

}