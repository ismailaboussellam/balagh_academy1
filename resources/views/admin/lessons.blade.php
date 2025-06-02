@extends('layouts.admin')
@section('title', 'إدارة الحصص')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">إدارة الحصص (Emploi du temps)</h2>

    <!-- Debug Info -->
    <div class="alert alert-info">
        <p>Groupe sélectionné: {{ $selectedGroupe }}</p>
        <p>Semaine sélectionnée: {{ $selectedSemaine }}</p>
        <p>Nombre d'emplois: {{ $emplois->count() }}</p>
    </div>

    <!-- اختيار المجموعة والأسبوع -->
    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <label>المجموعة:</label>
            <select name="groupe_id" class="form-select" onchange="this.form.submit()">
                @foreach($groupes as $groupe)
                    <option value="{{ $groupe->id }}" {{ $selectedGroupe == $groupe->id ? 'selected' : '' }}>{{ $groupe->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <label>الأسبوع:</label>
            <select name="semaine" class="form-select" onchange="this.form.submit()">
                @foreach($semaines as $sem)
                    <option value="{{ $sem }}" {{ $selectedSemaine == $sem ? 'selected' : '' }}>الأسبوع {{ $sem }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- زر إضافة حصة -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEmploiModal">إضافة حصة</button>

    @php
        $jours = ['LUNDI', 'MARDI', 'MERCREDI', 'JEUDI', 'VENDREDI', 'SAMEDI'];
        $creneaux = [
            '08:30-09:30', '09:30-10:30', '10:30-11:30', '11:30-12:30',
            '14:30-15:30', '15:30-16:30', '16:30-17:30', '17:30-18:30'
        ];
        
        // دالة محسنة للعثور على الحصص في الفترة الزمنية
        function emploiInCreneau($emplois, $jour, $creneau) {
            [$start, $end] = explode('-', $creneau);
            
            // تحويل الأوقات إلى تنسيق موحد للمقارنة
            $start = trim($start) . ':00';
            $end = trim($end) . ':00';
            
            $found = $emplois->first(function($emploi) use ($jour, $start, $end) {
                // تحويل أوقات الحصة إلى تنسيق موحد للمقارنة
                $emploiStart = substr($emploi->heure_debut, 0, 8);
                $emploiEnd = substr($emploi->heure_fin, 0, 8);
                
                // المقارنة بين اليوم والوقت
                $match = $emploi->jour == $jour && 
                        $emploiStart == $start && 
                        $emploiEnd == $end;
                
                if ($match) {
                    \Log::info('تم العثور على تطابق:', [
                        'jour' => $jour,
                        'start' => $start,
                        'end' => $end,
                        'emploi_start' => $emploiStart,
                        'emploi_end' => $emploiEnd,
                        'emploi' => $emploi->toArray()
                    ]);
                }
                
                return $match;
            });
            
            return $found;
        }
    @endphp

    <!-- جدول الحصص -->
    <table class="table table-bordered text-center align-middle">
        <thead>
            <tr>
                <th>اليوم</th>
                @foreach($creneaux as $creneau)
                    <th>{{ $creneau }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($jours as $jour)
                <tr>
                    <td><b>{{ $jour }}</b></td>
                    @foreach($creneaux as $creneau)
                        @php 
                            $emploi = emploiInCreneau($emplois, $jour, $creneau);
                        @endphp
                        <td>
                            @if($emploi)
                                <div>
                                    <b>Module:</b> {{ $emploi->module }}<br>
                                    <b>Prof:</b> {{ $emploi->prof->first_name ?? '' }} {{ $emploi->prof->last_name ?? '' }}<br>
                                    <b>Salle:</b> {{ $emploi->type == 'distance' ? 'A distance' : $emploi->salle }}
                                </div>
                                <!-- أزرار التعديل والحذف -->
                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editEmploiModal{{ $emploi->id }}"><i class="fa fa-edit"></i></button>
                                <form action="{{ route('admin.emplois.destroy', $emploi->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal: إضافة حصة -->
<div class="modal fade" id="addEmploiModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.emplois.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">إضافة حصة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="groupe_id" value="{{ $selectedGroupe }}">
                    <input type="hidden" name="semaine" value="{{ $selectedSemaine }}">
                    
                    <div class="mb-3">
                        <label>اليوم</label>
                        <select name="jour" class="form-select" required>
                            @foreach($jours as $jour)
                                <option value="{{ $jour }}">{{ $jour }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>الوقت</label>
                        <select name="creneau" class="form-select" required>
                            @foreach($creneaux as $creneau)
                                <option value="{{ $creneau }}">{{ $creneau }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>المادة (Module)</label>
                        <select name="module" class="form-select" required>
                            @foreach($modules as $module)
                                <option value="{{ $module }}">{{ $module }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>الأستاذ</label>
                        <select name="prof_id" class="form-select" required>
                            @foreach($profs as $prof)
                                <option value="{{ $prof->id }}">{{ $prof->first_name }} {{ $prof->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>نوع الحصة</label>
                        <select name="type" class="form-select" id="typeSelect" required onchange="toggleSalle(this)">
                            <option value="etablissement">في المؤسسة</option>
                            <option value="distance">عن بعد</option>
                        </select>
                    </div>
                    <div class="mb-3" id="salleDiv">
                        <label>القاعة</label>
                        <select name="salle" class="form-select">
                            @foreach($salles as $salle)
                                <option value="{{ $salle }}">{{ $salle }}</option>
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
</div>

<!-- Modals التعديل -->
@foreach($emplois as $emploi)
<div class="modal fade" id="editEmploiModal{{ $emploi->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.emplois.update', $emploi->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">تعديل الحصة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>اليوم</label>
                        <select name="jour" class="form-select" required>
                            @foreach($jours as $jour)
                                <option value="{{ $jour }}" {{ $emploi->jour == $jour ? 'selected' : '' }}>{{ $jour }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>الوقت</label>
                        <select name="creneau" class="form-select" required>
                            @foreach($creneaux as $creneau)
                                @php
                                    [$start, $end] = explode('-', $creneau);
                                    $start = trim($start) . ':00';
                                    $end = trim($end) . ':00';
                                    $emploiStart = substr($emploi->heure_debut, 0, 8);
                                    $emploiEnd = substr($emploi->heure_fin, 0, 8);
                                    $isSelected = $emploiStart == $start && $emploiEnd == $end;
                                @endphp
                                <option value="{{ $creneau }}" {{ $isSelected ? 'selected' : '' }}>{{ $creneau }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>المادة (Module)</label>
                        <select name="module" class="form-select" required>
                            @foreach($modules as $module)
                                <option value="{{ $module }}" {{ $emploi->module == $module ? 'selected' : '' }}>{{ $module }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>الأستاذ</label>
                        <select name="prof_id" class="form-select" required>
                            @foreach($profs as $prof)
                                <option value="{{ $prof->id }}" {{ $emploi->prof_id == $prof->id ? 'selected' : '' }}>{{ $prof->first_name }} {{ $prof->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>نوع الحصة</label>
                        <select name="type" class="form-select" id="typeSelectEdit{{ $emploi->id }}" required onchange="toggleSalleEdit({{ $emploi->id }}, this)">
                            <option value="etablissement" {{ $emploi->type == 'etablissement' ? 'selected' : '' }}>في المؤسسة</option>
                            <option value="distance" {{ $emploi->type == 'distance' ? 'selected' : '' }}>عن بعد</option>
                        </select>
                    </div>
                    <div class="mb-3" id="salleDivEdit{{ $emploi->id }}">
                        <label>القاعة</label>
                        <select name="salle" class="form-select">
                            @foreach($salles as $salle)
                                <option value="{{ $salle }}" {{ $emploi->salle == $salle ? 'selected' : '' }}>{{ $salle }}</option>
                            @endforeach
                        </select>
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
@endforeach

<script>
function toggleSalle(select) {
    const salleDiv = document.getElementById('salleDiv');
    const salleSelect = salleDiv.querySelector('select');
    if (select.value === 'distance') {
        salleDiv.style.display = 'none';
        salleSelect.value = 'A distance';
    } else {
        salleDiv.style.display = 'block';
        salleSelect.value = 'SALLE 1';
    }
}

function toggleSalleEdit(id, select) {
    const salleDiv = document.getElementById('salleDivEdit' + id);
    const salleSelect = salleDiv.querySelector('select');
    if (select.value === 'distance') {
        salleDiv.style.display = 'none';
        salleSelect.value = 'A distance';
    } else {
        salleDiv.style.display = 'block';
        salleSelect.value = 'SALLE 1';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('typeSelect');
    if (typeSelect) {
        toggleSalle(typeSelect);
    }
    
    @foreach($emplois as $emploi)
        const typeSelectEdit = document.getElementById('typeSelectEdit{{ $emploi->id }}');
        if (typeSelectEdit) {
            toggleSalleEdit({{ $emploi->id }}, typeSelectEdit);
        }
    @endforeach
});
</script>
@endsection