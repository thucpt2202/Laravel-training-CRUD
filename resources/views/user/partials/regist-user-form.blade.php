<form method="POST" action="{{ route('add_user') }}" class="mt-6 space-y-6" x-data="{ password: '', copied: false, confirmPassword: '' }">
  @csrf

  <div>
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required
      autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
  </div>

  <div>
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required
      autocomplete="username" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
  </div>

  <div>
    <x-input-label for="password" :value="__('Password')" />
    <div class="relative">
      <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" x-model="password" required
        autocomplete="new-password" />
      <span class="absolute inset-y-0 right-0 flex items-center pr-1">
        <span
          class="me-2 cursor-pointer rounded-lg bg-blue-100 px-2.5 py-1.5 text-xs font-medium text-blue-800 transition duration-300 ease-in-out hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-300"
          x-on:click="
            password = window.crypto.getRandomValues(new BigUint64Array(1))[0].toString(36);
            confirmPassword = password;
            navigator.clipboard.writeText(password);
            copied = true;
            setTimeout(() => copied = false, 3000);">
          Auto generate
        </span>
      </span>
    </div>
    <x-input-error :messages="$errors->get('password')" class="mt-2" />
    <template x-if="copied">
      <p class="mt-2 text-sm text-green-500">{{ __('Password copied to clipboard!') }}</p>
    </template>
  </div>

  <div class="mt-4">
    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

    <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password" name="password_confirmation"
      required autocomplete="new-password" x-model="confirmPassword" />

    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
  </div>

  <div class="mt-4 flex items-center">
    <x-primary-button>
      {{ __('Register') }}
    </x-primary-button>
  </div>
</form>
