@extends('adminlte::page')

@section('title', 'Chỉnh Sửa Nghệ Sĩ')

@section('content_header')
<h1 class="m-0 text-dark">Chỉnh Sửa Nghệ Sĩ</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('artists.update', $artist->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Tên nghệ sĩ <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $artist->name) }}" placeholder="Nhập tên nghệ sĩ" required>
                                </div>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="bio">Tiểu sử</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-book"></i>
                                        </span>
                                    </div>
                                    <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" 
                                        rows="4" placeholder="Nhập tiểu sử nghệ sĩ">{{ old('bio', $artist->bio) }}</textarea>
                                </div>
                                @error('bio')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="avatar">Ảnh đại diện</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-image"></i>
                                        </span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="avatar" class="custom-file-input @error('avatar') is-invalid @enderror" id="avatar">
                                        <label class="custom-file-label" for="avatar">Chọn file</label>
                                    </div>
                                </div>
                                @error('avatar')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                
                                @if($artist->avatar)
                                <div class="mt-2">
                                    <img src="{{ secure_asset('storage/' . $artist->avatar) }}" alt="Current avatar" class="img-thumbnail" style="max-height: 200px;">
                                    <p class="text-muted mt-1">Avatar hiện tại</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="float-right">
                                <a href="{{ route('artists.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật
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
<style>
    .card {
        margin-top: 20px;
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
    }

    .input-group-text {
        width: 40px;
        justify-content: center;
    }

    .img-thumbnail {
        object-fit: cover;
    }
    
    .custom-file-label {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý hiển thị tên file khi chọn avatar
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;

            // Preview ảnh
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.img-thumbnail').src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@stop
