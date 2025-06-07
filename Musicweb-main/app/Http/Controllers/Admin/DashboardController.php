<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Song;
use App\Models\Artist;
use App\Models\Genre;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $songCount = Song::count();
        $artistCount = Artist::count();
        $genreCount = Genre::count();

        // Truyền dữ liệu sang View
        return view('admin.dashboard', compact('userCount', 'songCount', 'artistCount', 'genreCount'));
    }

}