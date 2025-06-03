<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            لوحة تحكم الأستاذ
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg rounded-lg p-6 mb-6">
                <h3 class="text-2xl font-bold">مرحباً أستاذ {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
                <p class="mt-2">تتبع أداءك وإدارة الدورات والدروس بسهولة!</p>
            </div>

            <!-- إحصائيات رئيسية -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- عدد الدورات -->
                <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <h4 class="text-lg font-semibold text-gray-700">عدد الدورات</h4>
                    <p class="text-3xl font-bold text-indigo-600">{{ \App\Models\Subject::where('teacher_id', Auth::id())->count() }}</p>
                </div>

                <!-- عدد الدروس -->
                <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <h4 class="text-lg font-semibold text-gray-700">عدد الدروس</h4>
                    <p class="text-3xl font-bold text-purple-600">{{ \App\Models\Lesson::whereHas('subject', function ($query) {
                        $query->where('teacher_id', Auth::id());
                    })->count() }}</p>
                </div>

                <!-- عدد التعليقات -->
                <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <h4 class="text-lg font-semibold text-gray-700">عدد التعليقات</h4>
                    <p class="text-3xl font-bold text-green-600">{{ \App\Models\Comment::whereHas('lesson.subject', function ($query) {
                        $query->where('teacher_id', Auth::id());
                    })->count() }}</p>
                </div>

                <!-- عدد التقييمات -->
                <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <h4 class="text-lg font-semibold text-gray-700">عدد التقييمات</h4>
                    <p class="text-3xl font-bold text-yellow-600">{{ \App\Models\Evaluation::whereHas('lesson.subject', function ($query) {
                        $query->where('teacher_id', Auth::id());
                    })->count() }}</p>
                </div>
            </div>

            <!-- الرسوم البيانية -->
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <h4 class="text-xl font-semibold text-gray-800 mb-4">إحصائيات الدروس والتقييمات</h4>
                <canvas id="chartCanvas" class="w-full h-64"></canvas>
                <script>
                    const ctx = document.getElementById('chartCanvas').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['دروس', 'تعليقات', 'تقييمات'],
                            datasets: [{
                                label: 'العدد',
                                data: [
                                    {{ \App\Models\Lesson::whereHas('subject', function ($query) {
                                        $query->where('teacher_id', Auth::id());
                                    })->count() }},
                                    {{ \App\Models\Comment::whereHas('lesson.subject', function ($query) {
                                        $query->where('teacher_id', Auth::id());
                                    })->count() }},
                                    {{ \App\Models\Evaluation::whereHas('lesson.subject', function ($query) {
                                        $query->where('teacher_id', Auth::id());
                                    })->count() }}
                                ],
                                backgroundColor: ['#4B5EAA', '#38A169', '#D69E2E'],
                                borderColor: ['#4B5EAA', '#38A169', '#D69E2E'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: { position: 'top' },
                                title: { display: true, text: 'إحصائيات الأداء' }
                            }
                        }
                    });
                </script>
            </div>

            <!-- أحدث الدروس -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h4 class="text-xl font-semibold text-gray-800 mb-4">أحدث الدروس</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach (\App\Models\Lesson::whereHas('subject', function ($query) {
                        $query->where('teacher_id', Auth::id());
                    })->latest()->take(4)->get() as $lesson)
                        <div class="bg-gray-50 p-4 rounded-lg flex items-center justify-between">
                            <div>
                                <h5 class="text-md font-medium">{{ $lesson->title }}</h5>
                                <p class="text-sm text-gray-600">{{ $lesson->created_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('teacher.lessons.show', ['subject' => $lesson->subject_id, 'lesson' => $lesson->id]) }}" class="text-indigo-600 hover:text-indigo-800">عرض</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
