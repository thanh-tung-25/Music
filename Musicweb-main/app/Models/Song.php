<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'artist_id',
        'genre_id',
        'file_url',
        'duration',
    ];

    // Bài hát thuộc về một nghệ sĩ
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    // Bài hát thuộc về một thể loại
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    // Bài hát thuộc về nhiều playlist (N-N)
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class);
    }
}
