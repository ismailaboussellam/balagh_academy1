@extends('layouts.admin')
@section('title', 'إدارة الأساتذة')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">إدارة الأساتذة</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProfModal">إضافة أستاذ</button>

    <!-- لائحة الأساتذة -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الاسم الكامل</th>
                <th>الشعب</th>
                <th>المجموعات</th>
                <th>إجراءات</th>
                {{-- export fichie excel --}}
                <th>استخراج ملف excel</th>
            </tr>
        </thead>
        <tbody>
            @foreach($profs as $prof)
                <tr>
                    <td>
                        @if(optional($prof->teacher)->first_name || optional($prof->teacher)->last_name)
                            {{ optional($prof->teacher)->first_name }} {{ optional($prof->teacher)->last_name }}
                        @else
                            <span class="text-danger">لا يوجد بيانات</span>
                        @endif
                    </td>
                    <td>
                        @foreach(optional($prof->teacher)->filiers ?? [] as $filier)
                            <span class="badge bg-info">{{ $filier->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach(optional($prof->teacher)->groupes ?? [] as $groupe)
                            <span class="badge bg-secondary">{{ $groupe->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @if($prof->teacher)
                        <!-- زر التعديل -->
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editProfModal{{ $prof->teacher->id }}">
                            <i class="fa fa-edit"></i>
                        </button>
                        <!-- زر الحذف -->
                        <form action="{{ route('admin.teachers.destroy', $prof->teacher->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف الأستاذ؟');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                        </form>
                        @endif
                    </td>
                    <td>
                         {{-- export fichie Excel --}}
                        <a href="{{ route('admin.teachers.export', $prof->teacher->id) }}" class="btn btn-sm btn-outline-success">
                                  <i class="fa fa-file-excel"></i>
                        </a>
                    </td>
               
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- جميع المودالات ديال التعديل خارج الجدول -->
@foreach($profs as $prof)
    @if($prof->teacher)
    <div class="modal fade" id="editProfModal{{ $prof->teacher->id }}" tabindex="-1" aria-labelledby="editProfModalLabel{{ $prof->teacher->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('admin.teachers.update', $prof->teacher->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfModalLabel{{ $prof->teacher->id }}">تعديل الأستاذ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">الإيميل</label>
                        <input type="email" class="form-control" name="email" value="{{ $prof->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الاسم الشخصي</label>
                        <input type="text" class="form-control" name="first_name" value="{{ optional($prof->teacher)->first_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الاسم العائلي</label>
                        <input type="text" class="form-control" name="last_name" value="{{ optional($prof->teacher)->last_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الشعب</label>
                        <div>
                            @foreach($filiers as $filier)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="filiers[]" id="editFilier{{ $prof->teacher->id }}_{{ $filier->id }}" value="{{ $filier->id }}"
                                        {{ optional($prof->teacher->filiers)->contains($filier->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="editFilier{{ $prof->teacher->id }}_{{ $filier->id }}">
                                        {{ $filier->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">يمكنك اختيار أكثر من شعبة</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">المجموعات</label>
                        <div>
                            @foreach($groupes as $groupe)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="groupes[]" id="editGroupe{{ $prof->teacher->id }}_{{ $groupe->id }}" value="{{ $groupe->id }}"
                                        {{ optional($prof->teacher->groupes)->contains($groupe->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="editGroupe{{ $prof->teacher->id }}_{{ $groupe->id }}">
                                        {{ $groupe->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">يمكنك اختيار أكثر من مجموعة</small>
                    </div>
                    <!-- باقي المعلومات الشخصية ممكن تزيدهم هنا -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-warning">تحديث</button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endforeach

<!-- Modal: Add Prof -->
<div class="modal fade" id="addProfModal" tabindex="-1" aria-labelledby="addProfModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('admin.teachers.store') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addProfModalLabel">إضافة أستاذ جديد</h5>
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
                    <label class="form-label">الشعب</label>
                    <div>
                        @foreach($filiers as $filier)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="filiers[]" id="addFilier{{ $filier->id }}" value="{{ $filier->id }}">
                                <label class="form-check-label" for="addFilier{{ $filier->id }}">
                                    {{ $filier->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <small class="text-muted">يمكنك اختيار أكثر من شعبة</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">المجموعات</label>
                    <div>
                        @foreach($groupes as $groupe)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="groupes[]" id="addGroupe{{ $groupe->id }}" value="{{ $groupe->id }}">
                                <label class="form-check-label" for="addGroupe{{ $groupe->id }}">
                                    {{ $groupe->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <small class="text-muted">يمكنك اختيار أكثر من مجموعة</small>
                </div>
                <!-- باقي المعلومات الشخصية ممكن تزيدهم هنا -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </form>
    </div>
</div>
@endsection