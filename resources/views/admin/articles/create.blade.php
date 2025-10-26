<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            إضافة مقال جديد
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            
                            <div class="md:col-span-2 space-y-4">
                                <div>
                                    <label for="title" class="block font-medium text-sm text-gray-700">العنوان</label>
                                    <input type="text" name="title" id="title" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                </div>

                                <div>
                                    <label for="content" class="block font-medium text-sm text-gray-700">المحتوى</label>
                                    <textarea name="content" id="content" rows="15" class="block mt-1 w-full rounded-md shadow-sm border-gray-300"></textarea>
                                </div>
                                
                                <div>
                                    <label for="media_files" class="block font-medium text-sm text-gray-700">معرض الصور والفيديوهات (اختياري)</label>
                                    <input type="file" name="media_files[]" id="media_files" multiple class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label for="published_at" class="block font-medium text-sm text-gray-700">وقت النشر</label>
                                    <input type="datetime-local" name="published_at" id="published_at" value="{{ now()->format('Y-m-d\TH:i') }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                </div>

                                <div>
                                    <label for="featured_image" class="block font-medium text-sm text-gray-700">الصورة الرئيسية</label>
                                    <input type="file" name="featured_image" id="featured_image" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                
                                <div>
                                    <label for="category_id" class="block font-medium text-sm text-gray-700">الفئة</label>
                                    <select name="category_id" id="category_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="status" class="block font-medium text-sm text-gray-700">الحالة</label>
                                    <select name="status" id="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                        <option value="published">منشور</option>
                                        <option value="draft">مسودة</option>
                                    </select>
                                </div>

                                <div class="mt-6">
                                    <button type="submit" class="w-full justify-center px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700">
                                        حفظ المقال
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>