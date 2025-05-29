@extends('layouts.admin')
@section('title', 'تفاصيل الدرس')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">{{ $cours->name }}</h2>
        <div>
            <a href="{{ route('admin.cours.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>العودة للدروس
            </a>
            <button class="btn btn-warning edit-course" data-id="{{ $cours->id }}" data-bs-toggle="modal" data-bs-target="#editCoursModal">
                <i class="fas fa-edit me-1"></i>تعديل
            </button>
            <button class="btn btn-danger delete-course" data-id="{{ $cours->id }}">
                <i class="fas fa-trash me-1"></i>حذف
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between">
                    <h5 class="mb-0">معلومات الدرس</h5>
                    <span class="badge {{ $cours->type == 'gratuit' ? 'bg-success' : 'bg-warning' }}">
                        {{ $cours->type == 'gratuit' ? 'مجاني' : 'مدفوع' }}
                    </span>
                </div>
                <div class="card-body">
                    @if($cours->image)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $cours->image) }}" class="img-fluid rounded" alt="{{ $cours->name }}" style="max-height: 300px;">
                    </div>
                    @endif
                    
                    <h5>الوصف</h5>
                    <p>{{ $cours->description }}</p>
                    
                    <h5>التقديم</h5>
                    <p>{{ $cours->presentation }}</p>
                    
                    <div class="d-flex justify-content-between text-muted small">
                        <span>تاريخ الإنشاء: {{ $cours->created_at->format('Y-m-d') }}</span>
                        <span>آخر تحديث: {{ $cours->updated_at->format('Y-m-d') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Files Section -->
            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between">
                    <h5 class="mb-0">الملفات</h5>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addFileModal">
                        <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
                <div class="card-body">
                    @if($cours->fichiers->count() > 0)
                    <ul class="list-group">
                        @foreach($cours->fichiers as $fichier)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-file me-2"></i>
                                <span>{{ $fichier->description }}</span>
                            </div>
                            <div>
                                <a href="{{ asset('storage/' . $fichier->fichier) }}" class="btn btn-sm btn-info" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                                <button class="btn btn-sm btn-danger delete-file" data-id="{{ $fichier->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <div class="text-center py-3">
                        <p class="text-muted">لا توجد ملفات</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Videos Section -->
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between">
                    <h5 class="mb-0">الفيديوهات</h5>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addVideoModal">
                        <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
                <div class="card-body">
                    @if($cours->videos->count() > 0)
                    <div class="accordion" id="videosAccordion">
                        @foreach($cours->videos as $index => $video)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                                    {{ $video->description }}
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#videosAccordion">
                                <div class="accordion-body">
                                    @if(Str::contains($video->video, ['youtube.com', 'youtu.be']))
                                    <div class="ratio ratio-16x9">
                                        <iframe src="{{ Str::contains($video->video, 'embed') ? $video->video : 'https://www.youtube.com/embed/' . Str::after($video->video, 'v=') }}" title="{{ $video->description }}" allowfullscreen></iframe>
                                    </div>
                                    @else
                                    <video controls class="w-100">
                                        <source src="{{ asset('storage/' . $video->video) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    @endif
                                    <div class="mt-2 text-end">
                                        <button class="btn btn-sm btn-danger delete-video" data-id="{{ $video->id }}">
                                            <i class="fas fa-trash me-1"></i>حذف
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-3">
                        <p class="text-muted">لا توجد فيديوهات</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add File Modal -->
<div class="modal fade" id="addFileModal" tabindex="-1" aria-labelledby="addFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFileModalLabel">إضافة ملف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.cours.fichier.store', $cours->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file_description" class="form-label">وصف الملف</label>
                        <input type="text" class="form-control" id="file_description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="fichier" class="form-label">الملف</label>
                        <input type="file" class="form-control" id="fichier" name="fichier" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Video Modal -->
<div class="modal fade" id="addVideoModal" tabindex="-1" aria-labelledby="addVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVideoModalLabel">إضافة فيديو</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.cours.video.store', $cours->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="video_description" class="form-label">وصف الفيديو</label>
                        <input type="text" class="form-control" id="video_description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="video_type" class="form-label">نوع الفيديو</label>
                        <select class="form-select" id="video_type" name="video_type">
                            <option value="file">ملف فيديو</option>
                            <option value="youtube">رابط يوتيوب</option>
                        </select>
                    </div>
                    <div class="mb-3" id="video_file_container">
                        <label for="video_file" class="form-label">ملف الفيديو</label>
                        <input type="file" class="form-control" id="video_file" name="video_file">
                    </div>
                    <div class="mb-3 d-none" id="video_url_container">
                        <label for="video_url" class="form-label">رابط الفيديو</label>
                        <input type="text" class="form-control" id="video_url" name="video_url" placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Course Modal (same as in cours.blade.php) -->
<div class="modal fade" id="editCoursModal" tabindex="-1" aria-labelledby="editCoursModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCoursModalLabel">تعديل الدرس</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCoursForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">اسم الدرس</label>
                        <input type="text" class="form-control" id="edit_name" name="name" value="{{ $cours->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">وصف الدرس</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3">{{ $cours->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_presentation" class="form-label">تقديم الدرس</label>
                        <textarea class="form-control" id="edit_presentation" name="presentation" rows="3">{{ $cours->presentation }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_type" class="form-label">نوع الدرس</label>
                        <select class="form-select" id="edit_type" name="type" required>
                            <option value="gratuit" {{ $cours->type == 'gratuit' ? 'selected' : '' }}>مجاني</option>
                            <option value="payant" {{ $cours->type == 'payant' ? 'selected' : '' }}>مدفوع</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">صورة الدرس</label>
                        <input type="file" class="form-control" id="edit_image" name="image">
                        @if($cours->image)
                        <div class="mt-2">
                            <p>الصورة الحالية:</p>
                            <img src="{{ asset('storage/' . $cours->image) }}" alt="{{ $cours->name }}" class="img-thumbnail" style="max-height: 100px">
                        </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Toggle video input type
        $('#video_type').change(function() {
            if ($(this).val() === 'file') {
                $('#video_file_container').removeClass('d-none');
                $('#video_url_container').addClass('d-none');
            } else {
                $('#video_file_container').addClass('d-none');
                $('#video_url_container').removeClass('d-none');
            }
        });
        
        // Set form action for edit
        $('#editCoursForm').attr('action', "{{ route('admin.cours.update', $cours->id) }}");
        
        // Delete course
        $('.delete-course').click(function() {
            if (confirm('هل أنت متأكد من حذف هذا الدرس؟')) {
                $.ajax({
                    url: "{{ route('admin.cours.destroy', $cours->id) }}",
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        window.location.href = "{{ route('admin.cours.index') }}";
                    }
                });
            }
        });
        
        // Delete file
        $('.delete-file').click(function() {
            const fileId = $(this).data('id');
            
            if (confirm('هل أنت متأكد من حذف هذا الملف؟')) {
                $.ajax({
                    url: `/admin/cours/fichier/${fileId}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        location.reload();
                    }
                });
            }
        });
        
        // Delete video
        $('.delete-video').click(function() {
            const videoId = $(this).data('id');
            
            if (confirm('هل أنت متأكد من حذف هذا الفيديو؟')) {
                $.ajax({
                    url: `/admin/cours/video/${videoId}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        location.reload();
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection