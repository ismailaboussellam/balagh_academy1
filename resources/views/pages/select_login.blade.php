<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-6xl">
            <h2 class="text-4xl font-extrabold text-gray-800 mb-3 text-center">Log in to Balagh Academy</h2>
            <p class="text-gray-600 mb-10 text-center text-lg">Welcome back! Are you a Student, teacher, or admin?</p>
            <!-- Flex direction adjusts to column on larger screens -->
            <div class="flex flex-col lg:flex-row justify-center items-stretch gap-6">
                <!-- Member -->
                <div class="w-full bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300">
                    <div class="h-48 bg-blue-50 flex items-center justify-center p-4">
                        <img src="{{ asset('images/student.png') }}" alt="Member" class="h-32 w-auto">
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-2xl font-bold text-blue-600">Student</h3>
                        <p class="text-sm text-gray-600 mt-2 mb-5">Log in to access club services and activities</p>
                        <a href="{{ route('student_login' , ['type' => 'student'] )}}" class="block w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-200 font-medium">
                            Continue as Student
                        </a>
                    </div>
                </div>
                <!-- Admin -->
                <div class="w-full bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300">
                    <div class="h-48 bg-red-50 flex items-center justify-center p-4">
                        <img src="{{ asset('images/admin.png') }}" alt="Admin" class="h-32 w-auto">
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-2xl font-bold text-red-600">System Admin</h3>
                        <p class="text-sm text-gray-600 mt-2 mb-5">Log in to control all club settings and operations</p>
                        <a href="{{ route('admin_login' , ['type' => 'admin'] ) }}" class="block w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700 transition duration-200 font-medium">
                            Continue as Admin
                        </a>
                    </div>
                </div>
                <!-- Staff -->
                <div class="w-full bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300">
                    <div class="h-48 bg-green-50 flex items-center justify-center p-4">
                        <img src="{{ asset('images/teacher.png') }}" alt="Staff" class="h-32 w-auto">
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-2xl font-bold text-green-600">Club Staff</h3>
                        <p class="text-sm text-gray-600 mt-2 mb-5">Log in to manage daily tasks and activities</p>
                        <a href="{{ route('teacher_login' , ['type' => 'teacher']) }}" class="block w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 transition duration-200 font-medium">
                            Continue as teacher
                        </a>
                    </div>
                </div>
            </div>
            <p class="mt-10 text-center text-gray-600 text-sm">
                No account yet?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">Register</a>
            </p>
        </div>
    </div>
</x-guest-layout>