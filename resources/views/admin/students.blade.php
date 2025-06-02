@extends('layouts.admin')
@section('title', 'إدارة الطلاب')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">إدارة الطلاب</h2>
    <!-- فيلتر حسب المجموعة -->
    <form method="GET" class="mb-3">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <label for="groupe_id" class="col-form-label">فلتر حسب المجموعة:</label>
            </div>
            <div class="col-auto">
                <select name="groupe_id" id="groupe_id" class="form-select" onchange="this.form.submit()">
                    <option value="">كل المجموعات</option>
                    @foreach($groupes as $groupe)
                        <option value="{{ $groupe->id }}" {{ isset($selectedGroupe) && $selectedGroupe == $groupe->id ? 'selected' : '' }}>{{ $groupe->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">إضافة طالب</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الاسم الكامل</th>
                <th>الإيميل</th>
                <th>الشعبة</th>
                <th>المجموعة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td>{{ $student->user->email }}</td>
                    <td>
                        @foreach($student->filiers as $filier)
                            <span class="badge bg-info">{{ $filier->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach($student->groupes as $groupe)
                            <span class="badge bg-secondary">{{ $groupe->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <!-- زر التعديل -->
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editStudentModal{{ $student->id }}">
                            <i class="fa fa-edit"></i>
                        </button>
                        <!-- زر الحذف -->
                        <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف الطالب؟');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- مودال إضافة طالب -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('admin.students.store') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">إضافة طالب جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">الإيميل</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">كلمة المرور</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">الاسم الشخصي</label>
                    <input type="text" class="form-control" name="first_name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">الاسم العائلي</label>
                    <input type="text" class="form-control" name="last_name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">الشعبة</label>
                    <select class="form-select" name="filier_id" required>
                        <option value="">اختر الشعبة</option>
                        @foreach($filiers as $filier)
                            <option value="{{ $filier->id }}">{{ $filier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">المجموعة</label>
                    <select class="form-select" name="groupe_id" required>
                        <option value="">اختر المجموعة</option>
                        @foreach($groupes as $groupe)
                            <option value="{{ $groupe->id }}">{{ $groupe->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </form>
    </div>
</div>

<!-- جميع مودالات التعديل خارج الجدول -->
@foreach($students as $student)
<div class="modal fade" id="editStudentModal{{ $student->id }}" tabindex="-1" aria-labelledby="editStudentModalLabel{{ $student->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('admin.students.update', $student->id) }}">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel{{ $student->id }}">تعديل الطالب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">الإيميل</label>
                    <input type="email" class="form-control" name="email" value="{{ $student->user->email }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">الاسم الشخصي</label>
                    <input type="text" class="form-control" name="first_name" value="{{ $student->first_name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">الاسم العائلي</label>
                    <input type="text" class="form-control" name="last_name" value="{{ $student->last_name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">الشعبة</label>
                    <select class="form-select" name="filier_id" required>
                        @foreach($filiers as $filier)
                            <option value="{{ $filier->id }}" {{ $student->filiers->contains($filier->id) ? 'selected' : '' }}>{{ $filier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">المجموعة</label>
                    <select class="form-select" name="groupe_id" required>
                        @foreach($groupes as $groupe)
                            <option value="{{ $groupe->id }}" {{ $student->groupes->contains($groupe->id) ? 'selected' : '' }}>{{ $groupe->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="submit" class="btn btn-warning">تحديث</button>
            </div>
        </form>
    </div>
</div>
@endforeach
@endsection