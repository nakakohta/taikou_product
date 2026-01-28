<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Song;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle($songId)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $song = Song::findOrFail($songId);

        $exists = Favorite::where('user_id', $user->id)
            ->where('song_id', $song->id)
            ->exists();

        if ($exists) {
            Favorite::where('user_id', $user->id)
                ->where('song_id', $song->id)
                ->delete();
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'song_id' => $song->id,
            ]);
        }

        return back();
    }
}
