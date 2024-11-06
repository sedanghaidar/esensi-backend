<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $input = $request->only(['email', 'password']);

        $validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            // return response()->json(['message' => 'gagal']);
            return $this->error($validator->errors()->first());
        }

        try {

            if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
                $result = Auth::user();
            } else {
                $result = false;
            }

            if ($result) {
                $token = explode("|", $result->createToken('authToken')->plainTextToken);
                $result['token'] = $token[1]; // get only token without number
                return $this->success("Berhasil Login", $result);
            } else {
                return $this->error("User tidak ditemukan.");
            }
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
