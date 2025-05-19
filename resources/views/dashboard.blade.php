<x-app-layout>
<div class="min-h-screen bg-gradient-to-br from-indigo-100 via-white to-green-100 py-10 px-2">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- القسم الرئيسي -->
        <div class="md:col-span-2">
<h1 class="text-3xl font-bold mb-2 text-indigo-700">
    @if(Auth::user())
        مرحبا، {{ Auth::user()->first_name }} 👋
    @else
        مرحبا بك 👋
    @endif
</h1>
            <p class="text-gray-500 mb-6">سعيدون بعودتك! واصل رحلتك التعليمية اليوم.</p>
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">دروس اليوم</h2>
                <div class="space-y-4">
                    <!-- بطاقة درس -->
                    <div class="bg-white rounded-xl shadow flex items-center justify-between p-5">
                        <div class="flex items-center gap-4">
                            <div class="bg-indigo-100 rounded-full p-3">
                                <i class="fas fa-dna text-indigo-600 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-indigo-700">البيولوجيا الجزيئية</h3>
                                <div class="text-xs text-gray-500 flex gap-2">
                                    <span>21 درس</span>·
                                    <span>5 واجبات</span>·
                                    <span>50 دقيقة</span>·
                                    <span>312 طالب</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="font-bold text-green-600 mb-2">%79</span>
                            <div class="flex gap-2">
                                <button class="bg-gray-200 text-gray-600 px-3 py-1 rounded hover:bg-gray-300">تخطي</button>
                                <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">متابعة</button>
                            </div>
                        </div>
                    </div>
                    <!-- بطاقة درس أخرى -->
                    <div class="bg-white rounded-xl shadow flex items-center justify-between p-5">
                        <div class="flex items-center gap-4">
                            <div class="bg-green-100 rounded-full p-3">
                                <i class="fas fa-palette text-green-600 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-green-700">نظرية الألوان</h3>
                                <div class="text-xs text-gray-500 flex gap-2">
                                    <span>10 دروس</span>·
                                    <span>2 واجبات</span>·
                                    <span>45 دقيقة</span>·
                                    <span>256 طالب</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="font-bold text-yellow-600 mb-2">%64</span>
                            <div class="flex gap-2">
                                <button class="bg-gray-200 text-gray-600 px-3 py-1 rounded hover:bg-gray-300">تخطي</button>
                                <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">متابعة</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- الكلاسات -->
            <div>
                <h2 class="text-lg font-semibold mb-4 text-gray-700">صفوفك</h2>
                <div class="bg-yellow-50 rounded-xl shadow p-5 flex items-center gap-4">
                    <div class="bg-green-200 rounded-full p-3">
                        <i class="fas fa-virus text-green-700 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-yellow-700">مجتمع الأحياء الدقيقة</h3>
                        <div class="text-xs text-gray-500 flex gap-2">
                            <span>10 دروس</span>·
                            <span>2 واجبات</span>·
                            <span>45 دقيقة</span>·
                            <span>256 طالب</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- الشريط الجانبي -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                <div class="w-20 h-20 rounded-full bg-indigo-200 mb-3 flex items-center justify-center overflow-hidden">
                    <i class="fas fa-user text-indigo-700 text-4xl"></i>
                </div>

<div class="text-center">
    @if(Auth::user())
        <h3 class="font-bold text-lg">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
        <p class="text-gray-500 text-sm">{{ Auth::user()->email }}</p>
    @else
        <h3 class="font-bold text-lg">زائر</h3>
        <p class="text-gray-500 text-sm">---</p>
    @endif
</div>

                <div class="flex justify-between w-full mt-4 text-center">
                    <div>
                        <span class="block text-indigo-700 font-bold text-xl">24</span>
                        <span class="text-xs text-gray-500">دورة</span>
                    </div>
                    <div>
                        <span class="block text-green-700 font-bold text-xl">18</span>
                        <span class="text-xs text-gray-500">شهادة</span>
                    </div>
                </div>
            </div>
            <div class="bg-green-100 rounded-xl shadow p-6 flex items-center justify-between">
                <div>
                    <span class="block text-2xl font-bold text-green-700">2400 XP</span>
                    <span class="text-xs text-gray-500">نقاط الخبرة</span>
                </div>
                <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">جمع النقاط</button>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-orange-100 rounded-xl shadow p-4 flex flex-col items-center">
                    <i class="fas fa-comments text-orange-500 text-2xl mb-2"></i>
                    <span class="font-bold text-orange-700">استشارة</span>
                    <span class="text-xs text-gray-500 text-center">احصل على مساعدة من معلم</span>
                </div>
                <div class="bg-pink-100 rounded-xl shadow p-4 flex flex-col items-center">
                    <i class="fas fa-bullseye text-pink-500 text-2xl mb-2"></i>
                    <span class="font-bold text-pink-700">تحديد هدف</span>
                    <span class="text-xs text-gray-500 text-center">حدد هدفك وخطة دراستك</span>
                </div>
            </div>
            <!-- رسم بياني بسيط (صورة فقط) -->
            <div class="bg-white rounded-xl shadow p-6">
                <h4 class="font-bold mb-2 text-gray-700">نشاطك الدراسي</h4>
                <img src="https://www.chartjs.org/img/chartjs-logo.svg" alt="Graph" class="w-full h-24 object-contain opacity-40">
                <div class="flex justify-between text-xs text-gray-400 mt-2">
                    <span>أغسطس</span><span>سبتمبر</span><span>أكتوبر</span><span>نوفمبر</span><span>ديسمبر</span>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
