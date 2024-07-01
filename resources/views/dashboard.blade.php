<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('User List') }}
            </h2>
            <div class="relative">
                <x-secondary-button id="searchButton"
                    class="flex items-center gap-4 text-gray-800 focus:outline-none dark:text-gray-200">
                    Search
                    <svg class="h-6 w-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>

                </x-secondary-button>
                <div id="searchDropdown"
                    class="absolute right-0 z-50 mt-2 hidden w-96 rounded-md border border-gray-200 bg-white p-4 shadow-lg dark:border-gray-600 dark:bg-gray-800">
                    <form>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="mt-1 block w-full" type="text" name="name"
                                    :value="request('name')" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="mt-1 block w-full" type="text" name="email"
                                    :value="request('email')" />
                            </div>
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <x-text-input id="status" class="mt-1 block w-full" type="text" name="status"
                                    :value="request('status')" />
                            </div>

                            <div>
                                <x-input-label for="role" :value="__('Role')" />
                                <select id="role" name="role"
                                    class="block w-full appearance-none rounded border border-gray-300 bg-white px-3 py-2 pr-8 leading-tight text-gray-700 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                    <option value="">{{ __('Select Role') }}</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                                        {{ __('Admin') }}</option>
                                    <option value="nuser" {{ request('role') == 'nuser' ? 'selected' : '' }}>
                                        {{ __('User') }}</option>
                                    <option value="oper" {{ request('role') == 'oper' ? 'selected' : '' }}>
                                        {{ __('Operator') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <x-primary-button type="submit">
                                {{ __('Search') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="px-6 py-2 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                            <thead
                                class="bg-gray-100 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Role
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                                        <th scope="row"
                                            class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $user->name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $user->status }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $user->role }}
                                        </td>
                                        <td class="flex gap-4 px-6 py-4">
                                            @include('user.partials.edit-user-form', [
                                                'user' => $user,
                                                'currentRole' => $currentRole,
                                            ])
                                            @if ($currentRole == 'admin')
                                                <x-danger-button
                                                    onclick="confirmDelete({{ $user->id }})">Delete</x-danger-button>
                                            @else
                                                <x-danger-button disabled
                                                    onclick="confirmDelete({{ $user->id }})">Delete</x-danger-button>
                                            @endif

                                        </td>
                                    </tr>
                                    <form id="deleteForm_{{ $user->id }}"
                                        action="{{ route('users.destroy', $user->id) }}" method="POST"
                                        class="hidden-item">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    <!-- Confirm Delete Popup -->
    <div id="confirmDeletePopup"
        class="hidden-item fixed inset-0 flex items-center justify-center bg-gray-600 bg-opacity-50">
        <div class="rounded-lg bg-white p-6 text-center shadow-lg">
            <h2 class="mb-4 text-lg font-bold">Confirm Delete</h2>
            <p>Are you sure you want to delete this user?</p>
            <div class="mt-6 flex justify-between">
                <x-secondary-button id="cancelButton">Cancel</x-secondary-button>
                <x-primary-button id="confirmButton">OK</x-primary-button>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .hidden-item {
        display: none;
    }

    .fixed {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .blur-backdrop {
        backdrop-filter: blur(5px);
        /* Add blur effect */
    }

    .no-scroll {
        overflow: hidden;
        /* Disable scrolling */
    }
</style>

<script>
    let deleteUserId = null;

    function confirmDelete(userId) {
        deleteUserId = userId;
        document.getElementById('confirmDeletePopup').classList.remove('hidden-item');
        document.body.classList.add('no-scroll');
    }

    document.getElementById('cancelButton').addEventListener('click', function() {
        document.getElementById('confirmDeletePopup').classList.add('hidden-item');
        document.body.classList.remove('no-scroll');
        deleteUserId = null;
    });

    document.getElementById('confirmButton').addEventListener('click', function() {
        if (deleteUserId) {
            document.getElementById('deleteForm_' + deleteUserId).submit();
        }
    });

    document.getElementById('searchButton').addEventListener('click', function() {
        const dropdown = document.getElementById('searchDropdown');
        dropdown.classList.toggle('hidden');
    });
</script>
