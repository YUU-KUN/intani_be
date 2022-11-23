<?php

namespace App\Http\Controllers;

use App\Models\InvestorInvestment;
use Illuminate\Http\Request;
use Auth;
use ResponseHelper;

class InvestorInvestmentController extends Controller
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
        $investment_price = 5000000;
        $investor_id = Auth::user()->id;
        $input = $request->all();
        $input['investor_id'] = $investor_id;
        $input['investment_id'] = $request->investment_id;
        $input['amount'] = $request->amount * $investment_price;
        InvestorInvestment::find('investor_id', $investor_id)->where('investment_id', $request->investment_id)->exists();
        $investorInvestment = InvestorInvestment::create($input);
        return ResponseHelper::success($investorInvestment->load('Investment'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvestorInvestment  $investorInvestment
     * @return \Illuminate\Http\Response
     */
    public function show(InvestorInvestment $investorInvestment)
    {
        return ResponseHelper::success('Berhasil mendapatkan detail investasi investor', $investorInvestment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvestorInvestment  $investorInvestment
     * @return \Illuminate\Http\Response
     */
    public function edit(InvestorInvestment $investorInvestment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvestorInvestment  $investorInvestment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvestorInvestment $investorInvestment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvestorInvestment  $investorInvestment
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvestorInvestment $investorInvestment)
    {
        //
    }
}
