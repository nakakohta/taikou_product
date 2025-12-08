
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'genre_id',
        'url',
        'title',
        'artist',
        'comment',
        'thumbnail',   // ← 追加
    ];


    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
