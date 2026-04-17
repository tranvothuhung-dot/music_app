<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra đã đăng nhập và role_id = 1 (Admin)
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request);
        }

        // Nếu là User thường (role_id = 2), đá về trang dashboard kèm thông báo
        return redirect('/dashboard')->with('error', 'Bạn không có quyền truy cập vào trang Quản trị!');
    }
}