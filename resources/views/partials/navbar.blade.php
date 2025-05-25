<nav x-data="{ open: false }" class="bg-white shadow sticky top-0 z-50" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <img src="{{ asset('images/BALAGH-ACADEMY-HORIZONTAL-LOGO.png') }}" class="h-10" alt="Logo">
                <span class="text-green-700 text-xl font-extrabold">أكاديمية بلاغ</span>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-6 rtl:space-x-reverse">
                <a href="{{ route('home') }}" class="text-green-700 font-semibold border-b-2 border-green-700 pb-1">الرئيسية</a>
                <a href="{{ route('home') }}#features" class="text-gray-700 hover:text-green-700 transition">المميزات</a>
                <a href="{{ route('home') }}#about" class="text-gray-700 hover:text-green-700 transition">قالوا عنا</a>
                <a href="{{ route("programe") }}" class="text-gray-700 hover:text-green-700 transition">برنامج الدراسة</a>
                <a href="{{ route('system') }}" class="text-gray-700 hover:text-green-700 transition">النظام الأكاديمي</a>
                <a href="{{ route('contact_us') }}" class="text-gray-700 hover:text-green-700 transition">اتصل بنا</a>
                <a href="{{ route('select_login') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">تسجيل الدخول</a>
            </div>

            <!-- Mobile Button -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open" class="text-gray-700 focus:outline-none transition-transform transform hover:scale-110">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div class="md:hidden" x-show="open" x-transition>
        <div class="pt-2 pb-3 space-y-1 bg-white shadow-md rounded-b-lg px-4 text-right">
            <a href="{{ route('home') }}" class="block px-4 py-2 rounded text-green-700 bg-green-100 font-semibold">🏠 الرئيسية</a>
            <a href="{{ route('home') }}#features" class="block px-4 py-2 rounded text-gray-700 hover:bg-green-50 transition">✨ المميزات</a>
            <a href="{{ route('home') }}#about" class="block px-4 py-2 rounded text-gray-700 hover:bg-green-50 transition">🗣️ قالوا عنا</a>
            <a href="{{ route("programe") }}" class="block px-4 py-2 rounded text-gray-700 hover:bg-green-50 transition">📘 برنامج الدراسة</a>
            <a href="{{ route('system') }}" class="block px-4 py-2 rounded text-gray-700 hover:bg-green-50 transition">⚖️ النظام الأكاديمي</a>
            <a href="{{ route('contact_us') }}" class="block px-4 py-2 rounded text-gray-700 hover:bg-green-50 transition">📞 اتصل بنا</a>
            <a href="{{ route('login') }}" class="block px-4 py-2 rounded text-white bg-green-600 hover:bg-green-700 transition">🔐 تسجيل الدخول</a>
        </div>
    </div>
</nav>
