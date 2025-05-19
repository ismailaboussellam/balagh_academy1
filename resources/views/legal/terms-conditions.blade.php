@extends('partials.myapp')

@section('title', 'الشروط والأحكام')

@section('content')

<div class="max-w-4xl mx-auto px-4 py-10 text-gray-800 space-y-6">

    <div class="bg-white rounded-xl shadow p-6 mb-4">
        <h1 class="text-3xl font-bold text-green-700 mb-2">الشروط والأحكام – أكاديمية بلاغ</h1>
        <p>مرحباً بكم في منصة أكاديمية بلاغ للعلوم الدينية. يرجى قراءة هذه الشروط بعناية قبل استخدام الموقع.</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">1. القبول بالشروط</h2>
        <p>باستخدامك لهذا الموقع، فإنك توافق على الالتزام بهذه الشروط والأحكام. إذا كنت لا توافق على أي جزء منها، يرجى عدم استخدام المنصة.</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">2. استخدام المنصة</h2>
        <ul class="list-disc list-inside space-y-1">
            <li>يجب استخدام المنصة فقط لأغراض تعليمية ودعوية وفقاً لمنهج أهل السنة والمذهب المالكي.</li>
            <li>يمنع نشر أو إرسال أي محتوى يخالف الدين أو الآداب العامة.</li>
            <li>يمنع استخدام حسابك للقيام بأي نشاط غير مصرح به.</li>
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">3. التسجيل والحسابات</h2>
        <ul class="list-disc list-inside space-y-1">
            <li>يجب على المستخدم تقديم معلومات صحيحة وكاملة عند التسجيل.</li>
            <li>المستخدم مسؤول عن سرية معلومات الدخول الخاصة به.</li>
            <li>يحق للإدارة تعليق أو حذف أي حساب يخالف الشروط.</li>
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">4. حقوق الملكية</h2>
        <p>
            جميع المواد التعليمية، الدروس، الفيديوهات، والشعارات المنشورة في الموقع هي ملك لأكاديمية بلاغ ولا يجوز إعادة نشرها أو استخدامها دون إذن كتابي مسبق.
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">5. التعديلات على الشروط</h2>
        <p>يحتفظ الموقع بحق تعديل هذه الشروط في أي وقت. يتم إشعار المستخدمين بالتحديثات عبر المنصة.</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">6. إخلاء المسؤولية</h2>
        <p>
            الأكاديمية غير مسؤولة عن أي أضرار مباشرة أو غير مباشرة ناتجة عن استخدام المنصة. نحن نبذل جهدنا لضمان صحة المحتوى، لكن لا نضمن خلوه من الأخطاء بشكل تام.
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">7. التواصل</h2>
        <p>
            لأي استفسار بخصوص الشروط والأحكام، يرجى التواصل معنا عبر البريد الإلكتروني:<br>
            <strong class="text-green-700">balaghacademy@gmail.com</strong>
        </p>
    </div>
</div>

@endsection
