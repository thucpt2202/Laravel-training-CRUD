<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('User List') }}
            </h2>
            <div class="relative">
                <x-secondary-button id="searchButton" class="flex items-center text-gray-800 dark:text-gray-200 focus:outline-none gap-4 ">
                    Search
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                      </svg>
                      
                </x-secondary-button>
                <div id="searchDropdown" class="hidden absolute right-0 mt-2 w-96 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-md shadow-lg p-4 z-50">
                    <form>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="request('name')" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="request('email')" />
                            </div>
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <x-text-input id="status" class="block mt-1 w-full" type="text" name="status" :value="request('status')" />
                            </div>
                            
                            <div>
                                <x-input-label for="role" :value="__('Role')" />
                                <select id="role" name="role" class="block appearance-none w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                    <option value="">{{ __('Select Role') }}</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>{{ __('Admin') }}</option>
                                    <option value="nuser" {{ request('role') == 'nuser' ? 'selected' : '' }}>{{ __('User') }}</option>
                                    <option value="oper" {{ request('role') == 'oper' ? 'selected' : '' }}>{{ __('Operator') }}</option>
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-2 px-6 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                @foreach($users as $user)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
                                        <td class="px-6 py-4 flex gap-4">
                                            <x-secondary-button>Edit</x-secondary-button>
                                            <x-danger-button onclick="confirmDelete({{ $user->id }})">Delete</x-danger-button>
                                        </td>
                                    </tr>
                                    <form id="deleteForm_{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="hidden-item">
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
    <div id="confirmDeletePopup" class="hidden-item fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h2 class="text-lg font-bold mb-4">Confirm Delete</h2>
            <p>Are you sure you want to delete this user?</p>
            <div class="flex justify-between mt-6">
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
    backdrop-filter: blur(5px); /* Add blur effect */
}

.no-scroll {
    overflow: hidden; /* Disable scrolling */
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