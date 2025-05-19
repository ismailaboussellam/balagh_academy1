<x-guest-layout>
    <div class="text-center mb-6">
        <i class="fas fa-user-shield fa-2x text-blue-800"></i>
        <h1 class="text-3xl font-bold text-blue-800">استمارة تسجيل الأب</h1>
    </div>

    <form method="POST" action="{{ route('father.register') }}" class="space-y-5">
        @csrf

        <div class="flex gap-4">
            <div class="w-1/2">
                <x-input-label for="first_name" :value="'الاسم الأول'" />
                <x-text-input id="first_name" class="w-full rounded-xl" type="text" name="first_name" :value="old('first_name')" required autofocus />
                <x-input-error :messages="$errors->get('first_name')" class="mt-1" />
            </div>

            <div class="w-1/2">
                <x-input-label for="last_name" :value="'الاسم الأخير'" />
                <x-text-input id="last_name" class="w-full rounded-xl" type="text" name="last_name" :value="old('last_name')" required />
                <x-input-error :messages="$errors->get('last_name')" class="mt-1" />
            </div>
        </div>

        <div class="flex gap-4">
            <div class="w-1/2">
                <x-input-label for="email" :value="'البريد الإلكتروني'" />
                <x-text-input id="email" class="w-full rounded-xl" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div class="w-1/2">
                <x-input-label for="phone" :value="'رقم الهاتف'" />
                <div class="flex gap-2">
                    <select name="phone_code" class="w-1/3 rounded-xl border-gray-300" required>
                        <option value=""></option>
                        <option value="+212">🇲🇦 المغرب +212</option>
                        <option value="+966">🇸🇦 السعودية +966</option>
                        <option value="+20">🇪🇬 مصر +20</option>
                        <option value="+971">🇦🇪 الإمارات +971</option>
                        <option value="+213">🇩🇿 الجزائر +213</option>
                        <option value="+216">🇹🇳 تونس +216</option>
                        <option value="+90">🇹🇷 تركيا +90</option>
                        <option value="+91">🇮🇳 الهند +91</option>
                        <option value="+62">🇮🇩 أندونيسيا +62</option>
                        <option value="+92">🇵🇰 باكستان +92</option>
                        <option value="+234">🇳🇬 نيجيريا +234</option>
                        <option value="+55">🇧🇷 البرازيل +55</option>
                        <option value="+7">🇷🇺 روسيا +7</option>
                        <option value="+86">🇨🇳 الصين +86</option>
                        <option value="+81">🇯🇵 اليابان +81</option>
                        <option value="+1">🇨🇦 كندا +1</option>
                        <option value="+39">🇮🇹 إيطاليا +39</option>
                        <option value="+46">🇸🇪 السويد +46</option>
                    </select>
                    <x-text-input id="phone" class="w-2/3" type="text" name="phone" :value="old('phone')" required />
                </div>
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
        </div>
        <div class="flex gap-4">
            <div class="w-1/2">
                <x-input-label for="gender" :value="'النوع'" />
                <select name="gender" id="gender" class="w-full mt-1 border-gray-300 rounded-md" required>
                    <option value="">اختر النوع</option>
                    <option value="male">ذكر</option>
                    <option value="female">أنثى</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="child_code" :value="'كود الطالب'" />
                <x-text-input id="child_code" class="w-full rounded-xl" type="text" name="child_code" :value="old('child_code')" required />
                <x-input-error :messages="$errors->get('child_code')" class="mt-1" />
            </div>
        </div>

        <div>
            <x-input-label :value="'تاريخ الميلاد'" />
            <div class="flex gap-2">
                <select name="birth_day" class="rounded-xl border-gray-300" required>
                    <option value="">اليوم</option>
                    @for($i=1;$i<=31;$i++) <option value="{{ $i }}">{{ $i }}</option> @endfor
                </select>
                <select name="birth_month" class="rounded-xl border-gray-300" required>
                    <option value="">الشهر</option>
                    @for($i=1;$i<=12;$i++) <option value="{{ $i }}">{{ $i }}</option> @endfor
                </select>
                <select name="birth_year" class="rounded-xl border-gray-300" required>
                    <option value="">السنة</option>
                    @for($i=date('Y');$i>=1900;$i--) <option value="{{ $i }}">{{ $i }}</option> @endfor
                </select>
            </div>
            <x-input-error :messages="$errors->get('birth_day')" class="mt-2" />
        </div>
        <div class="flex gap-4">
            <div class="w-1/2">
                <x-input-label for="password" :value="'كلمة المرور'" />
                <x-text-input id="password" class="w-full rounded-xl" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div class="w-1/2">
                <x-input-label for="password_confirmation" :value="'تأكيد كلمة المرور'" />
                <x-text-input id="password_confirmation" class="w-full rounded-xl" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>
        </div>

        <div>
            <label class="flex items-center">
                <input type="checkbox" name="terms" class="text-green-500" required>
                <span class="ml-2 text-sm text-green-600">
                    أوافق على
                    <a href="{{ route('privacy.policy') }}" target="_blank" class="underline hover:text-green-800 transition">سياسة الخصوصية</a>
                    و
                    <a href="{{ route('terms.conditions') }}" target="_blank" class="underline hover:text-green-800 transition">الشروط والأحكام</a>
                </span>
            </label>
            <x-input-error :messages="$errors->get('terms')" class="mt-1" />
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-4">
            <a class="underline text-sm text-blue-800 hover:text-blue-500" href="{{ route('login') }}">
                {{ __('مسجل مسبقاً؟ تسجيل الدخول') }}
            </a>

            <x-primary-button class="px-6 py-3 rounded-full bg-[#e8bc72] hover:bg-[#d4a85f] text-white font-semibold">
                {{ __('التسجيل') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
