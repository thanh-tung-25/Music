@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>Chi tiết Người Dùng</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center">
                    @if($user->avatar)
                        <img src="{{ secure_asset('storage/' . $user->avatar) }}" 
                             alt="{{ $user->name }}" 
                             class="img-fluid rounded-circle mb-3" 
                             style="max-width: 200px;">
                    @else
                        <img src="{{ secure_asset('images/no-avt.jpg') }}" 
                             alt="{{ $user->name }}" 
                             class="img-fluid rounded-circle mb-3" 
                             style="max-width: 200px;">
                    @endif
                </div>
                <div class="col-md-9">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">ID</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>Tên</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Vai trò</th>
                            <td>
                                <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'artist' ? 'success' : 'info') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Ngày tạo</th>
                            <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối</th>
                            <td>{{ $user->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete(this)">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(button) {
        if (confirm('Bạn có chắc chắn muốn xóa người dùng này không?')) {
            button.parentElement.submit();
        }
    }
</script>
@endsection
