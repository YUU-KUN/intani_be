<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Auth;
use Hash;
use Validator;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Storage;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('Intani App Token')->accessToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function registerFarmer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'address' => 'required|string|max:250',
            'letter' => 'required|file|mimes:pdf|max:2048',
            'email' => 'required|email|unique:users|max:250',
            'password' => 'required|confirmed',
        ]);

        $input = $request->all();
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        
        $credentials['email'] = $input['email'];
        $credentials['password'] = Hash::make($input['password']);
        $credentials['role'] = 'company';
        $user = User::create($credentials);
        if ($user) {
            // handle file upload
            $company_letter = time().'.'.$request->letter->extension();
            $company_letter_path = Storage::url('company/letter/');
            $request->letter->move(public_path($company_letter_path), $company_letter);
            
            $input['letter'] = $company_letter;
            $input['user_id'] = $user->id;

            // Create Company
            $company = Company::create($input);

            if ($company) {
                return response()->json([
                    'success'=> true,
                    'message' => 'Successfully created Company!',
                    'data' => $company
                ], 200);
            } else {
                return response()->json([
                    'success'=> false,
                    'message' => 'Failed to create Company!'
                ], 500);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed registering User!',
            ]);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
