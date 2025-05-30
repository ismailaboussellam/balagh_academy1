<nav x-data="{ open: false }" class="bg-gradient-to-l from-indigo-200 via-white to-green-100 shadow-lg rounded-b-xl border-b border-indigo-300">
    <!-- القسم المكتبي (Desktop) -->
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center py-3">
        <!-- Dashboard (مختلف حسب الدور) -->
        @if (auth()->check() && auth()->user()->role === 'teacher')
            <x-nav-link :href="route('teacher.dashboard')" :active="request()->routeIs('teacher.dashboard')" class="text-indigo-700 hover:text-white hover:bg-indigo-500 transition rounded px-3 py-2 font-semibold">
                {{ __('Dashboard') }}
            </x-nav-link>
        @elseif (auth()->check() && auth()->user()->role === 'student')
            <x-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')" class="text-indigo-700 hover:text-white hover:bg-indigo-500 transition rounded px-3 py-2 font-semibold">
                {{ __('Dashboard') }}
            </x-nav-link>
        @endif

        <!-- الدروس -->
        @if (auth()->check() && auth()->user()->role === 'teacher')
            @php
                // جلب أول Subject أو رابط بديل
                $subject = App\Models\Subject::first();
                $lessonsLink = $subject ? route('teacher.lessons.create', $subject->id) : route('teacher.subjects');
            @endphp
            <x-nav-link :href="$lessonsLink" :active="request()->routeIs('teacher.lessons.create')" class="text-green-700 hover:text-white hover:bg-green-500 transition rounded px-3 py-2 font-semibold">
                إضافة درس
            </x-nav-link>
        @elseif (auth()->check() && auth()->user()->role === 'student')
            <x-nav-link :href="route('lessons.index')" :active="request()->routeIs('lessons.*')" class="text-green-700 hover:text-white hover:bg-green-500 transition rounded px-3 py-2 font-semibold">
                الدروس
            </x-nav-link>
        @endif

        <!-- الامتحانات -->
        @if (auth()->check() && auth()->user()->role === 'teacher')
            @php
                $examsLink = $subject ? route('teacher.exams.create', $subject->id) : route('teacher.subjects');
            @endphp
            <x-nav-link :href="$examsLink" :active="request()->routeIs('teacher.exams.create')" class="text-yellow-700 hover:text-white hover:bg-yellow-500 transition rounded px-3 py-2 font-semibold">
                إضافة امتحان
            </x-nav-link>
        @elseif (auth()->check() && auth()->user()->role === 'student')
            <x-nav-link :href="route('exams.index')" :active="request()->routeIs('exams.*')" class="text-yellow-700 hover:text-white hover:bg-yellow-500 transition rounded px-3 py-2 font-semibold">
                الامتحانات
            </x-nav-link>
        @endif

        <!-- الدورات (للأستاذ فقط) -->
        @if (auth()->check() && auth()->user()->role === 'teacher')
            <x-nav-link :href="route('teacher.subjects')" :active="request()->routeIs('teacher.subjects.*')" class="text-blue-700 hover:text-white hover:bg-blue-500 transition rounded px-3 py-2 font-semibold">
                الدورات
            </x-nav-link>
        @endif

        <!-- الإشعارات (للتلميذ فقط) -->
        @if (auth()->check() && auth()->user()->role === 'student')
            <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')" class="text-pink-700 hover:text-white hover:bg-pink-500 transition rounded px-3 py-2 font-semibold">
                الإشعارات
            </x-nav-link>
        @endif

        <!-- الملف الشخصي (عام) -->
        @if (auth()->check())
            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="text-gray-700 hover:text-white hover:bg-gray-500 transition rounded px-3 py-2 font-semibold">
                الملف الشخصي
            </x-nav-link>
        @endif

        <!-- تسجيل الخروج (عام) -->
        @if (auth()->check())
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                    class="text-red-700 hover:text-white hover:bg-red-500 transition rounded px-3 py-2 font-semibold"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        @endif
    </div>

    <!-- القسم المحمول (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-indigo-200">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Dashboard (مختلف حسب الدور) -->
            @if (auth()->check() && auth()->user()->role === 'teacher')
                <x-responsive-nav-link :href="route('teacher.dashboard')" :active="request()->routeIs('teacher.dashboard')" class="block text-indigo-700 hover:text-white hover:bg-indigo-500 transition rounded px-3 py-2 font-semibold">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @elseif (auth()->check() && auth()->user()->role === 'student')
                <x-responsive-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')" class="block text-indigo-700 hover:text-white hover:bg-indigo-500 transition rounded px-3 py-2 font-semibold">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif

            <!-- الدروس -->
            @if (auth()->check() && auth()->user()->role === 'teacher')
                <x-responsive-nav-link :href="$lessonsLink" :active="request()->routeIs('teacher.lessons.create')" class="block text-green-700 hover:text-white hover:bg-green-500 transition rounded px-3 py-2 font-semibold">
                    إضافة درس
                </x-responsive-nav-link>
            @elseif (auth()->check() && auth()->user()->role === 'student')
                <x-responsive-nav-link :href="route('lessons.index')" :active="request()->routeIs('lessons.*')" class="block text-green-700 hover:text-white hover:bg-green-500 transition rounded px-3 py-2 font-semibold">
                    الدروس
                </x-responsive-nav-link>
            @endif

            <!-- الامتحانات -->
            @if (auth()->check() && auth()->user()->role === 'teacher')
                <x-responsive-nav-link :href="$examsLink" :active="request()->routeIs('teacher.exams.create')" class="block text-yellow-700 hover:text-white hover:bg-yellow-500 transition rounded px-3 py-2 font-semibold">
                    إضافة امتحان
                </x-responsive-nav-link>
            @elseif (auth()->check() && auth()->user()->role === 'student')
                <x-responsive-nav-link :href="route('exams.index')" :active="request()->routeIs('exams.*')" class="block text-yellow-700 hover:text-white hover:bg-yellow-500 transition rounded px-3 py-2 font-semibold">
                    الامتحانات
                </x-responsive-nav-link>
            @endif

            <!-- الدورات (للأستاذ فقط) -->
            @if (auth()->check() && auth()->user()->role === 'teacher')
                <x-responsive-nav-link :href="route('teacher.subjects')" :active="request()->routeIs('teacher.subjects.*')" class="block text-blue-700 hover:text-white hover:bg-blue-500 transition rounded px-3 py-2 font-semibold">
                    الدورات
                </x-responsive-nav-link>
            @endif

            <!-- الإشعارات (للتلميذ فقط) -->
            @if (auth()->check() && auth()->user()->role === 'student')
                <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')" class="block text-pink-700 hover:text-white hover:bg-pink-500 transition rounded px-3 py-2 font-semibold">
                    الإشعارات
                </x-responsive-nav-link>
            @endif

            <!-- الملف الشخصي (عام) -->
            @if (auth()->check())
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="block text-gray-700 hover:text-white hover:bg-gray-500 transition rounded px-3 py-2 font-semibold">
                    الملف الشخصي
                </x-responsive-nav-link>
            @endif

            <!-- تسجيل الخروج (عام) -->
            @if (auth()->check())
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        class="block text-red-700 hover:text-white hover:bg-red-500 transition rounded px-3 py-2 font-semibold"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            @endif
        </div>
    </div>
</nav>
