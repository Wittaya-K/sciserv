<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Gate;

class DepartmentsController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless(Gate::allows('department_access'), 403);
        if ($request->ajax()) {
  
            $data = Department::orderBy('id')->get();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-xs btn-warning btn-sm editDepartment"><i class="fas fa-edit"></i></a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-xs btn-danger btn-sm deleteDepartment"><i class="fas fa-trash-alt"></i></a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.departments.index');
    }
       
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(Gate::allows('department_create'), 403);
        Department::updateOrCreate([
                    'id' => $request->department_id
                ],
                [
                    'department_name' => $request->department_name,
                    'group_name' => $request->group_name,
                    'status' => $request->status,
                ]);        
     
        return response()->json(['success'=>'Department saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(Gate::allows('department_edit'), 403);
        $department = Department::find($id);
        return response()->json($department);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(Gate::allows('department_delete'), 403);
        Department::find($id)->delete();
      
        return response()->json(['success'=>'Department deleted successfully.']);
    }
}
