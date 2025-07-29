<?php

namespace App\Http\Controllers\backend\admin;


use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use PDOException;

class CategoryController extends Controller implements HasMiddleware
{
    //
    public static function middleware(): array
    {
        return [
            BackendAuthenticationMiddleware::class,
            AdminAuthenticationMiddleware::class
        ];
    }
    public function category_add(Request $request)
    {
       
        if ($request->isMethod('post')) {
         //dd($request->all());
               
             
            try {
               Category::create([
                   
                    'title' => $request->title,
                    'created_by' => Auth::user()->id,
                ]);
                return back()->with('success', 'Added Successfully');
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try Again');
            }
        }
    
    }

    public function category_edit(Request $request)
    {
        $data = [];
        $id=$request->edit_id;
     
        $data['category'] =Category::find($id);
        if ($request->isMethod('post')) {
       
            try {
                $data['category']->update([
                    'title' => $request->edit_title,
                    
                    
                ]);
                return back()->with('success', 'Updated Successfully');
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try Again');
            }
        }
       
        return view('backend.pages.category_list', compact('data'));
    }
    public function category_list()
    {
        $data = [];
        $data['category_list'] = DB::table('categories')->select('id','title')->orderByDesc('id')->get();
        $data['active_menu'] = 'category_list';
        $data['page_title'] = 'Category List';
        return view('backend.admin.pages.category_list', compact('data'));
    }


    public function category_delete($id)
    {
        $server_response =  ['status' => 'FAILED', 'message' => 'Not Found'];
        $category =Category::find($id);
        if ($category) {

            $category->delete();
            $server_response =  ['status' => 'SUCCESS', 'message' => 'Deleted Successfully'];
        } else {
            $server_response =  ['status' => 'FAILED', 'message' => 'Not Found'];
        }
        echo json_encode($server_response);
    }

}
