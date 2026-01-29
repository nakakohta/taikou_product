<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $appends = ['icon_url'];

    public function getIconUrlAttribute()
    {
        if (empty($this->icon)) {
            return asset('images/default_icon.png');
        }

        $icon = ltrim($this->icon, '/');

        // public配下 (uploads/icons/xxx.png)
        if (str_starts_with($icon, 'uploads/')) {
            return asset($icon);
        }

        // すでに storage/ で保存している場合
        if (str_starts_with($icon, 'storage/')) {
            return asset($icon);
        }

        // "icons/xxx.png" など古い保存形式 → storage に寄せる
        return asset('storage/' . $icon);
    }
}
