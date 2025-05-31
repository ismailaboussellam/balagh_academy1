@extends('partials.myapp')

@section('title', 'تفاصيل الدرس')

@section('content')
<style>
    .cours-container {
        max-width: 1000px;
        margin: 40px auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        padding: 32px 24px;
        font-family: 'Tajawal', Arial, sans-serif;
    }
    .cours-title {
        text-align: center;
        color: #2563eb;
        font-size: 2.2rem;
        font-weight: bold;
        margin-bottom: 18px;
    }
    .cours-desc {
        color: #444;
        font-size: 1.1rem;
        margin-bottom: 18px;
        text-align: right;
    }
    .cours-section-title {
        color: #0d6efd;
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 10px;
        margin-top: 30px;
    }
    .videos-list, .files-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .video-item, .file-item {
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 18px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .video-desc {
        font-weight: bold;
        margin-bottom: 8px;
        color: #198754;
    }
    .video-player {
        width: 100%;
        border-radius: 6px;
        background: #222;
    }
    .file-link {
        display: inline-block;
        background: #2563eb;
        color: #fff;
        padding: 6px 18px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 1rem;
        transition: background 0.2s;
        margin-right: 10px;
    }
    .file-link:hover {
        background: #1746a2;
    }
    .no-data {
        background: #fff3cd;
        color: #856404;
        padding: 14px;
        border-radius: 7px;
        text-align: center;
        margin-bottom: 18px;
        font-size: 1.1rem;
    }
    @media (max-width: 800px) {
        .cours-container { padding: 16px 4px; }
    }
</style>

<div class="cours-container">
    <div class="cours-title">{{ $cours->name }}</div>
    <div class="cours-desc">{{ $cours->description }}</div>
    <div class="cours-section-title">التقديم:</div>
    <div class="cours-desc">{{ $cours->presentation }}</div>

    <div class="cours-section-title">الفيديوهات</div>
    @if($videos->count())
        <ul class="videos-list">
            @foreach($videos as $video)
                <li class="video-item">
                    <div class="video-desc">{{ $video->description }}</div>
                    <video class="video-player" controls>
                        <source src="{{ asset('storage/' . $video->video) }}" type="video/mp4">
                        متصفحك لا يدعم الفيديو.
                    </video>
                </li>
            @endforeach
        </ul>
    @else
        <div class="no-data">لا توجد فيديوهات متاحة لهذا الدرس.</div>
    @endif

    <div class="cours-section-title">الملفات</div>
    @if($fichiers->count())
        <ul class="files-list">
            @foreach($fichiers as $fichier)
                <li class="file-item d-flex justify-content-between align-items-center">
                    <span>{{ $fichier->description }}</span>
                    <a href="{{ asset('storage/' . $fichier->fichier) }}" class="file-link" download>تحميل</a>
                </li>
            @endforeach
        </ul>
    @else
        <div class="no-data">لا توجد ملفات متاحة لهذا الدرس.</div>
    @endif
</div>
@endsection