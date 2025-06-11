@extends('layouts.frontend')

@section('content')

    <h2 class="text-3xl font-bold mb-6">🎼 Danh sách thể loại</h2>

    <div class="grid md:grid-cols-3 gap-6">
        @forelse($genres as $genre)
            <div class="bg-gradient-to-br from-purple-600 to-indigo-700 text-white rounded-lg p-6 shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1">
                <h3 class="text-2xl font-bold mb-2">{{ $genre->name }}</h3>
                <p class="text-sm text-purple-200">{{ $genre->description ?? 'Không có mô tả' }}</p>
            </div>
        @empty
            <p class="text-gray-400">Không có thể loại nào được tìm thấy.</p>
        @endforelse
    </div>

@endsection
