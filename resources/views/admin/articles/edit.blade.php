<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            تعديل المقال: <span class="font-normal text-gray-300">{{ Str::limit($article->title, 50) }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                <div class="p-8 text-white">
                    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            
                            <div class="md:col-span-2 space-y-6">
                                <div>
                                    <label for="title" class="block font-medium text-sm text-gray-300 mb-1">العنوان</label>
                                    <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" required
                                           class="w-full rounded-lg border-gray-500 bg-gray-900/50 text-white focus:border-[#00ADB5] focus:ring-2 focus:ring-[#00ADB5] transition">
                                </div>

                                <div>
                                    <label for="content" class="block font-medium text-sm text-gray-300 mb-1">المحتوى</label>
                                    {{-- ملاحظة: يتطلب TinyMCE إعدادات خاصة للثيم المظلم --}}
                                    <textarea name="content" id="content" rows="15"
                                              class="w-full rounded-lg border-gray-500 bg-gray-900/50 text-white focus:border-[#00ADB5] focus:ring-2 focus:ring-[#00ADB5] transition">{{ old('content', $article->content) }}</textarea>
                                </div>

                                <div>
                                    <label for="media_files" class="block font-medium text-sm text-gray-300 mb-1">إضافة صور وفيديوهات (اختياري)</label>
                                    <input type="file" name="media_files[]" id="media_files" multiple
                                           class="block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#00ADB5]/20 file:text-[#00ADB5] hover:file:bg-[#00ADB5]/30 cursor-pointer">
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="published_at" class="block font-medium text-sm text-gray-300 mb-1">وقت النشر</label>
                                    <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', \Carbon\Carbon::parse($article->published_at)->format('Y-m-d\TH:i')) }}"
                                           class="w-full rounded-lg border-gray-500 bg-gray-900/50 text-white focus:border-[#00ADB5] focus:ring-2 focus:ring-[#00ADB5] transition">
                                </div>
                                
                                <div>
                                    <label for="featured_image" class="block font-medium text-sm text-gray-300 mb-2">تغيير الصورة الرئيسية</label>
                                    @if($article->featured_image)
                                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="الصورة الحالية" class="mb-3 w-full h-auto rounded-lg border border-white/20">
                                    @endif
                                    <input type="file" name="featured_image" id="featured_image"
                                           class="block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#00ADB5]/20 file:text-[#00ADB5] hover:file:bg-[#00ADB5]/30 cursor-pointer">
                                </div>
                                
                                <div>
                                    <label for="category_id" class="block font-medium text-sm text-gray-300 mb-1">الفئة</label>
                                    <select name="category_id" id="category_id" class="w-full rounded-lg border-gray-500 bg-gray-900/50 text-white focus:border-[#00ADB5] focus:ring-2 focus:ring-[#00ADB5] transition">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('category_id', $article->category_id) == $category->id)>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="status" class="block font-medium text-sm text-gray-300 mb-1">الحالة</label>
                                    <select name="status" id="status" class="w-full rounded-lg border-gray-500 bg-gray-900/50 text-white focus:border-[#00ADB5] focus:ring-2 focus:ring-[#00ADB5] transition">
                                        <option value="published" @selected(old('status', $article->status) == 'published')>منشور</option>
                                        <option value="draft" @selected(old('status', $article->status) == 'draft')>مسودة</option>
                                    </select>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-[#00ADB5] text-white font-semibold rounded-lg hover:bg-[#02C39A] shadow-md transition duration-300 transform hover:scale-105">
                                        <i class="fas fa-save"></i>
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