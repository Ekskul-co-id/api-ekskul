<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use APIResponse;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();
        
        return $this->response("Category found!", $categories, 200);
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
            'icon' => 'required|mimes:jpeg,jpg,png,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }

        $fileName = time().'.'.$request->icon->extension();
        
        $path = "icon";
        
        $request->icon->move(public_path($path), $fileName);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => env('APP_URL').'/'.$path.'/'.$fileName,
        ]);
        
        return $this->response("Category has created!", $category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $category->load('playlist');
        
        return $this->response("Category found!", $category, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'icon' => 'mimes:jpeg,jpg,png,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        if($request->hasFile('icon')){
            $fileName = time().'.'.$request->icon->extension();
            
            $path = "icon";
            
            $request->icon->move(public_path($path), $fileName);
            
            unlink(public_path($path . $category->icon));
            
            $icon = env('APP_URL').'/'.$path.'/'.$fileName;
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $icon ?? $category->icon // fungsi dari ?? kalau tidak ada request icon (hanya update name saja) maka dia akan ngambil value dari $category->icon yang dijadikan value untuk update
        ]);

        return $this->response("Category has updated!", $category, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        
        return $this->response("Category has deleted!", null, 201);
    }
}
