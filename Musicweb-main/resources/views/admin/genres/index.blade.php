@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <h1 class="mb-0">Quản lý Thể Loại</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('genres.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm Thể Loại
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
            <form action="{{ route('genres.index') }}" method="GET" id="searchForm">
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
                            <option value="name" {{ request('search_by') == 'name' ? 'selected' : '' }}>Tên thể loại</option>
                            <option value="description" {{ request('search_by') == 'description' ? 'selected' : '' }}>Mô tả</option>
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
                            <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Tên thể loại (A-Z)</option>
                            <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Tên thể loại (Z-A)</option>
                            <option value="songs_count_desc" {{ request('sort_by') == 'songs_count_desc' ? 'selected' : '' }}>Số bài hát (Nhiều nhất)</option>
                            <option value="songs_count_asc" {{ request('sort_by') == 'songs_count_asc' ? 'selected' : '' }}>Số bài hát (Ít nhất)</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <table class="table table-bordered mt-2">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Tên thể loại</th>
                    <th>Mô tả</th>
                    <th>Số bài hát</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($genres as $genre)
                <tr>
                    <td>{{ $genre->id }}</td>
                    <td>{{ $genre->name }}</td>
                    <td>{{ Str::limit($genre->description, 100) }}</td>
                    <td>{{ $genre->songs_count }}</td>
                    <td>
                        <a href="{{ route('genres.show', $genre->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Xem
                        </a>
                        <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($genres instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="card-footer">
            {{ $genres->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    // Xác nhận xóa
    function confirmDelete(button) {
        if (confirm('Bạn có chắc chắn muốn xóa thể loại này không?')) {
            button.parentElement.submit();
        }
    }

    // Xử lý form tìm kiếm
    document.addEventListener('DOMContentLoaded', function() {
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