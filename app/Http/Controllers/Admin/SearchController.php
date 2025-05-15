<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Department;
use App\Models\ServiceRequest;
use App\User;
use Carbon\Carbon;

class SearchController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('search_access'), 403);
        
        $schedules = Schedule::select(DB::raw('DATE_FORMAT(schedule_from, "%d-%m-%Y") as schedule_from'))->get();
        $departments = Department::orderBy('id')->get(); 
        $serviceRequests = ServiceRequest::orderBy('id')->get();
        $users = User::orderBy('id')->whereNotNull('username')->get();

        return view('admin.search.index', compact('schedules','departments','serviceRequests','users'));
    }
    public function search(Request $request)
    {
        $query = Schedule::query();

        if ($request->has('schedule_from')) {
            $scheduleFrom = Carbon::createFromFormat('d-m-Y', $request->schedule_from)->format('Y-m-d');
            $query->where('schedule_from', 'LIKE', '%' . $scheduleFrom . '%');
        }

        if ($request->has('field_of_study')) {
            $query->where('department', 'LIKE', '%' . $request->field_of_study . '%');
        }

        if ($request->has('job')) {
            $query->where('service', 'LIKE', '%' . $request->job . '%');
        }

        if ($request->has('staff')) {
            $query->where('user_service_required', 'LIKE', '%' . $request->staff . '%');
        }
        
        // $providers = $query->paginate(10);
        $providers = $query->get();
        return response()->json($providers);
    }
}