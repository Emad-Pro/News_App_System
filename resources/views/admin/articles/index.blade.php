<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-white leading-tight">
                إدارة المقالات
            </h2>
            <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#00ADB5] hover:bg-[#02C39A] text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                <i class="fas fa-plus-circle"></i>
                إضافة مقال جديد
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                <div class="p-6 text-white">

                    <form method="GET" action="{{ route('admin.articles.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 items-center">
                            <div class="md:col-span-2 relative">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </span>
                                <input type="text" name="search" placeholder="ابحث بالعنوان..." value="{{ request('search') }}"
                                       class="w-full rounded-lg border-gray-500 bg-gray-900/50 text-white focus:border-[#00ADB5] focus:ring-2 focus:ring-[#00ADB5] transition pr-10">
                            </div>
                            <div>
                                <select name="category" class="w-full rounded-lg border-gray-500 bg-gray-900/50 text-white focus:border-[#00ADB5] focus:ring-2 focus:ring-[#00ADB5] transition">
                                    <option value="">كل الفئات</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center space-x-2 space-x-reverse">
                                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-[#00ADB5] text-white rounded-lg hover:bg-[#02C39A] transition">
                                    <i class="fas fa-filter"></i>
                                    <span>بحث</span>
                                </button>
                                <a href="{{ route('admin.articles.index') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-gray-600/50 text-white rounded-lg hover:bg-gray-500/50 transition" title="إعادة ضبط الفلاتر">
                                    <i class="fas fa-sync-alt"></i>
                                    <span>إعادة ضبط</span>
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="border-b border-white/20">
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">العنوان</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">الفئة</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">الحالة</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">الإحصائيات</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-300 uppercase tracking-wider">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @forelse ($articles as $article)
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ Str::limit($article->title, 40) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $article->category->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $article->status == 'published' ? 'bg-green-500/20 text-green-300' : 'bg-yellow-500/20 text-yellow-300' }}">
                                                {{ $article->status == 'published' ? 'منشور' : 'مسودة' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            <span class="mr-4" title="المشاهدات"><i class="fas fa-eye mr-1"></i> {{ $article->views_count }}</span>
                                            <span title="الإعجابات"><i class="fas fa-heart text-red-400 mr-1"></i> {{ $article->likes_count }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center gap-4">
                                                <a href="{{ route('admin.articles.show', $article) }}" class="text-green-400 hover:text-green-300" title="عرض التفاصيل">
                                                    <i class="fas fa-eye fa-lg"></i>
                                                </a>
                                                <a href="{{ route('admin.articles.edit', $article) }}" class="text-blue-400 hover:text-blue-300" title="تعديل المقال">
                                                    <i class="fas fa-pen fa-lg"></i>
                                                </a>
                                                {{-- يمكنك إضافة زر حذف هنا بنفس الطريقة --}}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 whitespace-nowrap text-sm text-gray-400 text-center">
                                            <i class="fas fa-folder-open fa-3x mb-3"></i>
                                            <p>لا توجد مقالات تطابق بحثك.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>