@extends('layouts.admin')
@section('title', 'إدارة الشعب')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">إدارة الشعب والمجموعات</h2>

    <!-- Buttons -->
    <div class="mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFilierModal">إضافة شعبة</button>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addGroupeModal">إضافة مجموعة</button>
    </div>

    <div class="row">
        <!-- Filiers -->
        <div class="col-md-6">
            <h4>الشعب</h4>
            <ul class="list-group">
                @foreach($filiers as $filier)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $filier->name }}</span>
                        <span>
                            <!-- Edit Filier -->
                            <button class="btn btn-sm btn-outline-warning" title="تعديل" data-bs-toggle="modal" data-bs-target="#editFilierModal{{ $filier->id }}">
                                <i class="fa fa-edit"></i>
                            </button>
                            <!-- Delete Filier -->
                            <form action="{{ route('admin.filiers.destroy', $filier->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف الشعبة؟');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="حذف">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            <span class="badge bg-secondary">{{ $filier->groupes->count() }} مجموعات</span>
                        </span>
                    </li>

                    <!-- Edit Filier Modal -->
                    <div class="modal fade" id="editFilierModal{{ $filier->id }}" tabindex="-1" aria-labelledby="editFilierModalLabel{{ $filier->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="modal-content" method="POST" action="{{ route('admin.filiers.update', $filier->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editFilierModalLabel{{ $filier->id }}">تعديل الشعبة</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">اسم الشعبة</label>
                                        <input type="text" class="form-control" name="name" value="{{ $filier->name }}" required>
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
            </ul>
        </div>

        <!-- Groupes -->
        <div class="col-md-6">
            <h4>المجموعات</h4>
            <!-- Filter by Filier -->
            <form method="GET" class="mb-3">
                <div class="input-group">
                    <select class="form-select" name="filier_filter" onchange="this.form.submit()">
                        <option value="">كل الشعب</option>
                        @foreach($filiers as $filier)
                            <option value="{{ $filier->id }}" {{ request('filier_filter') == $filier->id ? 'selected' : '' }}>
                                {{ $filier->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="input-group-text"><i class="fa fa-filter"></i></span>
                </div>
            </form>
            <ul class="list-group">
                @foreach($groupes as $groupe)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            {{ $groupe->name }}
                            <span class="badge bg-info text-dark">{{ $groupe->filier->name ?? 'بدون شعبة' }}</span>
                        </span>
                        <span>
                            <!-- Edit Groupe -->
                            <button class="btn btn-sm btn-outline-warning" title="تعديل" data-bs-toggle="modal" data-bs-target="#editGroupeModal{{ $groupe->id }}">
                                <i class="fa fa-edit"></i>
                            </button>
                            <!-- Delete Groupe -->
                            <form action="{{ route('admin.groupes.destroy', $groupe->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف المجموعة؟');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="حذف">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </span>
                    </li>

                    <!-- Edit Groupe Modal -->
                    <div class="modal fade" id="editGroupeModal{{ $groupe->id }}" tabindex="-1" aria-labelledby="editGroupeModalLabel{{ $groupe->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="modal-content" method="POST" action="{{ route('admin.groupes.update', $groupe->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editGroupeModalLabel{{ $groupe->id }}">تعديل المجموعة</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">اسم المجموعة</label>
                                        <input type="text" class="form-control" name="name" value="{{ $groupe->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">الشعبة</label>
                                        <select class="form-select" name="filier_id" required>
                                            @foreach($filiers as $filier)
                                                <option value="{{ $filier->id }}" {{ $groupe->filier_id == $filier->id ? 'selected' : '' }}>
                                                    {{ $filier->name }}
                                                </option>
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
            </ul>
        </div>
    </div>
</div>

<!-- Modal: Add Filier -->
<div class="modal fade" id="addFilierModal" tabindex="-1" aria-labelledby="addFilierModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="{{ route('admin.filiers.store') }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="addFilierModalLabel">إضافة شعبة جديدة</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="filierName" class="form-label">اسم الشعبة</label>
          <input type="text" class="form-control" id="filierName" name="name" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
        <button type="submit" class="btn btn-primary">حفظ</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Add Groupe -->
<div class="modal fade" id="addGroupeModal" tabindex="-1" aria-labelledby="addGroupeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="{{ route('admin.groupes.store') }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="addGroupeModalLabel">إضافة مجموعة جديدة</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="groupeName" class="form-label">اسم المجموعة</label>
          <input type="text" class="form-control" id="groupeName" name="name" required>
        </div>
        <div class="mb-3">
          <label for="filierSelect" class="form-label">الشعبة</label>
          <select class="form-select" id="filierSelect" name="filier_id" required>
            <option value="">اختر الشعبة</option>
            @foreach($filiers as $filier)
                <option value="{{ $filier->id }}">{{ $filier->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
        <button type="submit" class="btn btn-success">حفظ</button>
      </div>
    </form>
  </div>
</div>
@endsection