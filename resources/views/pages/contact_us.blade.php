@extends('partials.myapp')

@section('title', 'اتصل بنا')

@section('content')

<div class="bg-gray-50 py-10 mb-10">
    <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8 px-4">
        <!-- الصورة -->
        <div class="flex-1 flex justify-center">
            <img src="{{ asset('images/Quran-Gate.jpg') }}" alt="أكاديمية بلاغ" class="max-h-56 md:max-h-64">
        </div>
        <!-- النص -->
        <div class="flex-1 text-center md:text-right">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">أكاديمية الإمام الباجي</h2>
            <p class="text-gray-600 mb-4">
                الوجهة الأساسية من إنشاء الأكاديمية هو تزويد المسلم بما لا يسعه جهله من دينه، وتيسير طلب العلم لجميع الناس مهما كانت ظروفهم وكيفما كانت انشغالاتهم.
            </p>
            <a href="{{ route('system') }}" class="text-blue-700 hover:underline font-semibold inline-flex items-center">
                الاطلاع على النظام الأكاديمي
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>
</div>


<div class="max-w-lg mx-auto mt-10 mb-16">
    <h2 class="text-2xl md:text-3xl font-bold text-gray-700 text-center mb-2">
        يُسعدنا استقبال <span class="text-green-700">مراسلاتكم واستفساراتكم</span>، سنُجيبكم في أقرب الآجال
    </h2>
    <p class="text-center text-gray-500 mb-8">بحول الله تعالى..</p>
    <form class="space-y-4 bg-white rounded-xl shadow p-6" method="POST" action="#">
        @csrf
        <input type="text" name="name" placeholder="الاسم" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400 transition" required>
        <input type="email" name="email" placeholder="البريد الإلكتروني" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400 transition" required>
        <div class="text-xs text-gray-400 mb-2">البريد الإلكتروني للأكاديمية</div>
        <div class="w-full bg-gray-100 rounded-lg px-4 py-2 text-gray-700 select-all mb-2">balaghacademy@gmail.com</div>
        <input type="text" name="phone" placeholder="رقم الهاتف" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400 transition">
        <input type="text" name="subject" placeholder="الموضوع" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400 transition">
        <textarea name="message" placeholder="الرسالة" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400 transition"></textarea>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow transition">إرسال</button>
    </form>
    <a href="https://wa.me/212600000000" target="_blank" class="flex items-center justify-end mt-4 text-green-600 hover:underline text-sm">
        <svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M20.52 3.48A11.93 11.93 0 0012 0C5.37 0 0 5.37 0 12c0 2.11.55 4.16 1.6 5.97L0 24l6.18-1.62A11.94 11.94 0 0012 24c6.63 0 12-5.37 12-12 0-3.19-1.24-6.19-3.48-8.52zM12 22c-1.85 0-3.68-.5-5.25-1.44l-.38-.22-3.67.96.98-3.58-.25-.37A9.93 9.93 0 012 12c0-5.52 4.48-10 10-10s10 4.48 10 10-4.48 10-10 10zm5.2-7.8c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.7.9-.86 1.08-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.25-1.4-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.34.42-.51.14-.17.18-.29.28-.48.09-.18.05-.36-.02-.5-.07-.14-.61-1.47-.84-2.02-.22-.53-.45-.46-.61-.47-.16-.01-.35-.01-.54-.01-.18 0-.47.07-.72.34-.25.27-.97.95-.97 2.3 0 1.34.99 2.64 1.13 2.82.14.18 1.95 2.98 4.74 4.06.66.28 1.18.45 1.58.58.66.21 1.26.18 1.73.11.53-.08 1.65-.67 1.88-1.32.23-.65.23-1.2.16-1.32-.07-.12-.25-.19-.53-.33z"/></svg>
        تواصل معنا على واتساب
    </a>
</div>
@endsection
