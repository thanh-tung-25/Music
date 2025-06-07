<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $query = Genre::withCount('songs'); // Thêm số lượng bài hát

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
                        ->orWhere('description', 'like', "%{$keyword}%");
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
            $genres = $query->get();
        } else {
            $genres = $query->paginate((int) $perPage)->appends($request->all());
        }

        // Chuẩn bị dữ liệu cho view
        $searchOptions = [
            'all' => 'Tất cả',
            'id' => 'ID',
            'name' => 'Tên thể loại',
            'description' => 'Mô tả'
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

        return view('admin.genres.index', compact(
            'genres',
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
        return view('admin.genres.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:genres'],
            'description' => ['nullable', 'string'],
        ]);

        try {
            Genre::create($validated);
            return redirect()->route('genres.index')->with('success', 'Thể loại đã được thêm thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi thêm thể loại!')->withInput();
        }
    }

    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:genres,name,' . $genre->id],
            'description' => ['nullable', 'string'],
        ]);

        try {
            $genre->update($validated);
            return redirect()->route('genres.index')->with('success', 'Thể loại đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật thể loại!')->withInput();
        }
    }

    public function destroy(Genre $genre)
    {
        try {
            // Kiểm tra xem thể loại có bài hát không
            if ($genre->songs()->count() > 0) {
                return back()->with('error', 'Không thể xóa thể loại này vì có bài hát liên quan!');
            }

            $genre->delete();
            return redirect()->route('genres.index')->with('success', 'Thể loại đã được xóa thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi xóa thể loại!');
        }
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $genres = Genre::where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->paginate(10);

        return view('admin.genres.index', compact('genres'));
    }
    public function show(Genre $genre)
    {
        $genre->load('songs');
        return view('admin.genres.show', compact('genre'));
    }
}
