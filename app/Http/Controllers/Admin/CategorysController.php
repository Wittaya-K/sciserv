<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class CategorysController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless(Gate::allows('category_access'), 403);
        if ($request->ajax()) {
  
            $data = Category::orderBy('id')->get();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-xs btn-warning btn-sm editCategory"><i class="fas fa-edit"></i></a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-xs btn-danger btn-sm deleteCategory"><i class="fas fa-trash-alt"></i></a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.categorys.index');
    }
       
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(Gate::allows('category_create'), 403);
        Category::updateOrCreate([
                    'id' => $request->category_id
                ],
                [
                    'user_id' => Auth::user()->id,
                    'name' => $request->name,
                    'status' => $request->status,
                ]);        
     
        return response()->json(['success'=>'Category saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(Gate::allows('category_edit'), 403);
        $product = Category::find($id);
        return response()->json($product);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(Gate::allows('category_delete'), 403);
        Category::find($id)->delete();
      
        return response()->json(['success'=>'Category deleted successfully.']);
    }
}
