<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ với danh sách bài hát.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Eager loading quan hệ artist và genre để giảm truy vấn N+1
        $songs = Song::with(['artist', 'genre'])->get();

        // Trả về view 'frontend.home' và truyền biến $songs
        return view('frontend.home', compact('songs'));
    }
    public function show($id)
{
    $song = Song::with(['artist', 'genre'])->findOrFail($id);
    return view('frontend.song_detail', compact('song'));
}

}
