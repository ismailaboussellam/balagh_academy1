@extends('partials.myapp')

@section('title', 'سياسة الخصوصية')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10 text-gray-800 space-y-6">

    <div class="bg-white rounded-xl shadow p-6 mb-4">
        <h1 class="text-3xl font-bold text-green-700 mb-2">سياسة الخصوصية – أكاديمية بلاغ</h1>
        <p class="mb-2 text-sm text-gray-500">آخر تحديث: {{ now()->format('Y-m-d') }}</p>
        <p>
            في أكاديمية بلاغ للعلوم الدينية، نحن ملتزمون بحماية خصوصية زوارنا ومستخدمينا. تشرح هذه السياسة كيفية جمعنا واستخدامنا وحمايتنا للمعلومات الشخصية التي تقدمها لنا عند استخدامك للموقع.
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">1. المعلومات التي نجمعها</h2>
        <ul class="list-disc list-inside space-y-1">
            <li>الاسم الكامل</li>
            <li>البريد الإلكتروني</li>
            <li>رقم الهاتف</li>
            <li>تاريخ الميلاد</li>
            <li>الدولة</li>
            <li>نوع المستخدم (أستاذ، طالب، ولي أمر، مشرف...)</li>
            <li>التقدم الدراسي للطالب (من طرف الأساتذة)</li>
            <li>رسائل وتعليقات داخل المنصة</li>
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">2. كيف نستخدم المعلومات؟</h2>
        <p class="mb-2">نستخدم المعلومات لتقديم وتحسين خدماتنا، وذلك يشمل:</p>
        <ul class="list-disc list-inside space-y-1">
            <li>تسجيل المستخدمين وتحديد أدوارهم</li>
            <li>متابعة التقدم العلمي للطلاب</li>
            <li>إرسال إشعارات تعليمية أو إدارية</li>
            <li>تحسين تجربة المستخدم داخل الموقع</li>
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">3. حماية المعلومات</h2>
        <p>نقوم بتأمين بياناتك باستخدام تقنيات الحماية الحديثة (SSL، قواعد بيانات محمية...) لضمان عدم الوصول غير المصرح به إليها.</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">4. من يمكنه الوصول إلى المعلومات؟</h2>
        <ul class="list-disc list-inside space-y-1">
            <li>المشرف (admin) لديه صلاحية الاطلاع على جميع البيانات.</li>
            <li>الأستاذ يرى فقط بيانات طلابه.</li>
            <li>ولي الأمر يرى فقط بيانات أطفاله وتقدمهم.</li>
            <li>لا تتم مشاركة المعلومات مع أي طرف ثالث.</li>
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">5. ملفات تعريف الارتباط (Cookies)</h2>
        <p>قد نستخدم ملفات الكوكيز لتحسين تجربتك وتذكر تفضيلاتك. يمكنك تعطيلها من إعدادات المتصفح.</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">6. حقوقك كمستخدم</h2>
        <ul class="list-disc list-inside space-y-1">
            <li>لك الحق في طلب الوصول إلى بياناتك.</li>
            <li>يمكنك طلب تعديل أو حذف معلوماتك الشخصية.</li>
            <li>يمكنك إغلاق حسابك في أي وقت بطلب من الإدارة.</li>
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">7. التعديلات على سياسة الخصوصية</h2>
        <p>نحتفظ بحق تعديل هذه السياسة في أي وقت. سيتم إعلام المستخدمين عند حدوث تغييرات جوهرية.</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">8. التواصل معنا</h2>
        <p>إذا كان لديك أي استفسار أو طلب متعلق بخصوصيتك، يرجى التواصل معنا عبر البريد:<br>
            <strong class="text-green-700">balaghacademy@gmail.com</strong>
        </p>
    </div>
</div>
@endsection
