<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'url',
        'title',
        'artist',
        'genre',
        'comment',
        'thumbnail', // 使ってないなら消してOK（あっても問題なし）
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // ✅ favoritesテーブル（1対多）
    public function favorites()
    {
        return $this->hasMany(\App\Models\Favorite::class, 'song_id');
    }

    // ✅ お気に入りしたユーザー（便利：必要なら）
    public function favoritedBy()
    {
        return $this->belongsToMany(\App\Models\User::class, 'favorites')->withTimestamps();
    }
}
