@extends('student.app.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar: قائمة الدروس -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">قائمة الدروس</h5>
                </div>
                <div class="list-group list-group-flush">
                    @forelse($lessons as $lesson)
                        <a href="{{ route('student.lessons.show', $lesson->id) }}" class="list-group-item list-group-item-action">
                            {{ $lesson->title }}
                        </a>
                    @empty
                        <div class="list-group-item text-center text-muted">
                            لا توجد دروس متاحة حالياً.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main content: تفاصيل الدرس (تفرغ لاحقاً أو حسب اختيار الطالب) -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">تفاصيل الدرس</h4>
                </div>
                <div class="card-body text-center text-muted">
                    المرجو اختيار درس من القائمة على اليسار.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
