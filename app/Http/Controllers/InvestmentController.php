<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Farmer;
use App\Models\Investor;
use App\Models\InvestorInvestment;
use Illuminate\Http\Request;
use App\Http\Helper\ResponseHelper;
use Auth;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $investment = Investment::all();
        return ResponseHelper::success('Berhasil mendapatkan data semua investasi', $investment);
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
        // return Farmer::has('FarmGroup')->get();
        $input = $request->all();
        $input['status'] = 'pending';
        $farmer_id = Auth::user()->id;
        if (Farmer::has('FarmGroup')->where('user_id', $farmer_id)->exists()) {
            $input['farm_group_id'] = Farmer::where('user_id', $farmer_id)->first()->farm_group_id;
        } else {
            $input['farmer_id'] = $farmer_id;
        }
        // return $input->with('FarmGroup');
        $investment = Investment::create($input);
        $investment = $investment->Farmer ? $investment->load('Farmer') : $investment->load('FarmGroup');
        return ResponseHelper::success('Berhasil membuat investasi', $investment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function show(Investment $investment)
    {
        $investment = $investment->Farmer ? $investment->load('Farmer') : $investment->load('FarmGroup');
        return ResponseHelper::success('Berhasil mendapatkan data investasi', $investment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function edit(Investment $investment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Investment $investment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Investment $investment)
    {
        //
    }

    public function getInvestorInvestment()
    {
        $investor_id = Auth::user()->id; //logged in as investor
        $investment = InvestorInvestment::where('investor_id', $investor_id)->get();
        return ResponseHelper::success('Berhasil mendapatkan data semua investasi investor', $investment);
    }

    public function getAvailableInvestment(Request $request)
    {
        $investment = Investment::where('status', 'pending')->with('Farmer', 'FarmGroup')->get();
        return ResponseHelper::success('Berhasil mendapatkan data semua investasi yang tersedia', $investment);
    }

    public function PayInvestment(Request $request)
    {
        $input = $request->all();
        $input['investor_id'] = Investor::where('user_id', Auth::user()->id)->first()->id;

        $investor = Investor::where('user_id', Auth::user()->id)->first();
        $admin_fee = $input['amount'] * 0.01;
        return $admin_fee;
        if ($investor->saldo >= $input['amount']) {
            $investor->decrement('saldo', $input['amount']);
            $investor->save();
            $investor_investment = InvestorInvestment::create($input);
            return ResponseHelper::success('Berhasil melakukan pembayaran investasi', $investor_investment->load('Investment', 'Investor'));
        }
        return ResponseHelper::error('Saldo tidak cukup', null);

    }

    public function GetFarmerPendingInvestment(Request $request)
    {   
        // get farmgroup id of logged in farmer

        // $farmer_id = Auth::user()->Farmer;
        // return $farmer_id->FarmGroup->id;
        // return Auth::user()->load('Farmer', 'Farmer.FarmGroup');
        $investment = InvestorInvestment::whereHas('Investment', function($q) {
            $q->where('status', 'pending');
            $q->whereHas('FarmGroup', function($r) {
                $r->where('id', Auth::user()->Farmer->FarmGroup->id);
            });
        })->with('Investment', 'Investor')->get();
        return ResponseHelper::success('Berhasil mendapatkan data semua investasi yang pending', $investment);
    }


    public function getFarmerAcceptedInvestment()
    {
        $investment = InvestorInvestment::whereHas('Investment', function($q) {
            $q->where('status', 'approved');
            $q->whereHas('FarmGroup', function($r) {
                $r->where('id', Auth::user()->Farmer->FarmGroup->id);
            });
        })->with('Investment', 'Investor')->get();
        
        return ResponseHelper::success('Berhasil mendapatkan data semua investasi yang diterima', $investment);
    }

    public function getFarmerCompletedInvestment()
    {
        $investment = InvestorInvestment::whereHas('Investment', function($q) {
            $q->where('status', 'completed');
            $q->whereHas('FarmGroup', function($r) {
                $r->where('id', Auth::user()->Farmer->FarmGroup->id);
            });
        })->with('Investment', 'Investor')->get();
        return ResponseHelper::success('Berhasil mendapatkan data semua investasi yang selesai', $investment);
    }

    public function getFarmerHistoryInvestment()
    {
        $investment = InvestorInvestment::whereHas('Investment', function($q) {
            $q->where('status', 'completed');
            $q->orWhere('status', 'rejected');
            $q->whereHas('FarmGroup', function($r) {
                $r->where('id', Auth::user()->Farmer->FarmGroup->id);
            });
        })->with('Investment', 'Investor')->get();
        return ResponseHelper::success('Berhasil mendapatkan data semua investasi yang selesai', $investment);
    }

    public function acceptInvestment(Request $request)
    {
        $investment = Investment::where('id', $request->investment_id)->first();
        $investment->status = 'approved';
        $investment->save();
        return ResponseHelper::success("Berhasil menyetujui investasi", $investment);
    }

    public function getDetailInvestment(Request $request)
    {
        $investment = InvestorInvestment::where('id', $request->investment_id)->with('Investor', 'Investment.FarmGroup')->first();
        return ResponseHelper::success("Berhasil mendapatkan data investasi", $investment);
    }

    public function farmerFinishInvestment(Request $request)
    {

        $investment = InvestorInvestment::where('id', $request->investment_id)->first();
        $investment->Investment->status = 'completed';
        $investment->Investment->save();
        return ResponseHelper::success("Berhasil menyelesaikan investasi", $investment);
    }

    public function updateInvestmentIncome(Request $request)
    {
        $user = Auth::user();
        $investment = Investment::where('status', 'approved')->where('farm_group_id', $user->Farmer->FarmGroup->id || 'farmer_id', $user->Farmer->id)->first();
        $investment->income = $request->income;
        $investment->save();
        return ResponseHelper::success("Berhasil mengupdate income investasi", $investment);
    }

    public function getProfitSharing(Request $request)
    {
        $user = Auth::user();
        $investment_income = Investment::where('status', 'approved')->where(function($q) use ($user) {
            $q->where('farm_group_id', $user->Farmer->FarmGroup->id)
            ->orWhere('farmer_id', $user->Farmer->id);
        })->first()->income ?? 0; // farmer input

        $profit_sharing = InvestorInvestment::whereHas('Investment', function($q) {
            $q->where('status', 'approved');
            $q->whereHas('FarmGroup', function($r) {
                $r->where('id', Auth::user()->Farmer->FarmGroup->id);
            })->orWhereHas('Farmer', function($r) {
                $r->where('id', Auth::user()->Farmer->id);
            });
        })->with('Investment', 'Investor')->get();

        $total_invest_received = $profit_sharing->sum('amount');

        if ($investment_income) {
            $is_profit = $investment_income >= $total_invest_received;
            
            $total_investor = $profit_sharing->count();
    
            $farmer_profit = 0;
            $investor_profit = 0;
    
            if ($is_profit) {
                // Untung = (50% x untung)/jumlah invesetor
                $farmer_profit = 0.5 * ($investment_income - $total_invest_received);
                $investor_profit = ($investment_income * 0.5) / $total_investor;
            } else {
                // Rugi = (100% x pendapatan)/jumlah investor
                $farmer_profit = 0;
                $investor_profit = $investment_income / $total_investor;
            }
            
            $data['profit_sharing'] = $profit_sharing;
            $data['total_invest_received'] = $total_invest_received;
            $data['investment_income'] = $investment_income;
            $data['farmer_profit'] = $farmer_profit;
            $data['investor_profit'] = $investor_profit;
            $data['is_profit'] = $is_profit;
    
            return ResponseHelper::success("Berhasil mendapatkan data profit sharing", $data);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Belum ada pemasukan investasi. Silahkan masukkan pemasukan terlebih dahulu',
                'data' => ["total_invest_received" => $total_invest_received],
            ], 200);
        }

        
    }

    public function updateIncome(Request $request)
    {
        $user = Auth::user();
        $investment = Investment::where('status', 'approved')->where(function($q) use ($user) {
            $q->where('farm_group_id', $user->Farmer->FarmGroup->id)
            ->orWhere('farmer_id', $user->Farmer->id);
        })->first();
        $investment->income = $request->income;
        $investment->save();
        return ResponseHelper::success("Berhasil mengupdate income investasi", $investment);
    }

    public function proceedProfitSharing(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $investments = InvestorInvestment::whereHas('Investment', function($q) {
            $q->where('status', 'approved');
            $q->whereHas('FarmGroup', function($r) {
                $r->where('id', Auth::user()->Farmer->FarmGroup->id);
            })->orWhereHas('Farmer', function($r) {
                $r->where('id', Auth::user()->Farmer->id);
            });
        })->with('Investor', 'Investment')->get();

        $investors = $investments->pluck('Investor')->unique('id');

        if ($input['is_profit']) {
            // Farmer
            if ($user->Farmer->FarmGroup) {
                $farmers = $user->Farmer->FarmGroup->Farmers;
                foreach ($farmers as $farmer) {
                    $farmer->saldo += $input['farmer_profit']/count($farmers);
                    $farmer->save();
                }
            } else {
                $user->Farmer->saldo += $input['farmer_profit'];
            }

            // Investor
            foreach ($investors as $investor) {
                $investor->saldo += $input['investor_profit'] / count($investors);
                $investor->save();
            }
        } else {
            // Investor
            foreach ($investors as $investor) {
                $investor->saldo += $input['investor_profit'] / count($investors);
                $investor->save();
            }
        }


        // Update status investment
        $investment = $investments->first()->Investment;
        $investment->status = 'completed';
        $investment->save();

        return ResponseHelper::success("Berhasil melakukan bagi hasil", null);
    }
}
