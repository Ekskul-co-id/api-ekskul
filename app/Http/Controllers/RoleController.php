<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        if($id){
            $role = Role::where('id_role','=',$id)->first();
            if(!$role){
                return response()->json([
                    'status' => false,
                    'message' => 'Roles not be found !'
                ],404);
            }
            return response()->json([
                'status' => true,
                'message' => 'Roles found !',
                'data' => $role,
            ],200);
        }

        $role = Role::get();
        return response()->json([
            'status' => true,
            'message' => 'Roles found !',
            'data' => $role,
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
            'role_name' => 'required',
        ]);

        Role::insert(['role_name' => $request->role_name]);
        return response([
            'status' => true,
            'message' => 'role hass created!',
            'data' => [
                'role_name' => $request->role_name
                ]
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
        $check = Role::Where('id_role','=',$id)->first();
        if(!$check){
            return response()->josn([
                'status' => false,
                'message' => 'Roles Not be found!'
            ],404);
        }
        Role::Where('id_role','=',$id)->update(['role_name' => $request->role_name]);
        return response([
            'status' => true,
            'message' => 'role hass updated!',
            'data' => [
                'role_name' => $request->role_name
                ]
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
        $destroy = Role::where('id_role','=',$id)->delete();
        if(!$destroy){
            return response()->json([
                'status' => false,
                'message' => 'Roles not found !'
            ],404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Roles sucessfuly deleted!'
        ],201);
    }
}
