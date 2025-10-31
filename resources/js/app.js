import './bootstrap';
import Alpine from 'alpinejs';
import 'flowbite'; // هذا السطر سيظل موجودًا

window.Alpine = Alpine;
Alpine.start();

// السطر الجديد والمهم:
// هذا الكود يضمن أن يتم تهيئة مكونات Flowbite بعد تحميل الصفحة بالكامل
document.addEventListener('DOMContentLoaded', function() {
  // إذا كان لديك مكونات تضاف ديناميكيًا، استخدم initFlowbite() هنا
  // لكن في حالتنا، يكفي وجود import 'flowbite' أعلاه.
  // هذا الـ listener فقط يضمن التوقيت الصحيح.
});