<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /*
      一括割り当て（Mass Assignment）を許可する属性
      ★これが消えると「登録エラー」が出ます
    */
    protected $fillable = [
        'name',
        'email',
        'password',
        'icon',
    ];

    /*
      配列やJSONに変換する際に隠す属性
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
      属性のキャスト
      ★'password' => 'hashed' は削除済みの状態です
    */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ✅ どのページでも同じURLでアイコン表示できる
    protected $appends = ['icon_url'];

    public function getIconUrlAttribute()
    {
        // icon が未設定 → 名前アイコン（UI Avatars）を返す
        // ※外部サービスなので、落ちた時は Blade 側の onerror で文字アイコンに切り替える想定
        if (empty($this->icon)) {
            $name = urlencode($this->name ?? 'User');
            // background=random は見た目が変わりやすいので、固定色の方が安定します（必要ならrandomに戻せます）
            return "https://ui-avatars.com/api/?name={$name}&size=128&background=3b82f6&color=ffffff&bold=true&format=png";
        }

        // icon が設定済み → 保存パスを正規化して返す
        $icon = ltrim((string)$this->icon, '/');

        // すでに http(s) ならそのまま
        if (preg_match('/^https?:\/\//i', $icon)) {
            return $icon;
        }

        // uploads/ または storage/ なら asset() でOK
        if (str_starts_with($icon, 'uploads/') || str_starts_with($icon, 'storage/')) {
            return asset($icon);
        }

        // それ以外は “そのまま public 配下” として扱う（勝手に storage/ を付けない）
        return asset($icon);
    }
}
