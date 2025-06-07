<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function index(Request $request)
    {
        $query = Playlist::with(['user', 'songs'])->withCount('songs');

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
                        ->orWhereHas('user', function ($q) use ($keyword) {
                            $q->where('name', 'like', "%{$keyword}%");
                        });
                } elseif ($searchBy === 'id') {
                    if (is_numeric($keyword)) {
                        $q->where('id', intval($keyword));
                    }
                } elseif ($searchBy === 'user_id') {
                    $q->whereHas('user', function ($q) use ($keyword) {
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
            $playlists = $query->get();
        } else {
            $playlists = $query->paginate((int) $perPage)->appends($request->all());
        }

        // Chuẩn bị dữ liệu cho view
        $searchOptions = [
            'all' => 'Tất cả',
            'id' => 'ID',
            'title' => 'Tên playlist',
            'user_id' => 'Người tạo'
        ];

        $sortOptions = [
            'id_desc' => 'ID (Mới nhất)',
            'id_asc' => 'ID (Cũ nhất)',
            'title_asc' => 'Tên (A-Z)',
            'title_desc' => 'Tên (Z-A)',
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

        return view('admin.playlists.index', compact(
            'playlists',
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
        $users = User::all();
        $songs = Song::all();
        return view('admin.playlists.create', compact('users', 'songs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'user_id' => ['required', 'exists:users,id'],
            'songs' => ['required', 'array'],
            'songs.*' => ['exists:songs,id']
        ]);

        try {
            $playlist = Playlist::create([
                'title' => $validated['title'],
                'user_id' => $validated['user_id']
            ]);

            $playlist->songs()->attach($validated['songs']);

            return redirect()->route('playlists.index')->with('success', 'Playlist đã được tạo thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi tạo playlist!')->withInput();
        }
    }

    public function edit(Playlist $playlist)
    {
        $users = User::all();
        $songs = Song::all();
        $selectedSongs = $playlist->songs->pluck('id')->toArray();
        return view('admin.playlists.edit', compact('playlist', 'users', 'songs', 'selectedSongs'));
    }

    public function update(Request $request, Playlist $playlist)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'user_id' => ['required', 'exists:users,id'],
            'songs' => ['required', 'array'],
            'songs.*' => ['exists:songs,id']
        ]);

        try {
            $playlist->update([
                'title' => $validated['title'],
                'user_id' => $validated['user_id']
            ]);

            $playlist->songs()->sync($validated['songs']);

            return redirect()->route('playlists.index')->with('success', 'Playlist đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật playlist!')->withInput();
        }
    }

    public function destroy(Playlist $playlist)
    {
        try {
            $playlist->songs()->detach(); // Xóa các liên kết với bài hát
            $playlist->delete();
            return redirect()->route('playlists.index')->with('success', 'Playlist đã được xóa thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi xóa playlist!');
        }
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $playlists = Playlist::where('title', 'like', "%{$search}%")
            ->orWhereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.playlists.index', compact('playlists'));
    }
    
    public function show(Playlist $playlist)
    {
        $playlist->load(['user', 'songs.artist']);
        return view('admin.playlists.show', compact('playlist'));
    }
}
