<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                :value="old('name', $user->name)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                :value="old('email', $user->email)" required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        {{-- Age --}}
        <div>
            <x-input-label for="age" :value="__('Age')" />
            <x-text-input id="age" name="age" type="number" min="3" max="100"
                class="mt-1 block w-full" :value="old('age', $user->age)" required />
            <x-input-error class="mt-2" :messages="$errors->get('age')" />
        </div>

        {{-- Gender --}}
        <div>
            <x-input-label for="gender" :value="__('Gender')" />
            <select id="gender" name="gender" class="mt-1 block w-full" required>
                <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        {{-- User Type --}}
        <div>
            <x-input-label for="type" :value="__('User Type')" />
            <select id="type" name="type" class="mt-1 block w-full" required>
                <option value="admin" {{ $user->type === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="ostad" {{ $user->type === 'ostad' ? 'selected' : '' }}>Ostad</option>
                <option value="talib" {{ $user->type === 'talib' ? 'selected' : '' }}>Talib</option>
                <option value="ab" {{ $user->type === 'ab' ? 'selected' : '' }}>Ab</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('type')" />
        </div>

        {{-- Domain --}}
        <div>
            <x-input-label for="domain" :value="__('Domain of Interest')" />
            <select id="domain" name="domain" class="mt-1 block w-full" required>
                <option value="ta3lim_quran" {{ $user->domain === 'ta3lim_quran' ? 'selected' : '' }}>Ta3lim Quran</option>
                <option value="dorous_3ilmiyya" {{ $user->domain === 'dorous_3ilmiyya' ? 'selected' : '' }}>Dorous 3ilmiyya</option>
                <option value="ta3lim_logha" {{ $user->domain === 'ta3lim_logha' ? 'selected' : '' }}>Ta3lim Logha</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('domain')" />
        </div>

        {{-- Fi2a (readonly) --}}
        <div>
            <x-input-label for="fi2a" :value="__('Fi2a (Category)')" />
            <x-text-input id="fi2a" name="fi2a" type="text" class="mt-1 block w-full"
                :value="old('fi2a', $user->fi2a)" readonly disabled />
        </div>

        {{-- Parent Code --}}
        @if (in_array($user->type, ['ab', 'talib']))
        <div>
            <x-input-label for="parent_code" :value="__('Parent Code')" />
            <x-text-input id="parent_code" name="parent_code" type="text" class="mt-1 block w-full"
                :value="old('parent_code', $user->parent_code)" />
            <x-input-error class="mt-2" :messages="$errors->get('parent_code')" />
        </div>
        @endif

        {{-- Submit --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
