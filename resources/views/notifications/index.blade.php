<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            الإشعارات
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">قائمة الإشعارات</h3>
                <div class="space-y-4">
                    @forelse (auth()->user()->notifications as $notification)
                        <div class="flex items-center justify-between p-4 bg-gray-100 rounded-lg shadow-md">
                            <div class="flex items-center">
                                @if (!$notification->read_at)
                                    <span class="text-green-500 font-semibold mr-2">جديد</span>
                                @endif
                                <p class="text-gray-700">{{ $notification->data['message'] }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <!-- زر عرض -->
                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </form>
                                <!-- زر حذف -->
                                <form action="{{ route('notifications.delete', $notification->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-700">لا توجد إشعارات متاحة.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
