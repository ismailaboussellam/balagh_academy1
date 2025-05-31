@extends('partials.myapp')

@section('title', 'الدروس المتاحة')

@section('styles')
<style>
    .course-card-item {
        transition: transform .2s, box-shadow .2s;
        cursor: pointer;
    }
    .course-card-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.1);
    }
    .course-card-item .card-img-top {
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid #eee;
    }
    .course-card-item .badge {
        font-size: 0.9em;
    }
    .filter-btn-group .btn {
        margin: 0 5px;
    }
    .modal-body-course-details {
        max-height: 70vh;
        overflow-y: auto;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="mb-3">اكتشف دروسنا</h1>
            <div class="d-flex justify-content-center my-4 filter-btn-group">
                <button type="button" class="btn btn-primary active filter-btn" data-filter="all">جميع الدروس</button>
                <button type="button" class="btn btn-success filter-btn" data-filter="gratuit">دروس مجانية</button>
                <button type="button" class="btn btn-warning filter-btn" data-filter="payant">دروس مدفوعة</button>
            </div>
        </div>
    </div>

    <div class="row" id="coursesContainer">
        @forelse($cours as $course)
        <div class="col-lg-4 col-md-6 mb-4 course-card" data-type="{{ $course->type }}">
            <div class="card h-100 shadow-sm course-card-item" 
                 data-id="{{ $course->id }}" 
                 data-type="{{ $course->type }}" 
                 data-bs-toggle="modal" 
                 data-bs-target="#courseDetailModal"
                 style="cursor:pointer;">
                <div class="position-relative">
                    @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->name }}">
                    @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-book fa-4x text-secondary"></i>
                    </div>
                    @endif
                    <div class="position-absolute top-0 end-0 p-2">
                        <span class="badge {{ $course->type == 'gratuit' ? 'bg-success' : 'bg-warning' }} p-2">
                            {{ $course->type == 'gratuit' ? 'مجاني' : 'مدفوع' }}
                        </span>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-2">{{ $course->name }}</h5>
                    <p class="card-text text-muted small flex-grow-1">{{ Str::limit($course->description, 120) }}</p>
                    <div class="mt-auto">
                        <button class="btn btn-sm btn-outline-primary w-100 show-details-btn" type="button">
                            عرض التفاصيل
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="alert alert-light">
                    <i class="fas fa-info-circle fa-2x text-primary mb-2"></i>
                    <h4 class="alert-heading">لا توجد دروس متاحة حالياً</h4>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Course Detail Modal -->
<div class="modal fade" id="courseDetailModal" tabindex="-1" aria-labelledby="courseDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="courseDetailModalLabel">تفاصيل الدرس</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-course-details">
                <div id="courseInfoSection">
                    <div class="text-center mb-3">
                        <img id="modalCourseImage" src="" class="img-fluid rounded" alt="صورة الدرس" style="max-height: 250px; display:none;">
                    </div>
                    <h3 id="modalCourseName" class="mb-3"></h3>
                    <h5>الوصف:</h5>
                    <p id="modalCourseDescription"></p>
                    <h5>التقديم:</h5>
                    <p id="modalCoursePresentation"></p>
                </div>
                <!-- Payment form (hidden by default) -->
                <div id="paymentFormSection" style="display: none;" class="mt-4 pt-4 border-top">
                    <h4>إتمام عملية الدفع</h4>
                    <form id="paymentForm" method="POST">
                        @csrf
                        <input type="hidden" id="paymentCourseId" name="course_id">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">الاسم الكامل</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">رقم الهاتف</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">طريقة الدفع</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" checked>
                                <label class="form-check-label" for="bank_transfer">تحويل بنكي</label>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <p><strong>سعر الدرس:</strong> <span id="modalCoursePrice">100 درهم</span></p>
                        </div>
                        <button type="submit" class="btn btn-success w-100" id="submitPaymentBtn">تأكيد الدفع</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <a href="#" id="learnButton" class="btn btn-primary" style="display: none;">
                    <i class="fas fa-graduation-cap me-1"></i>ابدأ التعلم
                </a>
                <button type="button" id="payButton" class="btn btn-warning" style="display: none;">
                    <i class="fas fa-credit-card me-1"></i>الدفع للالتحاق
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let currentCourseId = null;
    let currentCourseType = null;

    // Filter courses
    $('.filter-btn').click(function() {
        $('.filter-btn').removeClass('btn-primary btn-success btn-warning active').addClass('btn-outline-secondary');
        $(this).removeClass('btn-outline-secondary');
        const filter = $(this).data('filter');
        
        if (filter === 'all') {
            $(this).addClass('btn-primary active');
            $('.course-card').fadeIn('fast');
        } else {
            if (filter === 'gratuit') $(this).addClass('btn-success active');
            if (filter === 'payant') $(this).addClass('btn-warning active');
            $('.course-card').hide();
            $(`.course-card[data-type="${filter}"]`).fadeIn('fast');
        }
    });

    // Only trigger modal when clicking the "عرض التفاصيل" button
    $('.show-details-btn').click(function(e) {
        e.stopPropagation();
        const $card = $(this).closest('.course-card-item');
        currentCourseId = $card.data('id');
        $('#paymentFormSection').hide();
        $('#courseInfoSection').show();
        $('#learnButton').hide();
        $('#payButton').hide();

        // Show spinner while loading
        $('#modalCourseName').text('جاري التحميل...');
        $('#modalCourseDescription').text('');
        $('#modalCoursePresentation').text('');
        $('#modalCourseImage').hide();

        // Open modal
        $('#courseDetailModal').modal('show');

        $.get(`/cours/${currentCourseId}/details`, function(data) {
            $('#modalCourseName').text(data.name);
            $('#modalCourseDescription').text(data.description || 'لا يوجد وصف متاح.');
            $('#modalCoursePresentation').text(data.presentation || 'لا يوجد تقديم متاح.');
            $('#courseDetailModalLabel').text(data.name);

            if(data.image) {
                $('#modalCourseImage').attr('src', data.image).show();
            } else {
                $('#modalCourseImage').hide();
            }

            currentCourseType = data.type;
            $('#paymentCourseId').val(currentCourseId);

            if (currentCourseType === 'gratuit') {
                $('#learnButton').attr('href', `/cours/${currentCourseId}/learn`).show();
                $('#payButton').hide();
            } else {
                $('#payButton').show();
                $('#learnButton').hide();
                $('#modalCoursePrice').text('100 درهم');
            }
        }).fail(function() {
            $('#modalCourseName').text('خطأ في تحميل البيانات');
        });
    });

    // Show payment form when clicking the pay button
    $('#payButton').click(function() {
        $('#courseInfoSection').hide();
        $('#paymentFormSection').show();
        $(this).hide();
    });

    // Handle payment form submission
    $('#paymentForm').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        // Show loading state
        $('#submitPaymentBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> جاري المعالجة...');
        
        // Submit payment
        $.ajax({
            url: `/cours/${currentCourseId}/payment`,
            type: 'POST',
            data: formData,
            success: function(response) {
                // Redirect to course page
                window.location.href = `/cours/${currentCourseId}/learn`;
            },
            error: function(xhr) {
                // Show error
                alert('حدث خطأ أثناء معالجة الدفع. يرجى المحاولة مرة أخرى.');
                $('#submitPaymentBtn').prop('disabled', false).text('تأكيد الدفع');
            }
        });
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush