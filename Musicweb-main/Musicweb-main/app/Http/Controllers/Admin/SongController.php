<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Models\Artist;
use App\Models\Genre;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index(Request $request)
    {
        $query = Song::with(['artist', 'genre']);

        // Lấy dữ liệu từ request
        $keyword = $request->get('keyword');
        $searchBy = $request->get('search_by', 'all');
        $sortBy = $request->get('sort_by', 'id_desc');
        $perPage = $request->get('per_page', 10);

        // Xử lý tìm kiếm
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($keyword, $searchBy) {
                if ($searchBy === 'all') {
                    $q->where('title', 'like', "%{$keyword}%")
                        ->orWhereHas('artist', function ($q) use ($keyword) {
                            $q->where('name', 'like', "%{$keyword}%");
                        })
                        ->orWhereHas('genre', function ($q) use ($keyword) {
                            $q->where('name', 'like', "%{$keyword}%");
                        });
                } elseif ($searchBy === 'id') {
                    if (is_numeric($keyword)) {
                        $q->where('id', intval($keyword));
                    }
                } elseif ($searchBy === 'artist_id') {
                    $q->whereHas('artist', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                } elseif ($searchBy === 'genre_id') {
                    $q->whereHas('genre', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
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
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc'); // Mặc định sắp xếp theo ID mới nhất
                break;
        }

        // Xử lý phân trang
        if ($perPage === 'all') {
            $songs = $query->get(); // Lấy tất cả bản ghi (không phân trang)
        } else {
            $songs = $query->paginate((int) $perPage); // Phân trang như bình thường
        }

        return view('admin.songs.index', compact('songs'));
    }

    // Hiển thị form tạo bài hát
    public function create()
    {
        $artists = Artist::all();
        $genres = Genre::all();
        return view('admin.songs.create', compact('artists', 'genres'));
    }

    // Lưu bài hát mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'artist_id' => ['required', 'exists:artists,id'],
            'genre_id' => ['required', 'exists:genres,id'],
            'file_url' => ['required', 'url'],
            'duration' => ['required', 'numeric'],
        ]);

        try {
            Song::create($validated);
            return redirect()->route('songs.index')->with('success', 'Bài hát đã được tạo thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi tạo bài hát!')->withInput();
        }
    }

    // Hiển thị form chỉnh sửa bài hát
    public function edit(Song $song)
    {
        $artists = Artist::all();
        $genres = Genre::all();
        return view('admin.songs.edit', compact('song', 'artists', 'genres'));
    }

    // Cập nhật bài hát
    public function update(Request $request, Song $song)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'artist_id' => ['required', 'exists:artists,id'],
            'genre_id' => ['required', 'exists:genres,id'],
            'file_url' => ['required', 'url'],
            'duration' => ['required', 'numeric'],
        ]);

        try {
            $song->update($validated);
            return redirect()->route('songs.index')->with('success', 'Bài hát đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật bài hát!')->withInput();
        }
    }

    // Xóa bài hát
    public function destroy(Song $song)
    {
        try {
            $song->delete();
            return redirect()->route('songs.index')->with('success', 'Bài hát đã được xóa thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi xóa bài hát!');
        }
    }
    public function search(Request $request)
    {
        $search = $request->get('search');

        $songs = Song::where('title', 'like', "%{$search}%")
            ->orWhere('artist_id', 'like', "%{$search}%")
            ->paginate(10);

        return view('admin.song.index', compact('songs'));
    }
    public function show(Song $song)
    {
        return view('admin.songs.show', compact('song'));
    }
}
