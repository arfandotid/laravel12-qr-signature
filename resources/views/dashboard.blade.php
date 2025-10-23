<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:callout>
            <flux:callout.heading icon="user">Welcome, {{ auth()->user()->name }}</flux:callout.heading>

            <flux:callout.text>
                You are logged in!
            </flux:callout.text>
        </flux:callout>
    </div>
</x-layouts.app>
