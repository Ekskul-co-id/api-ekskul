<?php

namespace App\Http\Controllers;

use App\Models\PaymentLog;
use App\Traits\APIResponse;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = PaymentLog::get();

        return $this->response('Payment logs found!', $logs, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentLog  $log
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentLog $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentLog  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentLog $log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentLog  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentLog $log)
    {
        //
    }
}
