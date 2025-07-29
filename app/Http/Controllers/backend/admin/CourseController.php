<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Models\Course;
use App\Models\Module;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use PDOException;
class CourseController  extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            BackendAuthenticationMiddleware::class,
            AdminAuthenticationMiddleware::class
        ];
    }

    public function course_add(Request $request)
    {
        $data = [];
        if ($request->isMethod('post')) {
         
            $request->validate([
            'course_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required',
            'price' => 'nullable|numeric|min:0',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'modules' => 'required|array|min:1',
            'modules.*.title' => 'required|string|max:255',
            'modules.*.contents' => 'required|array|min:1',
            'modules.*.contents.*.title' => 'required|string|max:255',
            'modules.*.contents.*.content_type' => 'required|in:video,audio,pdf,image,text',
            'modules.*.contents.*.content_url' => 'nullable|string',
            'modules.*.contents.*.content_text' => 'nullable|string',
            
        ]);
         
            $photo  = $request->file('photo');
            
            $photo_extension = $photo->getClientOriginalExtension();
            $photo_name = 'backend_assets/images/courses/'.uniqid().'.'.$photo_extension;
            $image = Image::make($photo);
            $image->resize(645,420);
            $image->save($photo_name);
             
            try {
               $course= Course::create([
                    'course_title' => $request->course_title,
                    'description' => $request->description,
                    'thumb' => $photo_name,
                    'video_trailer' => $request->video_trailer,
                    'price' => $request->price,
                    'category_id'=>$request->category_id,
                    'created_by' => Auth::user()->id,
                   
                ]);
                foreach ($request->modules as $moduleData) {
                $module=Module::create([
                    'module_title' => $moduleData['title'],
                    'course_id'=>$course->id,
                    'created_by' => Auth::user()->id,
                ]);

                foreach ($moduleData['contents'] as $contentData) {
                    Content::create([
                        'content_title' => $contentData['title'],
                        'content_type' => $contentData['content_type'],
                        'content_url' => $contentData['content_url'],
                        'content_text' => $contentData['content_text'],
                         'module_id'=>$module->id,
                        'created_by' => Auth::user()->id,
                    ]);
                }
            }
                return back()->with('success', 'Added Successfully');
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try Again'. $e);
            }
        }
        $data['category']= DB::table('categories')->select('id', 'title')->get();
        $data['active_menu'] = 'course_add';
        $data['page_title'] = 'Course Add';
        return view('backend.admin.pages.course_add', compact('data'));
    }

    public function course_list()
    {
        $data = [];
        $data['course_list'] = Course::with(['category'])->orderByDesc('id')->get();

        $data['active_menu'] = 'course_list';
        $data['page_title'] = 'Course List';
        return view('backend.admin.pages.course_list', compact('data'));
    }
    public function course_delete($id)
    {
        $server_response =  ['status' => 'FAILED', 'message' => 'Not Found'];
        $course = Course::find($id);
        if ($course) {
                 $modules = Module::where('course_id', $course->id)->get();

        foreach ($modules as $module) {
            // Delete contents inside each module
            Content::where('module_id', $module->id)->delete();
            $module->delete();
        }
            if(File::exists($course->thumb)){
                  File::delete($course->thumb);
            }
            $course->delete();
            $server_response =  ['status' => 'SUCCESS', 'message' => 'Deleted Successfully'];
        } else {
            $server_response =  ['status' => 'FAILED', 'message' => 'Not Found'];
        }
        echo json_encode($server_response);
    }
}