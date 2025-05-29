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
                <a href="{{ route('home') }}"
                   id="nav-home"
                   class="text-gray-700 hover:text-green-700 transition ml-3">
                    الرئيسية
                </a>

                <a href="{{ route('home') }}#features"
                   id="nav-features"
                   class="text-gray-700 hover:text-green-700 transition ml-3">
                    المميزات
                </a>

                <a href="{{ route('home') }}#about"
                   id="nav-about"
                   class="text-gray-700 hover:text-green-700 transition ml-3">
                    قالوا عنا
                </a>

                <a href="{{ route("programe") }}"
                   class="{{ request()->routeIs('programe') ? 'text-green-700 font-semibold border-b-2 border-green-700 pb-1' : 'text-gray-700 hover:text-green-700 transition ml-3' }}">
                    برنامج الدراسة
                </a>

                <a href="{{ route('system') }}"
                   class="{{ request()->routeIs('system') ? 'text-green-700 font-semibold border-b-2 border-green-700 pb-1' : 'text-gray-700 hover:text-green-700 transition ml-3' }}">
                    النظام الأكاديمي
                </a>

                <a href="{{ route('contact_us') }}"
                   class="{{ request()->routeIs('contact_us') ? 'text-green-700 font-semibold border-b-2 border-green-700 pb-1' : 'text-gray-700 hover:text-green-700 transition ml-3' }}">
                    اتصل بنا
                </a>

                <a href="{{ route('select_login') }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition ml-4">
                    تسجيل الدخول
                </a>
            </div>

            <!-- Mobile Button -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open"
                        class="text-gray-700 focus:outline-none transition-transform transform hover:scale-110">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div class="md:hidden" x-show="open" x-transition>
        <div class="pt-2 pb-3 space-y-1 bg-white shadow-md rounded-b-lg px-4 text-right">
            <a href="{{ route('home') }}"
               class="block px-4 py-2 rounded text-gray-700 hover:bg-green-50 transition">
                🏠 الرئيسية
            </a>
            <a href="{{ route('home') }}#features"
               class="block px-4 py-2 rounded text-gray-700 hover:bg-green-50 transition">
                ✨ المميزات
            </a>
            <a href="{{ route('home') }}#about"
               class="block px-4 py-2 rounded text-gray-700 hover:bg-green-50 transition">
                🗣️ قالوا عنا
            </a>
            <a href="{{ route("programe") }}"
               class="{{ request()->routeIs('programe') ? 'block px-4 py-2 rounded text-green-700 bg-green-100 font-semibold' : 'block px-4 py-2 rounded text-gray-700 hover:bg-green-50 transition' }}">
                📘 برنامج الدراسة
            </a>
            <a href="{{ route('system') }}"
               class="{{ request()->routeIs('system') ? 'block px-4 py-2 rounded text-green-700 bg-green-100 font-semibold' : 'block px-4 py-2 rounded text-gray-700 hover:bg-green-50 transition' }}">
                ⚖️ النظام الأكاديمي
            </a>
            <a href="{{ route('contact_us') }}"
               class="{{ request()->routeIs('contact_us') ? 'block px-4 py-2 rounded text-green-700 bg-green-100 font-semibold' : 'block px-4 py-2 rounded text-gray-700 hover:bg-green-50 transition' }}">
                📞 اتصل بنا
            </a>
            <a href="{{ route('login') }}"
               class="block px-4 py-2 rounded text-white bg-green-600 hover:bg-green-700 transition">
                🔐 تسجيل الدخول
            </a>
        </div>
    </div>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = {
            home: document.getElementById('nav-home'),
            features: document.getElementById('nav-features'),
            about: document.getElementById('nav-about')
        };

        function removeActive() {
            Object.values(navLinks).forEach(link => {
                link.classList.remove('text-green-700', 'font-semibold', 'border-b-2', 'border-green-700', 'pb-1');
            });
        }

        function setActive(link) {
            if (!link) return;
            removeActive();
            link.classList.add('text-green-700', 'font-semibold', 'border-b-2', 'border-green-700', 'pb-1');
        }

        const sections = {
            home: document.getElementById('home'),
            features: document.getElementById('features'),
            about: document.getElementById('about')
        };

        const isOnHomepage = window.location.pathname === '/';

        if (isOnHomepage) {
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -60% 0px',
                threshold: 0
            };

            Object.entries(sections).forEach(([key, section]) => {
                if (!section) return;

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            setActive(navLinks[key]);
                        }
                    });
                }, observerOptions);

                observer.observe(section);
            });
        }

        // ✅ تعامل مع الانتقال بـ hash مباشرة بعد تحميل الصفحة
        window.onload = () => {
            if (isOnHomepage) {
                const hash = window.location.hash;
                if (hash === '#features') {
                    setActive(navLinks.features);
                } else if (hash === '#about') {
                    setActive(navLinks.about);
                } else {
                    setActive(navLinks.home);
                }
            }
        };

        // ✅ وحتى منين يتبدل الـ hash وسط الصفحة
        window.addEventListener('hashchange', () => {
            if (isOnHomepage) {
                const hash = window.location.hash;
                if (hash === '#features') {
                    setActive(navLinks.features);
                } else if (hash === '#about') {
                    setActive(navLinks.about);
                } else {
                    setActive(navLinks.home);
                }
            }
        });
    });
</script>
