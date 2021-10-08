<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    use APIResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::get();

        return $this->response('Companies found!', $companies, 200);
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
            'slug' => Str::slug($request->name),
            'avatar' => 'required|mimes:jpeg,jpg,png,svg|max:2048',
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }

        $fileName = time().'.'.$request->avatar->extension();

        $path = 'company';

        $request->avatar->move(public_path($path), $fileName);

        $company = Company::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'avatar' => env('APP_URL').'/'.$path.'/'.$fileName,
            'user_id' => $request->user_id,
        ]);

        $company->users()->attach($request->user_id, ['role' => 'owner']);

        return $this->response('Company created!', $company, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        $company->load('owner', 'users', 'courses');

        return $this->response('Company found!', $company, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'avatar' => 'mimes:jpeg,jpg,png,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }

        if ($request->hasFile('avatar')) {
            $fileName = time().'.'.$request->avatar->extension();

            $path = 'company';

            $request->avatar->move(public_path($path), $fileName);

            unlink(public_path($path.$company->avatar));

            $avatar = env('APP_URL').'/'.$path.'/'.$fileName;
        }

        $company->update([
            'name' => $request->name,
            'icon' => $avatar ?? $company->avatar,
        ]);

        return $this->response('Company updated!', $company, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->users()->detach();

        $company->delete();

        return $this->response('Company deleted!', null, 201);
    }
}
