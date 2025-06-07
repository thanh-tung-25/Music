@extends('adminlte::page')

@section('title', 'Thêm Playlist Mới')

@section('content_header')
<h1>Thêm Playlist Mới</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('playlists.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="title">Tên playlist <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-list"></i>
                                </span>
                            </div>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}" placeholder="Nhập tên playlist" required>
                        </div>
                        @error('title')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="user_id">Người tạo <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                                <option value="">Chọn người tạo</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('user_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="songs">Bài hát <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-music"></i>
                                </span>
                            </div>
                            <select name="songs[]"
                                class="form-control select2 @error('songs') is-invalid @enderror"
                                multiple
                                required
                                data-placeholder="Chọn bài hát"
                                style="width: 100%">
                                @foreach($songs as $song)
                                <option value="{{ $song->id }}"
                                    {{ in_array($song->id, old('songs', $selectedSongs ?? [])) ? 'selected' : '' }}>
                                    {{ $song->title }} - {{ $song->artist->name ?? 'Unknown Artist' }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('songs')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="float-right">
                                <a href="{{ route('playlists.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
<style>
    .select2-container--bootstrap4 .select2-selection--multiple {
        min-height: 38px;
    }
    
    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
        background-color:rgb(152, 199, 250);
        border: none;
        color: #fff;
        padding: 0 8px;
        margin-top: 4px;
    }
    
    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
        margin-right: 5px;
    }
</style>
@stop


@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: 'Chọn bài hát',
            allowClear: true,
            closeOnSelect: false,
            width: '100%',
            language: {
                noResults: function() {
                    return "Không tìm thấy bài hát";
                },
                searching: function() {
                    return "Đang tìm...";
                }
            },
            templateResult: formatSong,
            templateSelection: formatSongSelection
        });
    });

    function formatSong(song) {
        if (!song.id) return song.text;
        return $(`<div>
            <i class="fas fa-music mr-2"></i>
            <span>${song.text}</span>
        </div>`);
    }

    function formatSongSelection(song) {
        if (!song.id) return song.text;
        return $(`<span>
            <i class="fas fa-music mr-1"></i>
            ${song.text}
        </span>`);
    }
</script>
@stop
