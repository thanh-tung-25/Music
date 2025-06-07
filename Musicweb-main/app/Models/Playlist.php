<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
    ];

    // Danh sách phát thuộc về một người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Danh sách phát có nhiều bài hát (N - N quan hệ)
    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }
}
