@extends('partials.myapp')

@section('title', ' التقويم الدراسي')

@section('content')
    <main>
        {{-- Hero Section --}}
    <section class="bg-cover bg-center text-white relative" style="background-image: url('images/qarawiyyine.jpeg')">
    <!-- طبقة داكنة فوق الصورة -->
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
    <div class="relative z-10 max-w-6xl mx-auto px-4 py-20">
        <div class="flex flex-col md:flex-row justify-between items-center md:items-start mb-10">
            <div class="mb-6 md:mb-0">
                <img src="{{ asset('images/BALAGH-ACADEMY-VERTICAL-LOGO.png') }}" alt="شعار الأكاديمية" class="w-32 md:w-40">
            </div>
            <div class="text-center md:text-right md:flex-1 md:ml-8">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">أكاديمية بلاغ</h1>
                <p class="text-lg md:text-xl leading-relaxed max-w-3xl mx-auto md:mx-0">

أكادمية علمية شرعية تهدف إلى تحفيظ كتاب الله تعالى وتدريس علومه على منهج أصيل بطرق معاصرة، تدرس الأكادمية الفقه الإسلامي على مذهب إمام دار الهجرة الإمام مالك ، وغيرها من علوم الشريعة التي يحتاجها طلاب العلم،
وتعمل على إعداد طلبة علم مؤصلين مؤهلين للدعوة الإسلامية، كما تعنى بتعليم اللغة العربية لغير الناطقين بها..
وتعمل كذلك على تعزيز القيم الإسلامية وبناء شخصية ذات قيم ومبادئ سليمة..
وكل هذا بطرق حديثة متطورة في التعليم..
                </p>
            </div>
        </div>

        <!-- زر التسجيل وروابط التواصل -->
        <div class="text-center">
            <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg text-lg transition">⚡ فتح حساب جديد</a>
            <div class="mt-6 flex justify-center space-x-4 rtl:space-x-reverse">
                <a href="#" class="text-white hover:text-blue-400 transition"><i class="fab fa-facebook text-xl"></i> تابعونا على الفيسبوك</a>
                <a href="#" class="text-white hover:text-pink-400 transition"><i class="fab fa-instagram text-xl"></i> تابعونا على إنستغرام</a>
            </div>
        </div>
    </div>
    </section>


        {{-- أهداف الأكاديمية --}}
        <section id='features' class="bg-gray-100 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-10 text-center border-b-4 border-green-500 inline-block pb-2">أهداف أكاديمية بلاغ</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-right">
                    @foreach ([
                        'تحفيظ القرآن الكريم وإتقان تلاوته.',
                        'تدريس العلوم الشرعية بأسلوب منهجي يجمع بين التأصيل الشرعي والمعاصرة.',
                        'الدعوة إلى الله بالحكمة والموعظة الحسنة، وإعداد دعاة مؤهلين علميًا وتربويًا.',
                        'تعليم اللغة العربية لغير الناطقين بها؛ نطقًا وقراءةً وكتابةً، مع التركيز على مهارات التواصل.',
                        'توظيف الوسائل الحديثة والتقنيات المعاصرة في التعليم والدعوة والتدريب.',
                        'تعزيز القيم الإسلامية والأخلاق الفاضلة لدى الطلاب، وبناء شخصية متوازنة تجمع بين العلم والعمل.',
                        'إقامة الدورات التدريبية والندوات التثقيفية في مختلف مجالات الشريعة واللغة والدعوة.',
                    ] as $goal)
                        <div class="bg-white rounded-lg shadow p-6 flex items-start gap-4">
                            <div class="mt-1 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <p class="text-gray-700 leading-relaxed">{{ $goal }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- مميزات الأكاديمية --}}
        <section class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                    @foreach ([
                        ['image' => 'trophy.jpeg', 'text' => 'جَوّ تفاعليّ وتنافسيّ في طلبِ العلم مع صحبةٍ صالحةٍ مباركة'],
                        ['image' => 'calendar.png', 'text' => 'مواعيد يوميّة منظمة واختبارات دورية ومرحلية للتحفيز'],
                        ['image' => 'book-check.png', 'text' => 'عناية كبيرة بتنسيق المقررات وجودة التسجيلات صوتاً وصورةً'],
                        ['image' => 'headphones.png', 'text' => 'لقاءات تفاعلية مباشرة مع المؤطرين من أجل صقلِ المعارف المكتسبة'],
                        ['image' => 'phone-touch.png', 'text' => 'منصة إلكترونية متكاملة وتفاعلية تساعد على تنظيم برنامج طلب العلم'],
                        ['image' => 'graduation.png', 'text' => 'طاقم تدريسيّ مكوّن من ثلةٍ من العلماء والدعاة البارزين والمتمكنين'],
                    ] as $feature)
                        <div class="bg-gray-50 rounded-2xl shadow p-6 text-center">
                            <img src="{{ asset('images/' . $feature['image']) }}" alt="..." class="mx-auto w-16 h-16 mb-4">
                            <h3 class="text-sm font-bold text-gray-800">{{ $feature['text'] }}</h3>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- قسم: ماذا قالوا عنا؟ -->
