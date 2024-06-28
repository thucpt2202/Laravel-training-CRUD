<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
      {{ __('Regist User') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
        <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
          <div class="max-w-xl">
            <header>
              <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Regist User') }}
              </h2>

              <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Regist new user using email.') }}
              </p>
            </header>
            @include('user.partials.regist-user-form')
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
