<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
        $query = Artist::withCount('songs'); // Thêm số lượng bài hát

        // Lấy dữ liệu từ request
        $keyword = $request->get('keyword');
        $searchBy = $request->get('search_by', 'all');
        $sortBy = $request->get('sort_by', 'id_desc');
        $perPage = $request->get('per_page', 10);

        // Xử lý tìm kiếm
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($keyword, $searchBy) {
                if ($searchBy === 'all') {
                    $q->where('name', 'like', "%{$keyword}%")
                        ->orWhere('bio', 'like', "%{$keyword}%");
                } elseif ($searchBy === 'id') {
                    if (is_numeric($keyword)) {
                        $q->where('id', intval($keyword));
                    }
                } else {
                    $q->where($searchBy, 'like', "%{$keyword}%");
                }
            });
        }

        // Xử lý sắp xếp
        switch ($sortBy) {
            case 'id_asc':
                $query->orderBy('id', 'asc');
                break;
            case 'id_desc':
                $query->orderBy('id', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'songs_count_asc':
                $query->orderBy('songs_count', 'asc');
                break;
            case 'songs_count_desc':
                $query->orderBy('songs_count', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        // Xử lý phân trang
        if ($perPage === 'all') {
            $artists = $query->get();
        } else {
            $artists = $query->paginate((int) $perPage)->appends($request->all());
        }

        // Chuẩn bị dữ liệu cho view
        $searchOptions = [
            'all' => 'Tất cả',
            'id' => 'ID',
            'name' => 'Tên nghệ sĩ',
            'bio' => 'Tiểu sử'
        ];

        $sortOptions = [
            'id_desc' => 'ID (Mới nhất)',
            'id_asc' => 'ID (Cũ nhất)',
            'name_asc' => 'Tên (A-Z)',
            'name_desc' => 'Tên (Z-A)',
            'songs_count_desc' => 'Số bài hát (Nhiều nhất)',
            'songs_count_asc' => 'Số bài hát (Ít nhất)'
        ];

        $perPageOptions = [
            10 => '10 mục',
            25 => '25 mục',
            50 => '50 mục',
            100 => '100 mục',
            'all' => 'Tất cả'
        ];

        return view('admin.artists.index', compact(
            'artists',
            'searchOptions',
            'sortOptions',
            'perPageOptions',
            'keyword',
            'searchBy',
            'sortBy',
            'perPage'
        ));
    }
    public function create()
    {
        return view('admin.artists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        try {
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('artists', 'public');
                $validated['avatar'] = $avatarPath;
            }

            Artist::create($validated);
            return redirect()->route('artists.index')->with('success', 'Nghệ sĩ đã được thêm thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi thêm nghệ sĩ!')->withInput();
        }
    }

    public function edit(Artist $artist)
    {
        return view('admin.artists.edit', compact('artist'));
    }

    public function update(Request $request, Artist $artist)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        try {
            if ($request->hasFile('avatar')) {
                // Xóa avatar cũ nếu có
                if ($artist->avatar) {
                    Storage::disk('public')->delete($artist->avatar);
                }

                // Upload avatar mới
                $avatarPath = $request->file('avatar')->store('artists', 'public');
                $validated['avatar'] = $avatarPath;
            }

            $artist->update($validated);
            return redirect()->route('artists.index')->with('success', 'Nghệ sĩ đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật nghệ sĩ!')->withInput();
        }
    }

    public function destroy(Artist $artist)
    {
        try {
            // Kiểm tra xem nghệ sĩ có bài hát không
            if ($artist->songs()->count() > 0) {
                return back()->with('error', 'Không thể xóa nghệ sĩ này vì có bài hát liên quan!');
            }

            // Xóa avatar nếu có
            if ($artist->avatar) {
                Storage::disk('public')->delete($artist->avatar);
            }

            $artist->delete();
            return redirect()->route('artists.index')->with('success', 'Nghệ sĩ đã được xóa thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi xóa nghệ sĩ!');
        }
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $artists = Artist::where('name', 'like', "%{$search}%")
            ->orWhere('bio', 'like', "%{$search}%")
            ->paginate(10);

        return view('admin.artists.index', compact('artists'));
    }
    public function show(Artist $artist)
    {
        $artist->loadCount('songs'); // Đếm số bài hát
        return view('admin.artists.show', compact('artist'));
    }
}
