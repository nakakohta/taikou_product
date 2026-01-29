<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Song;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();

        // My ベストソング（最新3件）
        $bestSongs = Song::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        // 好きなジャンル（songs.genre が "JPOP, ロック" 形式想定）
        $genres = Song::where('user_id', $user->id)
            ->pluck('genre')
            ->filter()
            ->flatMap(function ($g) {
                return collect(explode(',', $g))
                    ->map(fn ($x) => trim($x))
                    ->filter();
            })
            ->countBy()
            ->sortDesc();

        $favoriteGenres = $genres->keys()->take(8)->values();

        // ✅ 評価ランキング（平均評価：小数1桁）
        $rankRaw = Song::where('user_id', $user->id)
            ->withAvg('votes', 'rating')
            ->orderByDesc('votes_avg_rating')
            ->take(5)
            ->get();

        $maxRating = (float) ($rankRaw->max('votes_avg_rating') ?? 0);

        $ratingRanking = $rankRaw->map(function ($s) use ($maxRating) {
            $avg = $s->votes_avg_rating ? round((float) $s->votes_avg_rating, 1) : 0.0;
            $pct = $maxRating > 0 ? (int) round(($avg / $maxRating) * 90) : 0;

            return [
                'label' => $s->title,
                'count' => $avg,
                'pct'   => $pct,
            ];
        });

        // ✅ お気に入り数ランキング（自分の投稿曲が「何回お気に入りされたか」）
        $favRankRaw = Song::where('user_id', $user->id)
            ->withCount('favorites')
            ->orderByDesc('favorites_count')
            ->take(5)
            ->get();

        $maxFav = (int) ($favRankRaw->max('favorites_count') ?? 0);

        $favoriteRanking = $favRankRaw->map(function ($s) use ($maxFav) {
            $count = (int) $s->favorites_count;
            $pct = $maxFav > 0 ? (int) round(($count / $maxFav) * 90) : 0;

            return [
                'label' => $s->title,
                'count' => $count,
                'pct'   => $pct,
            ];
        });

        // ✅ 投稿した曲（編集/削除用）→ paginate（古い曲も見れる）
        // 2つpaginateを同居させるため page name を分ける
        $mySongs = Song::where('user_id', $user->id)
            ->latest()
            ->paginate(10, ['*'], 'my')
            ->withQueryString();

        // ✅ お気に入り一覧（自分がお気に入りした曲）→ paginate
        $favoriteSongs = Song::whereHas('favorites', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->with('user')
            ->latest()
            ->paginate(10, ['*'], 'fav')
            ->withQueryString();

        return view('profile', compact(
            'user',
            'bestSongs',
            'favoriteGenres',
            'ratingRanking',
            'favoriteRanking',
            'mySongs',
            'favoriteSongs'
        ));
    }

    public function updateIcon(Request $request)
    {
        $request->validate([
            // 形式を絞る（安全側）
            'icon' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $user = Auth::user();
        $file = $request->file('icon');

        // 保存先（public配下）
        $dir = public_path('uploads/icons');

        // ✅ 本番で「mkdir が禁止」「書き込み権限が無い」等でも 500 にしない
        try {
            if (!is_dir($dir)) {
                // 失敗する可能性あり（権限/サーバ設定）
                mkdir($dir, 0755, true);
            }

            if (!is_writable($dir)) {
                // 書けないならアップロードを諦めて戻す（表示は icon_url の頭文字が効く）
                return back()->withErrors([
                    'icon' => '本番環境のサーバ設定上、画像アップロードが許可されていません（保存先の権限がありません）。',
                ]);
            }

            // ファイル名は安全に
            $ext  = strtolower($file->getClientOriginalExtension());
            $name = 'icon_' . Str::uuid()->toString() . '.' . $ext;

            $file->move($dir, $name);

            // DBには public から見える相対パスを保存
            $user->icon = 'uploads/icons/' . $name;
            $user->save();

            return back()->with('success', 'アイコンを更新しました！');
        } catch (\Throwable $e) {
            // ✅ 例外でも落とさない（本番でよく起きる）
            return back()->withErrors([
                'icon' => '本番環境の制限により画像を保存できませんでした。表示はデフォルト（頭文字アイコン）になります。',
            ]);
        }
    }
}
