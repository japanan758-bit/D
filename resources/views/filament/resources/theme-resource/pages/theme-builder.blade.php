<x-filament-panels::page>
    <div class="w-full h-[calc(100vh-12rem)] border rounded-lg overflow-hidden">
        <iframe
            src="{{ route('theme-builder.index') }}?theme_id={{ $theme->id }}"
            class="w-full h-full border-0"
            title="Theme Builder"
        ></iframe>
    </div>
</x-filament-panels::page>