<section id='about' class="relative bg-cover bg-center bg-no-repeat text-white py-24 px-6"
         style="background-image: url('images/University_of_Al_Qaraouiyine.jpg');">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>

    <div class="relative z-10 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- الشهادات -->
            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach([
                    [
                        'name' => 'رضوان ض',
                        'date' => '15 أكتوبر 2018',
                        'text' => 'الحمد لله الذي أنعم علينا بهذا الخير ، وفتح لنا باب طلب العلم عن طريق هذه الأكاديمية العظيمة التي قررت لنا كل بعيد ، وأنا الشرف العظيم بالاستفادة منها لا من نظامها أو من مشايخ وأساتذة أخيار بارك الله فيهم وجزاهم الله خيرا على مِسيرهم علينا وعلى توجيههم لنا لسلك الطريق الميسر لطلب العلم.',
                    ],
                    [
                        'name' => 'جيريمي ب',
                        'date' => '12 مارس 2020',
                        'text' => 'إنني بفضل الله، من خلال هذه السنوات الأربعة قد استفدت كثيرًا من الدروس و من أدب مشايخنا الذين أطّرونا تأطيرًا لنكون منظمين في دراستنا. أنصح كل من يريد أن يدرس العلوم الشرعية عن بعد أن لا يسجل في هذه الأكاديمية المباركة، لكثرة المواد التي تدرس فيها وتنوعها و لأن المدرسين جيدون و مؤهلون للتدريس.',
                    ],
                    [
                        'name' => 'عبد الغني',
                        'date' => '02 ماي 2019',
                        'text' => 'جزى الله خيرا أستاذتنا و شيوخنا على جهدهم وعلمهم وحرصهم على تعليمنا و كنا الفائزين على هذه الأكاديمية بارك الله فيكم و سدد خطاكم و رزقنا و إياكم الجنة',
                    ],
                    [
                        'name' => 'خالد ل',
                        'date' => '05 دجنبر 2021',
                        'text' => 'كانت رحلة مأخوذة بالأدب، والعلم والمعرفة والتدرج في درجات الطلب. أكاديمية فضّلها عليّ أنا شخصيًا كثير جدا و قد أغنتني أستطيع سبحان الله بإذن الله ما استفدت ... وإني لأخصها بمشايخنا مسيرتها وضبطها بالدعاء وأفرد لذلك موطن الهيبة، عسى أن يُدخلني في قوله ﷺ: إن حسن العهد من الإيمان',
                    ]
                ] as $t)
                    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-6 text-white shadow-md">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-bold">{{ $t['name'] }}</h3>
                            <span class="text-sm text-gray-300">{{ $t['date'] }}</span>
      section           </div>
                        <div class="flex items-center mb-2 text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <p class="text-sm leading-relaxed text-gray-100">{{ $t['text'] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- العنوان والوصف -->
            <div class="text-center lg:text-right mt-10 lg:mt-0">
                <h4 class="text-sm font-light text-gray-300 mb-2">شهادات الطلاب</h4>
                <h2 class="text-4xl font-bold mb-6">ماذا قالوا عنا؟</h2>
                <p class="text-gray-200 leading-relaxed">
                    يتسجل الطالب في الأكاديمية في أول كل عام دراسي ثم يتابع دراسته لمدة أربع سنوات يتخرج فيها في التحصيل العلمي وفق برنامج علمي متكامل يشرف على تنسيقه مركز إرشاد للدراسات والتكوين.
                </p>
            </div>
        </div>
    </div>
    </section>

    <section class="relative bg-cover bg-center rounded-2xl mx-4 mt-6 overflow-hidden" style="background-image: url('images/University-of-al-Qarawiyyin.jpg');">
    <div class="bg-black bg-opacity-50 w-full h-full flex items-center justify-center text-center py-24 px-4">
        <div>
            <h1 class="text-white text-3xl sm:text-4xl md:text-5xl font-bold mb-6">
                ابدأ مسيرة طلب العلم<br>مع أكاديمية الإمام الباجي للعلوم الشرعية
            </h1>
            <a href="{{ route('student.register') }}" class="inline-block bg-white text-gray-800 font-semibold px-6 py-3 rounded-lg shadow hover:bg-gray-200 transition">
                التسجيل في الأكاديمية
            </a>
        </div>
    </div>
    </section>

        @yield('sections')

    </main>
@endsection
