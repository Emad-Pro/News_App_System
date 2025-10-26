<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        // الحصول على المستخدم المسجل دخوله حاليًا
        $user = $request->user();

        // 1. التحقق من صحة البيانات المدخلة
        $validatedData = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => [
                'sometimes', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users')->ignore($user->id) // يجب أن يكون البريد فريدًا، مع تجاهل المستخدم الحالي
            ],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // 2. تحديث البيانات الأساسية
        if ($request->has('name')) {
            $user->name = $validatedData['name'];
        }
        if ($request->has('email')) {
            $user->email = $validatedData['email'];
        }

        // 3. تحديث كلمة المرور (فقط إذا تم إدخال كلمة جديدة)
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        // 4. تحديث الصورة الشخصية (إن وجدت)
        if ($request->hasFile('avatar')) {
            // حذف الصورة القديمة أولاً لتوفير المساحة
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // تخزين الصورة الجديدة
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // 5. حفظ كل التغييرات في قاعدة البيانات
        $user->save();

        // 6. إرجاع بيانات المستخدم المحدثة
        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user,
        ]);
    }
}