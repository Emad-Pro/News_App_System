<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تعديل المقال: {{ $article->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    {{-- 1. Corrected the form action and added the PUT method --}}
                    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            
                            <div class="md:col-span-2 space-y-4">
                                <div>
                                    <label for="title" class="block font-medium text-sm text-gray-700">العنوان</label>
                                    {{-- 2. Populated the value --}}
                                    <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                </div>

                                <div>
                                    <label for="content" class="block font-medium text-sm text-gray-700">المحتوى</label>
                                    {{-- 2. Populated the textarea --}}
                                    <textarea name="content" id="content" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">{{ old('content', $article->content) }}</textarea>
                                </div>
                                
                                <div>
                                    <label for="media_files" class="block font-medium text-sm text-gray-700">إضافة صور وفيديوهات (اختياري)</label>
                                    <input type="file" name="media_files[]" id="media_files" multiple class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="published_at" class="block font-medium text-sm text-gray-700">وقت النشر</label>
                                    {{-- 2. Populated and correctly formatted the date --}}
                                    <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', \Carbon\Carbon::parse($article->published_at)->format('Y-m-d\TH:i')) }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                </div>
                                
                                <div>
                                    <label for="featured_image" class="block font-medium text-sm text-gray-700">تغيير الصورة الرئيسية</label>
                                    {{-- 3. Added a preview for the current image --}}
                                    @if($article->featured_image)
                                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Featured Image" class="mt-2 mb-2 w-full h-auto rounded-md">
                                    @endif
                                    <input type="file" name="featured_image" id="featured_image" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                
                                <div>
                                    <label for="category_id" class="block font-medium text-sm text-gray-700">الفئة</label>
                                    <select name="category_id" id="category_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                        @foreach($categories as $category)
                                            {{-- 2. Marked the current category as selected --}}
                                            <option value="{{ $category->id }}" @selected(old('category_id', $article->category_id) == $category->id)>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="status" class="block font-medium text-sm text-gray-700">الحالة</label>
                                    <select name="status" id="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                        {{-- 2. Marked the current status as selected --}}
                                        <option value="published" @selected(old('status', $article->status) == 'published')>منشور</option>
                                        <option value="draft" @selected(old('status', $article->status) == 'draft')>مسودة</option>
                                    </select>
                                </div>

                                <div class="mt-6">
                                    <button type="submit" class="w-full justify-center px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700">
                                        تحديث المقال
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            tinymce.init({
                selector: 'textarea#content',
                plugins: 'code table lists image media link',
                toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | image media link',
                directionality: 'rtl',
                language: 'ar'
            });
        });
    </script> -->
</x-app-layout>