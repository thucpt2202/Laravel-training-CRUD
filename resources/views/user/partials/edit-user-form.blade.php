@props(['user', 'currentRole'])

<form x-data="{ openEditDialog: false }">
    @if ($currentRole == 'admin')
        <x-secondary-button x-on:click="openEditDialog = true">Edit</x-secondary-button>
    @else
        <x-secondary-button disabled x-on:click="openEditDialog = true">Edit</x-secondary-button>
    @endif
    <template x-if="openEditDialog">
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 dark:border-gray-700 dark:bg-gray-800">
                            <div class="max-w-xl">
                                <header>
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('Edit User') }}
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('Change User\'s informations.') }}
                                    </p>
                                </header>
                                <form action="{{ route('users.update', $user->id) }}" method="POST"
                                    class="mt-6 space-y-6" x-data="{
                                        password: '{{ $user->password ?? '' }}',
                                        copied: false,
                                    }">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <x-input-label for="name" :value="__('Name')" />
                                        <x-text-input id="name" class="mt-1 block w-full" type="text"
                                            name="name" :value="$user->name" required autofocus autocomplete="name" />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" class="mt-1 block w-full" type="email"
                                            name="email" :value="$user->email" required autocomplete="username" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="password" :value="__('Password')" />
                                        <div class="relative">
                                            <x-text-input id="password" name="password" type="password"
                                                class="mt-1 block w-full" x-model="password" required
                                                autocomplete="new-password" />
                                            <span class="absolute inset-y-0 right-0 flex items-center pr-1">
                                                <span
                                                    class="me-2 cursor-pointer rounded-lg bg-blue-100 px-2.5 py-1.5 text-xs font-medium text-blue-800 transition duration-300 ease-in-out hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-300"
                                                    x-on:click="
                                                        password = window.crypto.getRandomValues(new BigUint64Array(1))[0].toString(36);
                                                        navigator.clipboard.writeText(password);
                                                        copied = true;
                                                        setTimeout(() => copied = false, 3000);">
                                                    Auto generate
                                                </span>
                                            </span>
                                        </div>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        <template x-if="copied">
                                            <p class="mt-2 text-sm text-green-500">
                                                {{ __('Password copied to clipboard!') }}</p>
                                        </template>
                                    </div>

                                    <!-- Role Selection -->
                                    <div>
                                        <x-input-label :value="__('Role')" />
                                        <div class="mt-1 space-y-2">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="role" value="admin"
                                                    {{ $user->role == 'admin' ? 'checked' : '' }}
                                                    class="form-radio text-indigo-600">
                                                <span class="ml-2">Admin</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="role" value="nuser"
                                                    {{ $user->role == 'nuser' ? 'checked' : '' }}
                                                    class="form-radio text-indigo-600">
                                                <span class="ml-2">Nuser</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="role" value="oper"
                                                    {{ $user->role == 'oper' ? 'checked' : '' }}
                                                    class="form-radio text-indigo-600">
                                                <span class="ml-2">Oper</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Status Selection -->
                                    <div>
                                        <x-input-label :value="__('Status')" />
                                        <div class="mt-1 space-y-2">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="status" value="active"
                                                    {{ $user->status == 'active' ? 'checked' : '' }}
                                                    class="form-radio text-green-600">
                                                <span class="ml-2">Active</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="status" value="inactive"
                                                    {{ $user->status == 'inactive' ? 'checked' : '' }}
                                                    class="form-radio text-red-600">
                                                <span class="ml-2">Inactive</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div
                                        class="gap-4 bg-gray-100 py-3 sm:flex sm:flex-row-reverse dark:border-gray-700 dark:bg-gray-800">
                                        <x-primary-button type="submit">Submit</x-primary-button>
                                        <x-secondary-button type="button"
                                            x-on:click="openEditDialog = false">Cancel</x-secondary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</form>
