<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\EkskulIdMail;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    


    public function verify(Request $request, $id)
    {
        $find = User::where('email', '=', base64_decode($id))->first();
        if (!$find) {
            return response()->json([
                'status' => false,
                'message' => 'errr verify your data !',
            ], 400);
        }
        User::where('email', '=', base64_decode($id))->update(['email_verified_at' => date('d-m-Y H:m:s')]);
        return view('mail/thanks');
    }


    public function update(Request $request, $id)
    {
        $req = $request->all();
        $data = [
            'name' => $req['username'],
            'email' => $req['email'],
            'password' => bcrypt($req['password']),
            'id_role' => $req['id_role'],
            'addres' => $req['addres'],
        ];

        $update = User::where('id', '=', $id)->update($data);
        if (!$update) {
            return response()->json([
                'status' => false,
                'message' => 'errr updated your data !',
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Update Data Succesfuly',
            'data' => $data,
        ], 200);
    }

    public function show($id = null)
    {
        if ($id) {
            $user = User::where('id', '=', $id)->first();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'users not found !'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Details user has geted !',
                'data' => $user,
            ], 200);
        }
        $user = User::get();
        return response()->json([
            'status' => true,
            'message' => 'user has geted !',
            'data' => $user,
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = request()->user(); //or Auth::user()
        // Revoke current user token
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return response()->json([
            'uuid' => $user->currentAccessToken()->id,
            'logout' => true
        ], 200);
    }


    public function destroy(Request $request, $id)
    {
        $user = User::where('id', '=', $id)->delete();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'users not found !'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'users sucessfuly deleted!'
        ], 201);
    }
}
