<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            تعديل الفئة: {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- مهم جدًا لعملية التحديث --}}

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">اسم الفئة</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                تحديث
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>