<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\Checkout;
use App\Models\Company;
use App\Models\Course;
use App\Models\Livestream;
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
    
    public function detailCategory(Category $category)
    {
        $userId = Auth::user()->id;
        
        $hasPurchased = Checkout::where(['status' => 'success', 'user_id' => $userId, 'type' => 'course'])->get()
            ->pluck('course_id')->toArray();
        
        $courses = Course::with('category', 'mentor', 'company', 'totalDurations')->addSelect([
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
        
        $hasPurchased = Checkout::where(['status' => 'success', 'user_id' => $userId, 'type' => 'course'])->get()
            ->pluck('course_id')->toArray();
        
        $value = e($request->get('q'));
        
        $courses = Course::with('category', 'mentor', 'company', 'totalDurations')->addSelect([
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
        
        $hasPurchased = Checkout::where(['status' => 'success', 'user_id' => $userId, 'type' => 'course'])->get()
            ->pluck('course_id')->toArray();
        
        $courses = Course::with('category', 'mentor', 'company')->addSelect([
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
            ->orderByDesc('user_rated')->limit(10)->get();
            
        $data = [
            'course' => $courses,
            'has_purchased' => $hasPurchased
        ];
        
        return $this->response("Courses found!", $data, 200);
    }
    
    public function detailCourse(Course $course)
    {
        $userId = Auth::user()->id;
        
        $orderId = Checkout::where(['status' => 'success', 'user_id' => $userId, 'type' => 'course'])->get()
            ->pluck('course_id')->toArray();
            
        $course->load('category', 'mentor', 'company', 'totalDurations', 'playlist.playlistDurations');
        
        if (in_array($course->id, $orderId)) {
            $status = true;
        } else {
            $status = false;
        }
        
        $data = [
            'course' => $course,
            'has_purchased' => $status
        ];
        
        return $this->response("Course found!", $data, 200);
    }
    
    public function storeRating(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $userId = Auth::user()->id;
        
        $rating = Rating::create([
            'course_id' => $course->id,
            'user_id' => $userId,
            'value' => $request->value,
        ]);
        
        return $this->response("Rating created!", $rating, 201);
    }
    
    public function updateRating(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $userId = Auth::user()->id;
        
        $rating = Rating::where(['course_id' => $course->id, 'user_id' => $userId])->firstOrFail();
        
        $rating->update([
            'value' => $request->value,
        ]);
        
        return $this->response("Rating created!", $rating, 201);
    }
    
    public function listLivestream(Request $request)
    {
        $userId = Auth::user()->id;
        
        $hasPurchased = Checkout::where(['status' => 'success', 'user_id' => $userId, 'type' => 'livestream'])->get()
            ->pluck('course_id')->toArray();
        
        $value = $request->get('q');
        
        $livestreams = Livestream::with('category', 'mentor')->addSelect([
            'livestream_sold' => Checkout::selectRaw('count(id) as total')
                ->whereColumn('livestream_id', 'livestreams.id')
                ->groupBy('livestream_id')
            ]);
            
        if (!empty($value)) {
            $result = $livestreams->whereDate('start_date', '=', $value)->paginate(10);
        } else {
            $result = $livestreams->paginate(10);
        }
        
        $data = [
            'livestreams' => $result,
            'has_purchased' => $hasPurchased,
            'search' => $value,
        ];
        
        return $this->response("Livestreams found!", $data, 200);
    }
    
    public function detailLivestream(Livestream $livestream)
    {
        $userId = Auth::user()->id;
        
        $orderId = Checkout::where(['status' => 'success', 'user_id' => $userId, 'type' => 'livestream'])->get()
            ->pluck('course_id')->toArray();
        
        $livestream->load('category', 'mentor');
        
        if (in_array($livestream->id, $orderId)) {
            $status = true;
        } else {
            $status = false;
        }
        
        $data = [
            'livestream' => $livestream,
            'has_purchased' => $status
        ];
        
        return $this->response("Livestream found!", $data, 200);
    }
    
    public function listCompany(Request $request)
    {
        $value = $request->get('q');
        
        $companies = Company::addSelect([
            'total_courses' => Course::selectRaw('count(name) as total')
                ->whereColumn('company_id', 'companies.id')
                ->groupBy('company_id')
        ]);
        
        if (!empty($value)) {
            $result = $companies->where('name', 'LIKE', '%'.$value.'%')->paginate(10);
        } else {
            $result = $companies->paginate(10);
        }
        
        return $this->response("Companies found!", $result, 200);
    }
    
    public function detailCompany(Company $company)
    {
        $company->load('owner', 'users', 'courses');
        
        return $this->response("Company found!", $company, 200);
    }
    
    public function coursesCompany(Company $company)
    {
        $company->load('courses', 'courses.category', 'courses.mentor', 'courses.totalDurations');
        
        return $this->response("Company found!", $company, 200);
    }
    
    public function myCourse(Request $request)
    {
        $userId = Auth::user()->id;
        
        $orderId = Checkout::where(['status' => 'success', 'user_id' => $userId, 'type' => 'course'])->get()
            ->pluck('course_id')->toArray();
        
        $value = e($request->get('q'));
        
        $courses = Course::with('category', 'mentor', 'company')->addSelect([
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
    
    public function detailMyCourse(Course $course)
    {
        $userId = Auth::user()->id;
        
        $orderId = Checkout::where(['status' => 'success', 'user_id' => $userId, 'type' => 'course'])->get()
            ->pluck('course_id')->toArray();
        
        $course->load('category', 'mentor', 'company', 'totalDurations', 'playlist.playlistDurations', 'playlist.video.watched');
        
        if (!in_array($course->id, $orderId)) {
            return $this->response("You haven't purchased this course!", null, 422);
        }
        
        return $this->response("Course found!", $course, 200);
    }
    
    public function markWatched(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $userId = Auth::user()->id;
        
        $video = Video::findOrFail($request->video_id);
        
        $check = Video::whereHas('users', function ($q) use($userId, $request) {
            $q->where('user_id', $userId);
            $q->where('video_id', $request->video_id);
        })->get();
        
        if (!count($check)) {
            $video->users()->attach($userId);
            
            return $this->response("Success marks the video as watched", null, 201);
        }
        
        return $this->response("You haven marks this video as watched", null, 201);
    }
    
    public function myAnnouncement()
    {
        $userId = Auth::user()->id;
        
        $announcements = Announcement::where('type', 'public')->orWhere('user_id', $userId)->get();
        
        return $this->response("Announcements found!", $announcements, 200);
    }
    
    public function detailMyAnnouncement(Announcement $announcement)
    {
        $announcement->load('user');
        
        return $this->response("Announcement found!", $announcement, 200);
    }
    
    public function myLivestream(Request $request)
    {
        $userId = Auth::user()->id;
        
        $orderId = Checkout::where(['status' => 'success', 'user_id' => $userId, 'type' => 'livestream'])->get()
            ->pluck('livestream_id')->toArray();
        
        $value = e($request->get('q'));
        
        $livestreams = Livestream::with('category', 'mentor')->addSelect([
            'livestream_sold' => Checkout::selectRaw('count(id) as total')
                ->whereColumn('livestream_id', 'livestreams.id')
                ->groupBy('livestream_id')
            ])
            ->whereIn('livestreams.id', $orderId);
            
        if (!empty($value)) {
            $result = $livestreams->where('name', 'LIKE', '%'.$value.'%')->paginate(10);
        } else {
            $result = $livestreams->paginate(10);
        }
        
        $data = [
            'livestreams' => $result,
            'search' => $value,
        ];
        
        return $this->response("livestreams found!", $data, 200);
    }
    
    public function detailMyLivestream(Livestream $livestream)
    {
        $userId = Auth::user()->id;
        
        $orderId = Checkout::where(['status' => 'success', 'user_id' => $userId, 'type' => 'livestream'])->get()
            ->pluck('livestream_id')->toArray();
        
        $livestream->load('category', 'mentor');
        
        if (!in_array($livestream->id, $orderId)) {
            return $this->response("You haven't purchased this livestream!", null, 422);
        }
        
        return $this->response("Livestream found!", $livestream, 200);
    }
}
