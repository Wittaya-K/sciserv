<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Models\RelatedDepartment;
use App\Models\Department;
use App\Models\ServiceRequest;
use App\Models\RelatedServiceRequest;
use App\User;
use App\Models\Schedule;

class HomeController
{
    public function index()
    {
        $schedule = Schedule::get();

        $db_category = DB::table('category')->get();
        $db_department = Department::orderBy('id')->where('status', '=', '1')->get();
        $db_service_request = DB::table('service_request')->get();

        $category_names = DB::table('category')
                            ->select('category.name','category.id')
                            ->get(); //หมวดหมู่
        
        $tbl_related_departments = RelatedDepartment::orderBy('id')->get(); //ดึงข้อมูลจากตาราง tbl_related_departments มาแสดง
        $tbl_departments = Department::orderBy('id')->where('status','=','1')->get(); //ดึงข้อมูลจากตาราง tbl_departments มาแสดง
        
        $date_today = date("Y-m-d"); //วันที่ปัจจุบัน
        $all_of_jobs = Schedule::count(); //จำนวนรายการหมวดหมู่ทั้งหมด
        $today_jobs = DB::table('schedule')->whereDate('schedule_from','=',$date_today)->count(); //จำนวนรายการตารางงานประจำวันนี้
        $coming_jobs = DB::table('schedule')->whereDate('schedule_from','>',$date_today)->count(); //จำนวนรายการงานตามกำหนดการที่กำลังจะมาถึง
        $categorys = DB::table('category')->get();
        $service_request = ServiceRequest::orderBy('id')->get();
        $tbl_related_service_requests = RelatedServiceRequest::orderBy('id')->get(); //ดึงข้อมูลจากตาราง tbl_related_service_requests มาแสดง
        $tbl_users = User::orderBy('id')->count(); //ดึงข้อมูลจากตาราง tbl_related_service_requests มาแสดง

        return view('home',compact('schedule','category_names','all_of_jobs','today_jobs','coming_jobs','categorys','tbl_departments','tbl_related_departments','service_request','tbl_related_service_requests','tbl_users','db_department','db_service_request','db_category'));
    }
}
