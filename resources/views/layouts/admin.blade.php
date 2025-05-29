<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>لوحة تحكم المدير</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body { direction: rtl; }
        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
            min-width: 220px;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: #333;
        }
        .sidebar a:hover {
            background-color: #e9ecef;
        }
        .header-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.3rem;
            margin-left: 15px;
            margin-right: 5px;
            cursor: pointer;
        }
        .user-name {
            color: #fff;
            margin-left: 10px;
            font-weight: bold;
        }
        .topbar {
            background-color: #343a40;
            color: white;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center topbar">
        <div>
            <span class="user-name">{{ Auth::user()->name ?? 'المستخدم' }}</span>
        </div>
        <div>
            <a href="{{ route('admin.profile') }}" class="header-btn" title="الملف الشخصي">
                <i class="fa-solid fa-user"></i>
            </a>
            <a href="{{ route('admin.notifications') }}" class="header-btn" title="الإشعارات">
                <i class="fa-solid fa-bell"></i>
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="header-btn" title="تسجيل الخروج">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-2">
            <a href="{{ route('admin.dashboard') }}">لوحة القيادة</a>
            <a href="{{ route('admin.students') }}">إدارة الطلاب</a>
            <a href="{{ route('admin.filiers') }}">إدارة الشعب</a>
            <a href="{{ route('admin.cours.index') }}">إدارة cours</a>
            <a href="{{ route('admin.teachers') }}">إدارة الأساتذة</a>
            <a href="{{ route('admin.lessons') }}">إدارة الحصص</a>
        </div>
        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>


    <!-- Add before your other scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>