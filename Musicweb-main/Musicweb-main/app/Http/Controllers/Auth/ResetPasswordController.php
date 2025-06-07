<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords; // Sử dụng trait có sẵn của Laravel để xử lý reset mật khẩu

    protected $redirectTo = '/login'; // Sau khi reset mật khẩu thành công, chuyển hướng về login

    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }
}
