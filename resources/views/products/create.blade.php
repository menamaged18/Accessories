<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8">

                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                    Add New Product
                </h2>


                <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Product Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" placeholder="e.g. Gold Necklace" required />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            placeholder="Describe the product details..."></textarea>
                    </div>

                    <div class="max-w-xs">
                        <x-input-label for="price" :value="__('Price ($)')" />
                        <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" placeholder="0.00" required />
                    </div>

                    <input type="file" name="image" class="text-white">

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-3">
                            {{ __('Create Product') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
