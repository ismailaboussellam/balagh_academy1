<x-guest-layout>
        <div class="text-center mb-6">
            <i class="fas fa-user-cog fa-2x text-green-800"></i>
            <h1 class="text-3xl font-bold text-green-800">استمارة تسجيل المسؤول</h1>
        </div>

        <form method="POST" action="{{ route('admin-register') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="first_name" :value="'الاسم الأول'" />
                <x-text-input id="first_name" class="w-full rounded-xl" type="text" name="first_name" :value="old('first_name')" required autofocus />
                <x-input-error :messages="$errors->get('first_name')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="last_name" :value="'الاسم الأخير'" />
                <x-text-input id="last_name" class="w-full rounded-xl" type="text" name="last_name" :value="old('last_name')" required />
                <x-input-error :messages="$errors->get('last_name')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="email" :value="'البريد الإلكتروني'" />
                <x-text-input id="email" class="w-full rounded-xl" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="password" :value="'كلمة المرور'" />
                <x-text-input id="password" class="w-full rounded-xl" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="'تأكيد كلمة المرور'" />
                <x-text-input id="password_confirmation" class="w-full rounded-xl" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-4">
                <a class="underline text-sm text-green-800 hover:text-green-500" href="{{ route('login') }}">
                    {{ __('مسجل مسبقاً؟ تسجيل الدخول') }}
                </a>

                <x-primary-button class="px-6 py-3 rounded-full bg-[#e8bc72] hover:bg-[#d4a85f] text-white font-semibold">
                    {{ __('التسجيل') }}
                </x-primary-button>
            </div>
        </form>
</x-guest-layout>
