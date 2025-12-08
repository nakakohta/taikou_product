@extends('layouts.app')

@section('content')
<div class="container">
    <h1>好きな曲を投稿する</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('songs.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="url">曲のURL</label>
            <input type="url" name="url" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="title">曲名</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="artist">アーティスト名</label>
            <input type="text" name="artist" class="form-control" required>
        </div>

        <div class="form-group">
            <label>ジャンル（複数選択可）</label><br>
            @php
                $genres = ['JPOP', 'KPOP', 'ロック', 'ヒップホップ', 'アニソン', 'ボカロ'];
            @endphp
            @foreach($genres as $genre)
                <label>
                    <input type="checkbox" name="genres[]" value="{{ $genre }}"> {{ $genre }}
                </label><br>
            @endforeach

            <label>
                <input type="checkbox" name="genres[]" value="その他" id="genre_other_checkbox"> その他
            </label><br>

            <input type="text" name="genre_other_text" id="genre_other_text" class="form-control" placeholder="ジャンルを入力してください" style="display:none;">
        </div>

        <div class="form-group">
            <label for="comment">好きな理由</label>
            <textarea name="comment" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">投稿する</button>
    </form>
</div>

<script>
    document.getElementById('genre_other_checkbox').addEventListener('change', function() {
        document.getElementById('genre_other_text').style.display = this.checked ? 'block' : 'none';
    });
</script>
@endsection