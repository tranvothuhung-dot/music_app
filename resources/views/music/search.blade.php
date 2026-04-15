<x-music-layout>
    <x-slot name="title">
        Tìm kiếm: {{ $keyword }}
    </x-slot>

    <div class="container py-4">
        <h1 class="mb-3">Kết quả tìm kiếm: "{{ $keyword }}"</h1>

        @if($keyword === '')
            <div class="alert alert-info">Vui lòng nhập từ khóa để tìm kiếm.</div>
        @elseif($songs->isEmpty() && $artists->isEmpty() && $albums->isEmpty())
            <div class="alert alert-warning">Không tìm thấy kết quả nào.</div>
        @else
            @if($songs->isNotEmpty())
                <div class="mb-4">
                    <h2>Bài hát</h2>
                    <ul class="list-group">
                        @foreach($songs as $song)
                            <li class="list-group-item">
                                {{ $song->song_name }} @if(!empty($song->artist_name)) - {{ $song->artist_name }} @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($artists->isNotEmpty())
                <div class="mb-4">
                    <h2>Nghệ sĩ</h2>
                    <ul class="list-group">
                        @foreach($artists as $artist)
                            <li class="list-group-item">{{ $artist->artist_name }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($albums->isNotEmpty())
                <div class="mb-4">
                    <h2>Album</h2>
                    <ul class="list-group">
                        @foreach($albums as $album)
                            <li class="list-group-item">{{ $album->album_name }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif
    </div>
</x-music-layout>
