@extends('layouts.admin')
@section('title', 'لوحة التحكم')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary mb-1">مرحباً بك في لوحة التحكم</h2>
                    <p class="text-muted mb-0">نظرة شاملة على أكاديمية بلاغ</p>
                </div>
                <div class="text-end">
                    <small class="text-muted">{{ Carbon\Carbon::now()->format('d/m/Y - H:i') }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-gradient rounded-3 p-3">
                                <i class="fas fa-user-graduate text-white fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">إجمالي الطلاب</h6>
                            <h3 class="mb-0 text-primary">{{ number_format($totalStudents) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-gradient rounded-3 p-3">
                                <i class="fas fa-chalkboard-teacher text-white fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">إجمالي الأساتذة</h6>
                            <h3 class="mb-0 text-success">{{ number_format($totalTeachers) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-gradient rounded-3 p-3">
                                <i class="fas fa-book text-white fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">إجمالي الدورات</h6>
                            <h3 class="mb-0 text-warning">{{ number_format($totalCourses) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-gradient rounded-3 p-3">
                                <i class="fas fa-clipboard-list text-white fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">إجمالي الامتحانات</h6>
                            <h3 class="mb-0 text-info">{{ number_format($totalExams) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الرسوم البيانية والإحصائيات -->
    <div class="row g-4 mb-4">
        <!-- رسم بياني للطلاب الجدد -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">الطلاب الجدد هذا العام</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-chart-line me-1"></i> عرض
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="updateChart('students')">الطلاب</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateChart('courses')">الدورات</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="100"></canvas>
                </div>
            </div>
        </div>
        
        <!-- إحصائيات الدورات -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">توزيع الدورات</h5>
                </div>
                <div class="card-body">
                    <canvas id="coursesChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- الجداول والقوائم -->
    <div class="row g-4">
        <!-- آخر الطلاب المسجلين -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">آخر الطلاب المسجلين</h5>
                        <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-outline-primary">عرض الكل</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>تاريخ التسجيل</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentStudents as $student)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <img src="{{ $student->user->profile_image ?? '/images/student.png' }}" 
                                                     alt="{{ $student->user->first_name }}" 
                                                     class="rounded-circle" width="32" height="32">
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $student->user->first_name }} {{ $student->user->last_name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $student->user->email }}</td>
                                    <td>
                                        <small class="text-muted">{{ $student->created_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                        لا توجد بيانات
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- آخر الدورات المضافة -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">آخر الدورات المضافة</h5>
                        <a href="{{ route('admin.cours.index') }}" class="btn btn-sm btn-outline-primary">عرض الكل</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>اسم الدورة</th>
                                    <th>النوع</th>
                                    <th>تاريخ الإضافة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCourses as $course)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <img src="{{ $course->image ?? '/images/book-check.png' }}" 
                                                     alt="{{ $course->name }}" 
                                                     class="rounded" width="32" height="32">
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ Str::limit($course->name, 30) }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $course->type == 'free' ? 'success' : 'warning' }}">
                                            {{ $course->type == 'free' ? 'مجاني' : 'مدفوع' }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $course->created_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="fas fa-book fa-2x mb-2 d-block"></i>
                                        لا توجد دورات
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات إضافية -->
    <div class="row g-3 mt-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="fas fa-layer-group text-primary fa-2x mb-2"></i>
                    <h4 class="text-primary">{{ number_format($totalSubjects) }}</h4>
                    <p class="text-muted mb-0">المواد الدراسية</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="fas fa-play-circle text-success fa-2x mb-2"></i>
                    <h4 class="text-success">{{ number_format($totalLessons) }}</h4>
                    <p class="text-muted mb-0">الدروس</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="fas fa-users text-warning fa-2x mb-2"></i>
                    <h4 class="text-warning">{{ number_format($totalGroups) }}</h4>
                    <p class="text-muted mb-0">المجموعات</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="fas fa-graduation-cap text-info fa-2x mb-2"></i>
                    <h4 class="text-info">{{ number_format($totalFiliers) }}</h4>
                    <p class="text-muted mb-0">التخصصات</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// رسم بياني للطلاب الشهري
const monthlyData = @json($monthlyStudents);
const monthNames = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 
                   'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];

const monthlyChart = new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: monthlyData.map(item => monthNames[item.month - 1]),
        datasets: [{
            label: 'الطلاب الجدد',
            data: monthlyData.map(item => item.count),
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// رسم بياني للدورات
const coursesData = @json($coursesByType);
const coursesChart = new Chart(document.getElementById('coursesChart'), {
    type: 'doughnut',
    data: {
        labels: coursesData.map(item => item.type === 'free' ? 'مجاني' : 'مدفوع'),
        datasets: [{
            data: coursesData.map(item => item.count),
            backgroundColor: ['#198754', '#ffc107'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// تحديث الرسم البياني
function updateChart(type) {
    fetch(`{{ route('admin.dashboard.chart-data') }}?type=${type}`)
        .then(response => response.json())
        .then(data => {
            monthlyChart.data.labels = data.map(item => monthNames[item.month - 1]);
            monthlyChart.data.datasets[0].data = data.map(item => item.count);
            monthlyChart.data.datasets[0].label = type === 'students' ? 'الطلاب الجدد' : 'الدورات الجديدة';
            monthlyChart.update();
        });
}
</script>
@endsection