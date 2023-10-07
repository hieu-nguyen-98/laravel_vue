<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Enums\StatusCode;

class LoginController extends Controller
{
    public function index(){
        return view('admin.auth.login');
    }

    public function login(Request $request){
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::guard('admin')->attempt($arr)) {

            return response()->json(['success' => true], StatusCode::OK);
        } else {

            dd('tài khoản và mật khẩu chưa chính xác');
        }
    }
}
