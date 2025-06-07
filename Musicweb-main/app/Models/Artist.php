<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'avatar',
    ];

    // Một nghệ sĩ có nhiều bài hát
    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}

