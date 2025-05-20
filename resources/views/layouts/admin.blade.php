<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة تحكم المدير</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            direction: rtl;
        }


             .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
        }
        .sidebar a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
        }
        .sidebar a:hover {
            background-color:#e9ecef;
        }
.dropdown-sidebar {
    cursor: pointer;
    padding: 10px 20px;
    color: #333;
    position: relative;
    transition: background 0.3s;
}

.dropdown-sidebar:hover {
    background-color: #e9ecef;
}

.dropdown-sidebar a:hover {
    background-color:rgb(180, 180, 180);
}


.dropdown-sidebar-menu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    padding-left: 20px;
}

.dropdown-sidebar.open .dropdown-sidebar-menu {
    max-height: 200px; /* adjust if needed */
}

        .topbar {
            background-color: #343a40;
            color: white;
            padding: 10px 20px;
        }
        .topbar img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-left: 10px;
        }
    </style>
</head>
<body>

    <!-- Top Bar -->
<div class="d-flex justify-content-between align-items-center p-3 text-white" style="background-color: #343a40; direction: rtl;">
    <!-- العنوان في اليمين -->
    <h5 class="m-0">لوحة تحكم المدير</h5>

    <!-- Dropdown ديال Admin فـ اليسار -->
    <div class="dropdown" style="direction: ltr;">
        <a class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" href="#" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('images/admin.png') }}" alt="صورة" width="32" height="32" class="rounded-circle me-2">
            <span>مرحباً، Admin</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end text-end" aria-labelledby="adminDropdown">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">الملف الشخصي</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">تسجيل الخروج</button>
                </form>
            </li>
        </ul>
    </div>
</div>



    <div class="d-flex">
<!-- Sidebar -->
<div class="sidebar p-3">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>

    <div class="dropdown-sidebar" onclick="toggleDropdown(this)">
        Leçon
        <div class="dropdown-sidebar-menu">
            <a href="{{ route('admin.lecon') }}">Add Leçon</a>
            <a href="{{ route('lessons.index') }}">Show Leçon</a>
        </div>
    </div>


    
    <div class="dropdown-sidebar" onclick="toggleDropdown(this)">
        exam
        <div class="dropdown-sidebar-menu">
            <a href="{{ route('admin.lecon') }}">Add exam</a>
            <a href="{{ route('lessons.index') }}">Show exam</a>
        </div>
    </div>


</div>





        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>


    <script>
    function toggleDropdown(element) {
        element.classList.toggle('open');
    }
</script>

</body>
</html>
