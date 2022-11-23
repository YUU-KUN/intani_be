<?php

namespace App\Http\Controllers;

use App\Models\FarmGroup;
use Illuminate\Http\Request;
use App\Http\Helper\ResponseHelper;

class FarmGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $farm_groups = FarmGroup::all();
        return ResponseHelper::success('Success mendapatkan data semua grup tani', $farm_groups);
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
     * @param  \App\Models\FarmGroup  $farmGroup
     * @return \Illuminate\Http\Response
     */
    public function show(FarmGroup $farmGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FarmGroup  $farmGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(FarmGroup $farmGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FarmGroup  $farmGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FarmGroup $farmGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FarmGroup  $farmGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(FarmGroup $farmGroup)
    {
        //
    }
}
