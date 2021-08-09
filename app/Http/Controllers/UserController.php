<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use APIResponse;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();

        return $this->response("success get users.", $users, 200);
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
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'avatar' => 'https://ui-avatars.com/api/?name='.str_replace(' ', '+', $request->name).'&background=FBBF24&color=ffffff&bold=true&format=svg',
                'email_verified_at' => now(),
                'password' => Hash::make($request->password),
            ]);

            $user->syncRoles($request->role);

            return $this->response("Successfully create user.", $request->all(), 201);
        } catch (\Exception $e) {
            return $this->response("Falied to create user.", $e, 409);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('roles');

        return $this->response("Success get user.", $user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'avatar' => 'https://ui-avatars.com/api/?name='.str_replace(' ', '+', $request->name).'&background=FBBF24&color=ffffff&bold=true&format=png',
            'password' => 'string|min:6',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $password = !empty($request->password) ? Hash::make($request->password) : $user->password;
        
        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
            ]);

            $user->syncRoles($request->role);

            return $this->response("Successfully update user.", $request->all(), 201);
        } catch (\Exception $e) {
            return $this->response("Falied to update user.", $e, 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            return $this->response("Successfully delete user.", null, 201);
        } catch (\Exception $e) {
            return $this->response("Failed to delete user.", $e, 409);
        }
    }
}
