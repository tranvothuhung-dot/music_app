<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function users(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $users = User::query()
            ->when($search !== '', function ($query) use ($search) {
                if (ctype_digit($search)) {
                    $query->where(function ($subQuery) use ($search) {
                        $subQuery->where('user_id', (int) $search)
                            ->orWhere('role_id', (int) $search);
                    });
                    return;
                }

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('full_name', 'like', "%{$search}%");
                });
            })
            ->orderBy('user_id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'max:255'],
            'birth_day' => ['nullable', 'date'],
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'full_name' => ['required', 'string', 'max:150'],
            'avatar_image' => ['nullable', 'string', 'max:255'],
            'avatar_url' => ['nullable', 'url', 'max:255'],
            'role_id' => ['required', 'integer', 'in:1,2'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Đã thêm người dùng mới thành công.');
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:100',
                Rule::unique('users', 'username')->ignore($user->user_id, 'user_id'),
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($user->user_id, 'user_id'),
            ],
            'password' => ['nullable', 'string', 'min:6', 'max:255'],
            'birth_day' => ['nullable', 'date'],
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'full_name' => ['required', 'string', 'max:150'],
            'avatar_image' => ['nullable', 'string', 'max:255'],
            'avatar_url' => ['nullable', 'url', 'max:255'],
            'role_id' => ['required', 'integer', 'in:1,2'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index', ['search' => $request->input('search')])
            ->with('success', 'Đã cập nhật người dùng thành công.');
    }

    public function destroyUser(User $user): RedirectResponse
    {
        if (auth()->id() === $user->user_id) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Bạn không thể xóa tài khoản đang đăng nhập.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Đã xóa người dùng thành công.');
    }
}
