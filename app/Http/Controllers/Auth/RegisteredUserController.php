<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validate dữ liệu từ form cực kỳ chặt chẽ
        $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'username'  => [
                'required', 
                'string', 
                'min:3',
                'max:50', 
                'unique:users,username',
                'regex:/^[a-zA-Z0-9_]+$/' // Chỉ cho phép chữ không dấu, số và gạch dưới
            ],
            'email'     => [
                'required', 
                'string', 
                'lowercase', 
                'email', 
                'max:100', 
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/' // Bắt buộc đúng đuôi email
            ],
            'password'  => [
                'required', 
                'confirmed', 
                \Illuminate\Validation\Rules\Password::min(8) // 8 ký tự
            ],
            'birth_day' => ['required', 'date'],
            'gender'    => ['required', 'in:male,female,other'],
        ], [
            // Thông báo lỗi tùy chỉnh 
            'username.regex' => 'Username chỉ được chứa chữ cái không dấu, số và dấu gạch dưới.',
            'username.unique' => 'Tên đăng nhập này đã có người sử dụng.',
            'username.min' => 'Username phải có ít nhất 3 ký tự.',
            'email.regex' => 'Email phải có định dạng đầy đủ (VD: example@gmail.com).',
            'email.unique' => 'Email này đã được đăng ký.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'birth_day.required' => 'Vui lòng nhập ngày sinh.'
        ]);

        // 2. Lưu vào DB
        $user = User::create([
            'full_name' => $request->full_name,
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'birth_day' => $request->birth_day,
            'gender'    => $request->gender,
            'role_id'   => 2, // Mặc định 2 là User
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('music.index', absolute: false));
    }
}