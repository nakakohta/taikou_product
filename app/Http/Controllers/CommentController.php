<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $music_id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
            'icon' => 'nullable|image|max:2048', // 2MBまで
        ]);

        // アイコン保存
        $iconPath = null;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('comment_icons', 'public');
        }

        Comment::create([
            'music_id' => $music_id,
            'name' => $request->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'icon' => $iconPath ?? 'default.png', // デフォルト画像
        ]);

        return back()->with('success', 'コメントを投稿しました！');
    }
}
