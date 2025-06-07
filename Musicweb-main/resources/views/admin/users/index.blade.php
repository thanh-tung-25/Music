@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>Quản lý Người Dùng</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm Người Dùng
            </a>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <form action="{{ route('users.index') }}" method="GET" id="searchForm">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control"
                                placeholder="Nhập từ khóa..."
                                value="{{ request('keyword') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="search_by" class="form-control">
                            <option value="all" {{ request('search_by') == 'all' ? 'selected' : '' }}>Tất cả</option>
                            <option value="id" {{ request('search_by') == 'id' ? 'selected' : '' }}>ID</option>
                            <option value="name" {{ request('search_by') == 'name' ? 'selected' : '' }}>Tên</option>
                            <option value="email" {{ request('search_by') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="role" {{ request('search_by') == 'role' ? 'selected' : '' }}>Vai trò</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="role" class="form-control">
                            <option value="">Tất cả vai trò</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="artist" {{ request('role') == 'artist' ? 'selected' : '' }}>Artist</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-4">
                        <select name="per_page" class="form-control">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 mục</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 mục</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 mục</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 mục</option>
                            <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Tất cả</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="sort_by" class="form-control">
                            <option value="id_desc" {{ request('sort_by') == 'id_desc' ? 'selected' : '' }}>ID (Mới nhất)</option>
                            <option value="id_asc" {{ request('sort_by') == 'id_asc' ? 'selected' : '' }}>ID (Cũ nhất)</option>
                            <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Tên (A-Z)</option>
                            <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Tên (Z-A)</option>
                        </select>
                    </div>
                    <div class="col-md-4 text-right">
                        <button type="reset" class="btn btn-secondary" id="resetSearch">
                            <i class="fas fa-redo"></i> Đặt lại
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        @if($user->avatar)
                        <img src="{{ secure_asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="img-thumbnail" style="max-height: 50px;">
                        @else
                        <img src="{{ secure_asset('images/no-avt.jpg') }}" alt="{{ $user->name }}" class="img-thumbnail" style="max-height: 50px;">
                        @endif
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'artist' ? 'success' : 'info') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Xem
                        </a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
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
        object-fit: cover;
    }
</style>

<script>
    function confirmDelete(button) {
        if (confirm('Bạn có chắc chắn muốn xóa người dùng này không?')) {
            button.parentElement.submit();
        }
    }

    document.getElementById('resetSearch').addEventListener('click', function(e) {
        e.preventDefault();
        window.location.href = "{{ route('users.index') }}";
    });

    document.querySelectorAll('select[name="per_page"], select[name="sort_by"], select[name="role"]')
        .forEach(select => {
            select.addEventListener('change', function() {
                document.getElementById('searchForm').submit();
            });
        });
</script>@endsection