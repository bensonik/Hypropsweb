<?php

namespace App\Http\Controllers;

use App\model\AccountChart;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\model\Position;
use App\model\Department;
use App\model\SalaryStructure;
use App\Helpers\Utility;
use App\User;
use App\model\Roles;
use Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class AccountChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\model\AccountChart  $accountChart
     * @return \Illuminate\Http\Response
     */
    public function show(AccountChart $accountChart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\model\AccountChart  $accountChart
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountChart $accountChart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\model\AccountChart  $accountChart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountChart $accountChart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\model\AccountChart  $accountChart
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountChart $accountChart)
    {
        //
    }
}
