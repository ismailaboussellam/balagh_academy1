@extends('layouts.admin')
@section('title', 'إدارة الدروس')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">إدارة الدروس</h2>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCoursModal">
            <i class="fas fa-plus-circle me-2"></i>إضافة درس جديد
        </button>
    </div>

    <!-- Filter Buttons -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">تصفية الدروس</h5>
        </div>
        <div class="card-body">
            <div class="btn-group w-100" role="group">
                <button type="button" class="btn btn-outline-primary active filter-btn" data-filter="all">جميع الدروس</button>
                <button type="button" class="btn btn-outline-success filter-btn" data-filter="gratuit">دروس مجانية</button>
                <button type="button" class="btn btn-outline-warning filter-btn" data-filter="payant">دروس مدفوعة</button>
            </div>
        </div>
    </div>

    <!-- Courses Cards -->
    <div class="row" id="coursesContainer">
        @forelse($cours as $course)
        <div class="col-md-4 mb-4 course-card" data-type="{{ $course->type }}">
            <div class="card h-100 shadow-sm">
                <div class="position-relative">
                    @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->name }}" style="height: 200px; object-fit: cover;">
                    @else
                    <div class="bg-light text-center py-5">
                        <i class="fas fa-book fa-3x text-secondary"></i>
                    </div>
                    @endif
                    <div class="position-absolute top-0 end-0 p-2">
                        <span class="badge {{ $course->type == 'gratuit' ? 'bg-success' : 'bg-warning' }}">
                            {{ $course->type == 'gratuit' ? 'مجاني' : 'مدفوع' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $course->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($course->description, 100) }}</p>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between">
                    <a href="{{ route('admin.cours.details', $course->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye me-1"></i>التفاصيل
                    </a>
                    <div>
                        <button class="btn btn-sm btn-warning edit-course" data-id="{{ $course->id }}" data-bs-toggle="modal" data-bs-target="#editCoursModal">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-course" data-id="{{ $course->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>لا توجد دروس متاحة حاليا
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Add Course Modal -->
<div class="modal fade" id="addCoursModal" tabindex="-1" aria-labelledby="addCoursModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCoursModalLabel">إضافة درس جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.cours.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">اسم الدرس</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">وصف الدرس</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="presentation" class="form-label">تقديم الدرس</label>
                        <textarea class="form-control" id="presentation" name="presentation" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">نوع الدرس</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="gratuit">مجاني</option>
                            <option value="payant">مدفوع</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">صورة الدرس</label>
                        <input type="file" class="form-control" id="image" name="image">
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

<!-- Edit Course Modal -->
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
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">وصف الدرس</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_presentation" class="form-label">تقديم الدرس</label>
                        <textarea class="form-control" id="edit_presentation" name="presentation" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_type" class="form-label">نوع الدرس</label>
                        <select class="form-select" id="edit_type" name="type" required>
                            <option value="gratuit">مجاني</option>
                            <option value="payant">مدفوع</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">صورة الدرس</label>
                        <input type="file" class="form-control" id="edit_image" name="image">
                        <div id="current_image_container" class="mt-2"></div>
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
        // Filter courses
        $('.filter-btn').on('click', function() {
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            
            const filter = $(this).data('filter');
            console.log('Filter clicked:', filter); // Debug line
            
            if (filter === 'all') {
                $('.course-card').show();
            } else {
                $('.course-card').hide();
                $(`.course-card[data-type="${filter}"]`).show();
            }
        });
        
        // Delete course
        $('.delete-course').on('click', function() {
            const courseId = $(this).data('id');
            
            if (confirm('هل أنت متأكد من حذف هذا الدرس؟')) {
                $.ajax({
                    url: `/admin/cours/${courseId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success) {
                            window.location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('حدث خطأ أثناء حذف الدرس');
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection