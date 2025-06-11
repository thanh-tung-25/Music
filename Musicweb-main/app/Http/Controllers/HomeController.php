<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Artist;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Models\Playlist;
class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ với danh sách bài hát (có tìm kiếm).
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $songs = Song::with(['artist', 'genre'])
            ->when($keyword, function ($query, $keyword) {
                $query->where('title', 'like', "%$keyword%")
                      ->orWhereHas('artist', fn($q) => $q->where('name', 'like', "%$keyword%"))
                      ->orWhereHas('genre', fn($q) => $q->where('name', 'like', "%$keyword%"));
            })
            ->get();

        return view('frontend.home', compact('songs', 'keyword'));
    }
    
    /**
     * Hiển thị chi tiết bài hát theo ID.
     */
    public function show($id)
    {
        $song = Song::with(['artist', 'genre'])->findOrFail($id);
        return view('frontend.song_detail', compact('song'));
    }
    
    public function genres()
    {
        $genres = Genre::all();
        return view('frontend.genres', compact('genres'));
    }
    public function artists()
{
    $artists = \App\Models\Artist::all();
    return view('frontend.artists', compact('artists'));
}
    public function playlist($name)
{
    $playlist = Playlist::where('name', $name)->firstOrFail(); // Gây lỗi 404 nếu không tìm thấy

    $songs = $playlist->songs()->with(['artist', 'genre'])->get();

    return view('frontend.playlist', compact('playlist', 'songs'));
}

   
}
