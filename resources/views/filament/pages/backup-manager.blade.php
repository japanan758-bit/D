<x-filament-panels::page>
    <div class="grid gap-6">
        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold">حالة النظام</h2>
                <x-filament::button wire:click="createBackup" color="success">
                    إنشاء نسخة احتياطية جديدة
                </x-filament::button>
            </div>

            <p class="text-gray-600 dark:text-gray-400">
                يمكنك من هنا إدارة النسخ الاحتياطية للنظام وقاعدة البيانات.
            </p>

            <!-- List of backups would go here -->
            <div class="mt-6">
                @if(count($backups) > 0)
                    <ul>
                        @foreach($backups as $backup)
                            <li>{{ $backup }}</li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-8 text-gray-500">
                        لا توجد نسخ احتياطية متاحة حالياً.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>
