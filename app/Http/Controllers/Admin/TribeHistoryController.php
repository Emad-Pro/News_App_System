<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TribeHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class TribeHistoryController extends Controller
{
    /**
     * عرض صفحة كل الأحداث التاريخية
     */
    public function index()
    {
        $events = TribeHistory::latest()->get();
        // اسم الواجهة هو index.blade.php
        return view('admin.tribe-history.index', compact('events'));
    }

    /**
     * عرض فورم إضافة حدث جديد
     */
    public function create()
    {
        // اسم الواجهة هو create.blade.php
        return view('admin.tribe-history.create');
    }

public function destroy(TribeHistory $history)
{
    // 1. حذف جميع الصور المرتبطة بالحدث من مجلد التخزين
    foreach ($history->images as $image) {
        Storage::disk('public')->delete($image->path);
    }
    // ملاحظة: سيتم حذف سجلات الصور من جدول 'tribe_history_images' تلقائيًا
    // بسبب onDelete('cascade') الذي أضفناه في الـ migration.

    // 2. حذف سجل الحدث نفسه من قاعدة البيانات
    $history->delete();

    // 3. إعادة التوجيه إلى صفحة العرض مع رسالة نجاح
    return redirect()->route('admin.histories.index')
                     ->with('success', 'تم حذف الحدث التاريخي بنجاح.');
}public function show(TribeHistory $history)
{
    // The $history variable already contains the event from the database.
    // We just need to load its images and pass it to the view.
    $history->load('images');

    return view('admin.tribe-history.show', compact('history'));
}
public function store(Request $request)
{
    // 1. التحقق من صحة البيانات المدخلة
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'event_date' => 'required|string|max:100',
        'description' => 'required|string',
        'images' => 'nullable|array', // تأكد من أن الحقل هو مصفوفة إذا وُجد
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048' // قواعد التحقق لكل صورة
    ]);

    // 2. إنشاء الحدث التاريخي أولاً
    $historyEvent = TribeHistory::create([
        'title' => $validated['title'],
        'event_date' => $validated['event_date'],
        'description' => $validated['description'],
    ]);

    // 3. التحقق من وجود صور وحفظها
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            // تخزين الصورة في storage/app/public/history_images
            $path = $image->store('history_images', 'public');

            // إنشاء سجل في جدول الصور وربطه بالحدث
            $historyEvent->images()->create(['path' => $path]);
        }
    }

    // 4. إعادة التوجيه إلى صفحة العرض مع رسالة نجاح
    return redirect()->route('admin.histories.index')
                     ->with('success', 'تم إضافة الحدث التاريخي والصور بنجاح.');
}
}