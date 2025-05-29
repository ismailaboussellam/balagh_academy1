@extends('student.app.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">{{ $lesson->title }}</h4>
                </div>
                <div class="card-body">

                    @if(Str::contains($lesson->video_url, 'youtube.com') || Str::contains($lesson->video_url, 'youtu.be'))
                        <!-- YouTube iframe -->
                        <div class="embed-responsive embed-responsive-16by9 mb-3">
                            <iframe class="embed-responsive-item w-100" height="400"
                                src="{{ Str::contains($lesson->video_url, 'watch?v=')
                                    ? str_replace('watch?v=', 'embed/', $lesson->video_url)
                                    : str_replace('youtu.be/', 'youtube.com/embed/', $lesson->video_url) }}"
                                allowfullscreen></iframe>
                        </div>
                    @else
                        <!-- Video from storage or direct URL -->
                        <video width="100%" height="400" controls class="mb-3">
                            <source src="{{ asset($lesson->video_url) }}" type="video/mp4">
                            المتصفح لا يدعم تشغيل الفيديو.
                        </video>
                    @endif

                    @if($lesson->description)
                        <div class="mt-3 text-muted">
                            {!! nl2br(e($lesson->description)) !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
