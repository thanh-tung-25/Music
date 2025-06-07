<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('keyword')) {
            $searchBy = $request->get('search_by', 'all');
            $keyword = $request->get('keyword');

            if ($searchBy === 'all') {
                $query->where(function ($q) use ($keyword) {
                    $q->where('id', 'like', "%{$keyword}%")
                        ->orWhere('name', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%")
                        ->orWhere('role', 'like', "%{$keyword}%");
                });
            } else {
                $query->where($searchBy, 'like', "%{$keyword}%");
            }
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $sortBy = $request->get('sort_by', 'id_desc');
        switch ($sortBy) {
            case 'id_asc':
                $query->orderBy('id', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'id_desc':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $perPage = $request->get('per_page', 10);
        $users = ($perPage === 'all') ? $query->get() : $query->paginate((int) $perPage)->appends($request->all());

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = ['admin' => 'Admin', 'user' => 'User', 'artist' => 'Artist'];
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => ['required', Rule::in(['admin', 'user', 'artist'])],
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ];

            if ($request->hasFile('avatar')) {
                $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            User::create($data);

            return redirect()->route('users.index')->with('success', 'Người dùng đã được tạo thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('User creation error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi tạo người dùng!')->withInput();
        }
    }

    public function edit(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Không thể chỉnh sửa tài khoản của chính mình!');
        }

        $roles = ['admin' => 'Admin', 'user' => 'User', 'artist' => 'Artist'];
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Không thể cập nhật tài khoản của chính mình!');
        }

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => 'nullable|string|min:8|confirmed',
                'role' => ['required', Rule::in(['admin', 'user', 'artist'])],
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ];

            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            if ($request->hasFile('avatar')) {
                // Xóa avatar cũ nếu có
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                // Lưu avatar mới
                $updateData['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            $user->update($updateData);

            return redirect()->route('users.index')
                ->with('success', 'Người dùng đã được cập nhật thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('User update error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật người dùng!')
                ->withInput();
        }
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Không thể xóa tài khoản của chính mình!');
        }

        try {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->delete();

            return redirect()->route('users.index')->with('success', 'Người dùng đã được xóa thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi xóa người dùng!');
        }
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
}
