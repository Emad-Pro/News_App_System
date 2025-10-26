<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                إدارة المقالات
            </h2>
            <a href="{{ route('admin.articles.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                إضافة مقال جديد
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    <form method="GET" action="{{ route('admin.articles.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <input type="text" name="search" placeholder="ابحث بالعنوان..." value="{{ request('search') }}" class="block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>
                            <div>
                                <select name="category" class="block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    <option value="">كل الفئات</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center space-x-2 space-x-reverse">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">بحث</button>
                                <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md">إعادة ضبط</a>
                            </div>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">العنوان</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الفئة</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الحالة</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">المشاهدات</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الإعجابات</th>
                                    <th class="relative px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($articles as $article)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $article->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $article->category->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $article->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $article->status == 'published' ? 'منشور' : 'مسودة' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $article->views_count }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $article->likes->count() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                            <a href="{{ route('admin.articles.show', $article) }}" class="text-green-600 hover:text-green-900">عرض</a>
                                            <a href="{{ route('admin.articles.edit', $article) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">تعديل</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            لا توجد مقالات تطابق بحثك.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>