<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\Checkout;
use App\Models\Course;
use App\Models\Playlist;
use App\Models\Rating;
use App\Models\Video;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    use APIResponse;
    
    public function listCategory()
    {
        $categories = Category::paginate(10);
        
        return $this->response("Categories found!", $categories, 200);
    }
    
    public function detailCategory($slug)
    {
        $userId = Auth::user()->id;
        
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $hasPurchased = Checkout::where(['status' => 'success', 'user_id' => $userId])->get()
            ->pluck('course_id')->toArray();
        
        $courses = Course::with('category', 'totalDurations')->addSelect([
            'rating' => Rating::selectRaw('avg(value) as total')
                ->whereColumn('course_id', 'courses.id')
                ->groupBy('course_id'),
            'user_rated' => Rating::selectRaw('count(value) as total')
                ->whereColumn('course_id', 'courses.id')
                ->groupBy('course_id'),
            'course_sold' => Checkout::selectRaw('count(id) as total')
                ->whereColumn('course_id', 'courses.id')
                ->groupBy('course_id')
            ])
            ->where('category_id', $category->id)
            ->paginate(10);
        
        $data = [
            'course' => $courses,
            'has_purchased' => $hasPurchased
        ];
        
        return $this->response("Category found!", $data, 200);
    }
    
    public function listCourse(Request $request)
    {
        $userId = Auth::user()->id;
        
        $hasPurchased = Checkout::where(['status' => 'success', 'user_id' => $userId])->get()
            ->pluck('course_id')->toArray();
        
        $value = e($request->get('q'));
        
        $idPlaylists = DB::table('playlists')->join('courses', 'playlists.course_id', '=', 'courses.id')
            ->select('playlists.id')->get()->toArray();
        
        $courses = Course::with('category', 'totalDurations')->addSelect([
            'rating' => Rating::selectRaw('avg(value) as total')
                ->whereColumn('course_id', 'courses.id')
                ->groupBy('course_id'),
            'user_rated' => Rating::selectRaw('count(value) as total')
                ->whereColumn('course_id', 'courses.id')
                ->groupBy('course_id'),
            'course_sold' => Checkout::selectRaw('count(id) as total')
                ->whereColumn('course_id', 'courses.id')
                ->groupBy('course_id'),
            ]);
            
        if (!empty($value)) {
            $result = $courses->where('name', 'LIKE', '%'.$value.'%')->paginate(10);
        } else {
            $result = $courses->paginate(10);
        }
        
        $data = [
            'courses' => $result,
            'has_purchased' => $hasPurchased,
            'search' => $value,
        ];
        
        return $this->response("Courses found!", $data, 200);
    }
    
    public function popularCourse()
    {
        $userId = Auth::user()->id;
        
        $hasPurchased = Checkout::where(['status' => 'success', 'user_id' => $userId])->get()
            ->pluck('course_id')->toArray();
        
        $courses = Course::with('category')->addSelect([
            'rating' => Rating::selectRaw('avg(value) as total')
                ->whereColumn('course_id', 'courses.id')
                ->groupBy('course_id'),
            'user_rated' => Rating::selectRaw('count(value) as total')
                ->whereColumn('course_id', 'courses.id')
                ->groupBy('course_id'),
            'course_sold' => Checkout::selectRaw('count(id) as total')
                ->whereColumn('course_id', 'courses.id')
                ->groupBy('course_id')
            ])
            ->orderByDesc('user_rated')->limit(5)->get();
            
        $data = [
            'course' => $courses,
            'has_purchased' => $hasPurchased
        ];
        
        return $this->response("Courses found!", $data, 200);
    }
    
    public function detailCourse($slug)
    {
        $course = Course::with('category', 'totalDurations', 'playlist.playlistDurations', 'playlist.video')
            ->where('slug', $slug)->firstOrFail();
        
        return $this->response("Course found!", $course, 200);
    }
    
    public function storeRating(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $userId = Auth::user()->id;
        
        $courseId = Course::where('slug', $slug)->pluck('id')->implode(' ');
        
        $rating = Rating::create([
            'course_id' => $courseId,
            'user_id' => $userId,
            'value' => $request->value,
        ]);
        
        return $this->response("Rating created!", $rating, 201);
    }
    
    public function updateRating(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $userId = Auth::user()->id;
        
        $courseId = Course::where('slug', $slug)->pluck('id')->implode(' ');
        
        $rating = Rating::where(['course_id' => $courseId, 'user_id' => $userId])->firstOrFail();
        
        $rating->update([
            'course_id' => $courseId,
            'user_id' => $userId,
            'value' => $request->value,
        ]);
        
        return $this->response("Rating created!", $rating, 201);
    }
    
    public function myCourse(Request $request)
    {
        $userId = Auth::user()->id;
        
        $orderId = Checkout::where(['status' => 'success', 'user_id' => $userId])->get()
            ->pluck('course_id')->toArray();
        
        $value = e($request->get('q'));
        
        $courses = Course::with('category')->addSelect([
            'rating' => Rating::selectRaw('avg(value) as total')
                ->whereColumn('course_id', 'courses.id')
                ->groupBy('course_id'),
            'user_rated' => Rating::selectRaw('count(value) as total')
                ->whereColumn('course_id', 'courses.id')
                ->groupBy('course_id'),
            'course_sold' => Checkout::selectRaw('count(id) as total')
                ->whereColumn('course_id', 'courses.id')
                ->groupBy('course_id')
            ])
            ->whereIn('courses.id', $orderId);
            
        if (!empty($value)) {
            $result = $courses->where('name', 'LIKE', '%'.$value.'%')->paginate(10);
        } else {
            $result = $courses->paginate(10);
        }
        
        $data = [
            'courses' => $result,
            'search' => $value,
        ];
        
        return $this->response("Courses found!", $data, 200);
    }
    
    public function detailMyCourse($slug)
    {
        $userId = Auth::user()->id;
        
        $orderId = Checkout::where(['status' => 'success', 'user_id' => $userId])->get()
            ->pluck('course_id')->toArray();
            
        $course = Course::with('category', 'playlist.video')
            ->where('slug', $slug)
            ->firstOrFail();
        
        if (!in_array($course->id, $orderId)) {
            return $this->response("You haven't purchased this course!", null, 422);
        }
        
        return $this->response("Course found!", $course, 200);
    }
    
    public function myAnnouncement()
    {
        $userId = Auth::user()->id;
        
        $announcements = Announcement::where('type', 'public')->orWhere('user_id', $userId)->get();
        
        return $this->response("Announcements found!", $announcements, 200);
    }
    
    public function detailMyAnnouncement($id)
    {
        $announcement = Announcement::with('user')->findOrFail($id);
        
        return $this->response("Announcement found!", $announcement, 200);
    }
}
