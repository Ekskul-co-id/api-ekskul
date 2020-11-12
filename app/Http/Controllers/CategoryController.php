<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id = null)
    {
        if($id){
            $data = Category::where('id_category','=',$id)->first();
            if(!$data){
                return response()->json([
                    'status' => false,
                    'message' => 'detailscategory not be found !'
                ],404);
            }

            return response()->json([
                'status' => true,
                'message' => 'detailscategory found !',
                'data' => $data,
            ],200);
        }

        $data = Category::get();
        return response()->json([
            'status' => true,
            'message' => 'category found !',
            'data' => $data,
        ],200);
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
        $request->validate([
            'category_name' => 'required',
            'icon_category' => '|mimes:jpeg,jpg,png,svg|max:2048',
        ]);

        $fileName = time().'.'.$request->icon_category->extension();
        $path = 'icon';
        $request->icon_category->move(public_path($path), $fileName);

        Category::create([
            'icon_category' => $path.'/'.$fileName, 
            'category_name' => $request->category_name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'category has created !',
            'data' => [
                'icon_category' => $path.'/'.$fileName,
                'category_name' => $request->category_name
            ],
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        $category = Category::where('id_category','=',$id)->first();

        if(!$category){
            return response()->json([
                'status' => false,
                'message' => 'Category Not Be Found !',
            ],404);
        }

        $fileName = time().'.'.$request->icon_category->extension();
        $path = 'icon';
        $request->icon_category->move(public_path($path), $fileName);

        Category::where('id_category','=',$id)->update([
            'icon_category' => $path.'/'.$fileName, 
            'category_name' => $request->category_name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'category has updated !',
            'data' => [
                'icon_category' => $path.'/'.$fileName,
                'category_name' => $request->category_name
            ],
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Category::where('id_category','=',$id)->delete();
        if(!$destroy){
            return response()->json([
                'status' => false,
                'message' => 'category not found !'
            ],404);
        }

        return response()->json([
            'status' => true,
            'message' => 'category sucessfuly deleted!'
        ],201);
    }
}
