<nav class="bg-gradient-to-l from-indigo-200 via-white to-green-100 shadow-lg rounded-b-xl border-b border-indigo-300">
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center py-3">
        <x-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')" class="text-indigo-700 hover:text-white hover:bg-indigo-500 transition rounded px-3 py-2 font-semibold">
            {{ __('Dashboard') }}
        </x-nav-link>
        <x-nav-link :href="route('lessons.index')" :active="request()->routeIs('lessons.*')" class="text-green-700 hover:text-white hover:bg-green-500 transition rounded px-3 py-2 font-semibold">
            الدروس
        </x-nav-link>
        <x-nav-link :href="route('exams.index')" :active="request()->routeIs('exams.*')" class="text-yellow-700 hover:text-white hover:bg-yellow-500 transition rounded px-3 py-2 font-semibold">
            الامتحانات
        </x-nav-link>
        <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')" class="text-pink-700 hover:text-white hover:bg-pink-500 transition rounded px-3 py-2 font-semibold">
            الإشعارات
        </x-nav-link>
        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="text-gray-700 hover:text-white hover:bg-gray-500 transition rounded px-3 py-2 font-semibold">
            الملف الشخصي
        </x-nav-link>

        {{-- ✅ رابط خاص بالأساتذة فقط --}}
        @if (auth()->check() && auth()->user()->role === 'teacher')
            <x-nav-link :href="route('teacher.subjects')" class="text-blue-700 hover:text-white hover:bg-blue-500 transition rounded px-3 py-2 font-semibold">
                الدورات
            </x-nav-link>
        @endif

        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <x-responsive-nav-link :href="route('logout')"
                class="text-red-700 hover:text-white hover:bg-red-500 transition rounded px-3 py-2 font-semibold"
                onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-responsive-nav-link>
        </form>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-indigo-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')" class="block text-indigo-700 hover:text-white hover:bg-indigo-500 transition rounded px-3 py-2 font-semibold">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('lessons.index')" :active="request()->routeIs('lessons.*')" class="block text-green-700 hover:text-white hover:bg-green-500 transition rounded px-3 py-2 font-semibold">
                الدروس
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('exams.index')" :active="request()->routeIs('exams.*')" class="block text-yellow-700 hover:text-white hover:bg-yellow-500 transition rounded px-3 py-2 font-semibold">
                الامتحانات
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')" class="block text-pink-700 hover:text-white hover:bg-pink-500 transition rounded px-3 py-2 font-semibold">
                الإشعارات
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="block text-gray-700 hover:text-white hover:bg-gray-500 transition rounded px-3 py-2 font-semibold">
                الملف الشخصي
            </x-responsive-nav-link>

            {{-- ✅ رابط خاص بالأساتذة فقط فالموبايل --}}
            @if (auth()->check() && auth()->user()->role === 'teacher')
                <x-responsive-nav-link :href="route('teacher.subjects')" class="block text-blue-700 hover:text-white hover:bg-blue-500 transition rounded px-3 py-2 font-semibold">
                    الدورات
                </x-responsive-nav-link>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                    class="block text-red-700 hover:text-white hover:bg-red-500 transition rounded px-3 py-2 font-semibold"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
