<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar a.active {
    background-color: #e9ecef;
    font-weight: bold;
    border-right: 3px solid #343a40;
}
    </style>
</head>
<body>
@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">إضافة درس جديد</h2>

   <form action="{{ route('lessons.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- العنوان -->
    <div class="mb-3">
        <label for="title" class="form-label">عنوان الدرس</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>

    <!-- رفع فيديو -->
    <div class="mb-3">
        <label for="video" class="form-label">رفع الفيديو</label>
        <input type="file" class="form-control" name="video" accept="video/mp4" required>
    </div>

    <!-- اختيار التصنيف -->
<div class="mb-3">
    <label for="category" class="form-label">التصنيف</label>
    <select class="form-control" name="category_id" required>
        <option value="">اختر التصنيف</option>
       
            <option value=""></option>
       
    </select>
</div>


    <!-- وصف -->
    <div class="mb-3">
        <label for="description" class="form-label">وصف الدرس</label>
        <textarea class="form-control" name="description" rows="4"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">حفظ الدرس</button>
</form>

</div>
@endsection

</body>
</html>
