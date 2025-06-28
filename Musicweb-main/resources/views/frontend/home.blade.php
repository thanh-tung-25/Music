@extends('layouts.frontend')

@section('content')
    <h2 class="text-3xl font-bold mb-6 text-purple-400">🎵 Danh sách bài hát</h2>

    <!-- Form tìm kiếm -->
    <form action="{{ route('music.index') }}" method="GET" class="mb-6">
     @csrf 
        <input type="text" name="keyword" placeholder="Tìm kiếm bài hát..." value="{{ request('keyword') }}"
               class="px-4 py-2 rounded text-black w-1/2">
        <button type="submit" class="ml-2 px-4 py-2 bg-purple-600 rounded text-white hover:bg-purple-700">
            Tìm
        </button>
    </form>

    @if($songs->isEmpty())
        <p class="text-gray-400">Không có bài hát nào được tìm thấy.</p>
    @else
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($songs as $song)
                <div class="bg-gray-800 rounded-lg shadow-md p-4 flex flex-col items-center transition transform hover:scale-105 duration-300">
                    <div class="w-full h-48 bg-cover bg-center rounded-lg mb-4" style="background-image: url('/images/music-cover.jpg');"></div>

                    <h3 class="text-xl font-semibold text-white mb-1">{{ $song->title }}</h3>
                    <p class="text-sm text-gray-400">{{ $song->artist->name ?? 'Không rõ nghệ sĩ' }}</p>
                    <p class="text-sm text-gray-500 mb-2">{{ $song->genre->name ?? 'Thể loại khác' }}</p>

                    <audio controls class="w-full mt-2">
                        <source src="{{ asset('storage/' . $song->file_url) }}" type="audio/mpeg">
                        Trình duyệt của bạn không hỗ trợ trình phát nhạc.
                    </audio>

                    <a href="{{ route('music.show', $song->id) }}"
                       class="mt-3 text-sm text-purple-300 hover:underline">
                        ▶️ Xem chi tiết
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Playlist nổi bật -->
    <div class="mt-12">
        <h2 class="text-3xl font-bold mb-4 text-purple-400">🔥 Playlist nổi bật</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <a href="{{ route('music.playlist', ['name' => 'Chill Vibes']) }}"
            class="bg-purple-700 p-6 rounded-lg shadow-lg text-white hover:bg-purple-800 transition block">
                <h3 class="text-2xl font-bold mb-2">🎧 Chill Vibes</h3>
                <p class="text-sm text-purple-100">Âm nhạc thư giãn mỗi ngày.</p>
            </a>
            <a href="{{ route('music.playlist', ['name' => 'Trending']) }}"
            class="bg-blue-700 p-6 rounded-lg shadow-lg text-white hover:bg-blue-800 transition block">
                <h3 class="text-2xl font-bold mb-2">🔥 Trending</h3>
                <p class="text-sm text-blue-100">Top hit đang hot nhất hiện nay.</p>
            </a>
            <a href="{{ route('music.playlist', ['name' => 'Buồn Lặng']) }}"
            class="bg-pink-600 p-6 rounded-lg shadow-lg text-white hover:bg-pink-700 transition block">
                <h3 class="text-2xl font-bold mb-2">💔 Buồn Lặng</h3>
                <p class="text-sm text-pink-100">Những giai điệu sâu lắng cho tâm trạng.</p>
            </a>
        </div>
    </div>

    
@endsection
