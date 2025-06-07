@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <h1 class="mb-0">Quản lý Bài Hát</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('songs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm Bài Hát
            </a>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <form action="{{ route('songs.index') }}" method="GET" id="searchForm">
                <div class="row">
                    <!-- Ô nhập từ khóa -->
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa..."
                                value="{{ request('keyword') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Tìm
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Bộ lọc tìm kiếm -->
                    <div class="col-md-3">
                        <select name="search_by" class="form-control">
                            <option value="all" {{ request('search_by') == 'all' ? 'selected' : '' }}>Tất cả</option>
                            <option value="id" {{ request('search_by') == 'id' ? 'selected' : '' }}>ID</option>
                            <option value="title" {{ request('search_by') == 'title' ? 'selected' : '' }}>Tên bài hát</option>
                            <option value="artist_id" {{ request('search_by') == 'artist_id' ? 'selected' : '' }}>Nghệ sĩ</option>
                            <option value="genre_id" {{ request('search_by') == 'genre_id' ? 'selected' : '' }}>Thể loại</option>
                        </select>
                    </div>

                    <!-- Nút đặt lại -->
                    <div class="col-md-2">
                        <button type="button" class="btn btn-secondary btn-block" id="resetSearch">
                            <i class="fas fa-redo"></i> Đặt lại
                        </button>
                    </div>
                </div>

                <div class="row mt-2">
                    <!-- Bộ lọc số lượng hiển thị -->
                    <div class="col-md-3">
                        <select name="per_page" class="form-control">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 mục</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 mục</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 mục</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 mục</option>
                            <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Tất cả</option>
                        </select>
                    </div>

                    <!-- Bộ lọc sắp xếp -->
                    <div class="col-md-3">
                        <select name="sort_by" class="form-control">
                            <option value="id_desc" {{ request('sort_by') == 'id_desc' ? 'selected' : '' }}>ID (Mới nhất)</option>
                            <option value="id_asc" {{ request('sort_by') == 'id_asc' ? 'selected' : '' }}>ID (Cũ nhất)</option>
                            <option value="title_asc" {{ request('sort_by') == 'title_asc' ? 'selected' : '' }}>Tên bài hát (A-Z)</option>
                            <option value="title_desc" {{ request('sort_by') == 'title_desc' ? 'selected' : '' }}>Tên bài hát (Z-A)</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <table class="table table-bordered mt-2">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Tên bài hát</th>
                    <th>Nghệ sĩ</th>
                    <th>Thể loại</th>
                    <th>Thời lượng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($songs as $song)
                <tr>
                    <td>{{ $song->id }}</td>
                    <td>{{ $song->title }}</td>
                    <td>{{ $song->artist->name ?? 'Không xác định' }}</td>
                    <td>{{ $song->genre->name ?? 'Không xác định' }}</td>
                    <td>{{ $song->duration }}</td>
                    <td>
                        <a href="{{ route('songs.show', $song->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Xem
                        </a>
                        <a href="{{ route('songs.edit', $song->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('songs.destroy', $song->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .img-thumbnail {
        border-radius: 50%;
        object-fit: cover;
    }
</style>

<script>
    function confirmDelete(button) {
        if (confirm('Bạn có chắc chắn muốn xóa bài hát này không?')) {
            button.parentElement.submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Chức năng đặt lại tìm kiếm
        document.getElementById('resetSearch').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('input[name="keyword"]').value = '';
            document.querySelector('select[name="search_by"]').value = 'all';
            document.querySelector('select[name="per_page"]').value = '10';
            document.querySelector('select[name="sort_by"]').value = 'id_desc';
            document.getElementById('searchForm').submit();
        });

        document.querySelector('select[name="sort_by"]').addEventListener('change', function() {
            document.getElementById('searchForm').submit();
        });
    });
</script>
@endsection