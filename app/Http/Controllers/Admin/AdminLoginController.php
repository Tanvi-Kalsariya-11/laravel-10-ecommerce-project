<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function index() {
        return view('Admin.login');
    }

    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->route('admin.login')
                ->withErrors($validator)->withInput($request->only('email'));
        } else {

            if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('admin.login')->with('error','Email or Password is incorrect');
            }
        }
    }
}
