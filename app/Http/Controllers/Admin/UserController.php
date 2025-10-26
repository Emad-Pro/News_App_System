<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // البحث
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
        }

        $users = $query->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // ... (edit, update, destroy methods)

    // لتفعيل وحظر المستخدم
    public function toggleStatus(User $user)
    {
        $user->status = $user->status === 'active' ? 'banned' : 'active';
        $user->save();
        return back()->with('success', 'User status updated successfully.');
    }
}