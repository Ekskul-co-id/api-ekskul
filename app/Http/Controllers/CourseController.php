<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
        $courses = Course::with('category', 'mentor')->get();

        return $this->response('Courses found!', $courses, 200);
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
            'user_id' => 'required|integer',
            'about' => 'required',
            'price' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png|max:2048',
            'silabus' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }

        $fileName = time().'.'.$request->image->extension();

        $path = 'course';

        $request->image->move(public_path($path), $fileName);

        $course = Course::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'about' => $request->about,
            'price' => $request->price,
            'image' => env('APP_URL').'/'.$path.'/'.$fileName,
            'silabus' => $request->silabus,
        ]);

        return $this->response('Course created!', $course, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $course->load('category', 'mentor', 'totalDurations', 'playlist.playlistDurations', 'playlist.video');

        return $this->response('Course found!', $course, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'user_id' => 'required|integer',
            'about' => 'required',
            'price' => 'required',
            'image' => 'mimes:jpeg,jpg,png|max:2048',
            'silabus' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }

        if ($request->hasFile('image')) {
            $fileName = time().'.'.$request->image->extension();

            $path = 'course';

            $request->image->move(public_path($path), $fileName);

            unlink(public_path($path.$course->image));

            $image = env('APP_URL').'/'.$path.'/'.$fileName;
        }

        $course->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'about' => $request->about,
            'price' => $request->price,
            'image' => $image ?? $course->image,
            'silabus' => $request->silabus,
        ]);

        return $this->response('Course updated!', $course, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return $this->response('Course deleted!', null, 201);
    }
}
