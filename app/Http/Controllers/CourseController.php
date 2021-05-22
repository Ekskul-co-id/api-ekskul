<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Traits\APIResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use APIResponse;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::get();
        
        return $this->response("Courses found!", $courses, 200);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'about' => 'required',
            'price' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png|max:2048',
            'silabus1' => 'required',
            'silabus2' => 'required',
            'silabus3' => 'required',
            'silabus4' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }

        $fileName = time().'.'.$request->image->extension();
        
        $path = "course";
        
        $request->image->move(public_path($path), $fileName);

        $course = Course::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'about' => $request->about,
            'price' => $request->price,
            'image' => env('APP_URL').'/'.$path.'/'.$fileName,
            'silabus1' => $request->silabus1,
            'silabus2' => $request->silabus2,
            'silabus3' => $request->silabus3,
            'silabus4' => $request->silabus4,
        ]);

        return $this->response("Course created!", $course, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::with('category', 'video')->findOrFail($id);
        
        return $this->response("Course found!", $course, 200);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'about' => 'required',
            'price' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png|max:2048',
            'silabus1' => 'required',
            'silabus2' => 'required',
            'silabus3' => 'required',
            'silabus4' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $course = Course::findOrFail($id);
        
        if($request->hasFile('image')){
            $fileName = time().'.'.$request->image->extension();
            
            $path = "course";
            
            $request->image->move(public_path($path), $fileName);
            
            unlink(public_path($path . $course->image));
            
            $image = env('APP_URL').'/'.$path.'/'.$fileName;
        }
        
        $course->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'about' => $request->about,
            'price' => $request->price,
            'image' => $image ?? $course->image,
            'silabus1' => $request->silabus1,
            'silabus2' => $request->silabus2,
            'silabus3' => $request->silabus3,
            'silabus4' => $request->silabus4,
        ]);

        return $this->response("Course updated!", $course, 201);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        
        $course->delete();
        
        return $this->response("Course deleted!", null, 201);
    }
}
