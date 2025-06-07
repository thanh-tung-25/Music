<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // Một thể loại có nhiều bài hát
    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
