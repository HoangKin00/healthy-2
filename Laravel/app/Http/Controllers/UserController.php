<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function login_form()
    {
     return view('admin.users.login');
    }
    public function login(Request $request)
    {
         //Validate dữ liệu
         $rules = [
            'email' => 'required|email|exists:admin',
            'password' => 'required|size:6',
        ];

        $mag = [
            'email.required' => 'Email không được để trống',
            'email.exists' => 'Email không tồn tại',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.size' => 'Mật khẩu bắt buộc phải 6 ký tự',
        ];
        $request->validate($rules, $mag);
        if(Auth::guard('admin')->attempt($request->only('email','password'),$request->has('remember'))){
            return redirect()->route('index')->with('success','Đăng nhập thành công');
        }else {
            return redirect()->back()->with('error','Email hoặc mật khẩu không hợp lệ');
        }
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
     return view('admin.users.login');
    }
}
