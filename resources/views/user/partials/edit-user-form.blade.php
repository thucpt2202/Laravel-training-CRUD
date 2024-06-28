<form x-data="{ openEditDialog: false }"">
  <x-secondary-button x-on:click="openEditDialog = true">Edit
  </x-secondary-button>
  <template x-if="openEditDialog">
    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true">
      </div>
      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div
          class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <div
            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
              aaaaaaaaaaaaaaa
            </div>
            <div class="gap-4 bg-gray-100 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
              <x-primary-button type="submit">Submit</x-primary-button>
              <x-secondary-button x-on:click="openEditDialog = false">Cancel</x-secondary-button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
</form>