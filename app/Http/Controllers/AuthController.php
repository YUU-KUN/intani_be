<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Helper\ResponseHelper;

use Auth;
use Hash;
use Validator;
use Storage;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Farmer;
use App\Models\Investor;
use App\Models\UserBank;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            // throw ValidationException::withMessages([
            //     'email' => ['The provided credentials are incorrect.'],
            // ]);
            return ResponseHelper::error('Gagal masuk. Cek kembali email & password Anda', null);
        }

        $token = $user->createToken('Intani App Token')->accessToken;
        $user = $user->role == 'farmer' ? Farmer::where('user_id', $user->id)->with('User', 'User.UserBank')->first() : Investor::where('user_id', $user->id)->with('User', 'User.UserBank')->first();
        return ResponseHelper::success('Berhasil login', [
            'token' => $token, 
            'user' => $user
        ]);
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // user
            'email' => 'required|email|unique:users|max:250',
            'password' => 'required',
            'role' => 'required|in:farmer,investor',

            // farmer
            'name' => 'required|string|max:50',
            'phone' => 'required|string|max:250',
            'nik' => 'required|string|max:250',
            'address' => 'nullable|string|max:250',
            'ktp' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            
            // bank
            'bank_id' => 'exists:banks,id',
            'account_number' => 'required|string|max:250',
            'account_name' => 'required|string|max:250',
        ]);

        $input = $request->all();
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        } else {
            $user_data['email'] = $input['email'];
            $user_data['password'] = Hash::make($input['password']);
            $user_data['role'] = $input['role'];
            $user_data['is_active'] = true; //temporary
    
            $user = User::create($user_data);
    
            if ($user) {
                $data['user_id'] = $user->id;
                if ($user->role == 'farmer') {
                    $data['farm_group_id'] = $input['farm_group_id'];
                };
                $data['name'] = $input['name'];
                $data['phone'] = $input['phone'];
                $data['nik'] = $input['nik'];
                // $data['address'] = $input['address'];
                $data['saldo'] = 50000000;
                $data['verified_ktp'] = true; //temporary

                $created_user = $user->role == 'farmer' ? Farmer::create($data) : Investor::create($data);
                // $farmer = Farmer::create($farmer_data);
    
                if ($created_user) {
                    $bank_data['user_id'] = $user->id;
                    $bank_data['bank_id'] = $input['bank_id'];
                    $bank_data['account_name'] = $input['account_name'];
                    $bank_data['account_number'] = $input['account_number'];
                    
                    $created_user_bank = UserBank::create($bank_data);

                    if ($created_user_bank) {
                        return ResponseHelper::success("Berhasil membuat akun", $created_user->with('User', 'User.UserBank')->first());
                        // return response()->json([
                        //     'status' => 'success',
                        //     'message' => 'Register Success',
                        //     'user' => $data->with('User', 'User.UserBank')->first(),
                        // ]);
                    }
                }
            }
        }
        

        // send otp
        // $otp = rand(100000, 999999);
        // $user->otp = $otp;
        // $user->save();

        // // send otp to email
        // $user->notify(new \App\Notifications\SendOtp($otp));
        
    }

    public function profile(Request $request)
    {
        if (Auth::user()->role == 'farmer') {
            return ResponseHelper::success('Berhasil mendapatkan data petani', Farmer::where('user_id', Auth::user()->id)->with('User', 'User.UserBank')->first());
        } else {
            return ResponseHelper::success('Berhasil mendapatkan data investor', Investor::where('user_id', Auth::user()->id)->with('User', 'User.UserBank')->first());
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
