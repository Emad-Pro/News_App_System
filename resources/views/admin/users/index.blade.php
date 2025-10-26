<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            إدارة المستخدمين
        </h2>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">قائمة المستخدمين</h3>
                <a href="{{ route('admin.users.create') }}"
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm transition">
                    + إضافة مستخدم جديد
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-900">
                        <tr>
                            <th class="px-4 py-3 text-right font-semibold text-gray-700 dark:text-gray-300">#</th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-700 dark:text-gray-300">الاسم</th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-700 dark:text-gray-300">البريد الإلكتروني</th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-700 dark:text-gray-300">الهاتف</th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-700 dark:text-gray-300">الحالة</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-300">التحكم</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-200">{{ $user->id }}</td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-100 font-medium">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $user->phone ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $user->status === 'active'
                                            ? 'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200'
                                            : 'bg-red-100 text-red-700 dark:bg-red-800 dark:text-red-200' }}">
                                        {{ $user->status === 'active' ? 'نشط' : 'محظور' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 flex justify-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="px-3 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                                        تعديل
                                    </a>

                                    <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 text-xs rounded-md transition
                                            {{ $user->status === 'active'
                                                ? 'bg-yellow-500 hover:bg-yellow-600 text-white'
                                                : 'bg-green-600 hover:bg-green-700 text-white' }}">
                                            {{ $user->status === 'active' ? 'حظر' : 'تفعيل' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
