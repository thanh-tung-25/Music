@extends('adminlte::page')

@section('title', 'Chỉnh sửa Bài Hát')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>Chỉnh sửa Bài Hát</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('songs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('songs.update', $song->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Tên bài hát</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $song->title) }}" required>
                </div>

                <div class="form-group">
                    <label for="artist_id">Nghệ sĩ</label>
                    <select name="artist_id" class="form-control" required>
                        @foreach ($artists as $artist)
                            <option value="{{ $artist->id }}" {{ $artist->id == $song->artist_id ? 'selected' : '' }}>
                                {{ $artist->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="genre_id">Thể loại</label>
                    <select name="genre_id" class="form-control" required>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}" {{ $genre->id == $song->genre_id ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="file_url">URL Bài Hát</label>
                    <input type="url" name="file_url" class="form-control" value="{{ old('file_url', $song->file_url) }}" required>
                </div>

                <div class="form-group">
                    <label for="duration">Thời lượng (giây)</label>
                    <input type="number" name="duration" class="form-control" value="{{ old('duration', $song->duration) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection

