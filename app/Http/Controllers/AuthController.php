<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    private function generateCode($user)
    {

    }

    public function postRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'string|max:255|required',
            'phone_number' => 'numeric|size:11|unique:users,phone_number|required'
        ]);
        if ($validator->fails()) {
            abort(400, $validator->errors());
        }

        $user = User::create([
           'username' => $request->input('username'),
            'phone_number' => $request->input('phone_number')
        ]);
    }

    public function postLogin(Request $request)
    {

    }
}
