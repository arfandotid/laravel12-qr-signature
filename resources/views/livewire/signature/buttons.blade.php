<flux:button target="_blank" :href="route('signature.show', $row->id)" size="xs">
    <flux:icon.arrow-top-right-on-square class="w-4 h-4" />
</flux:button>
<flux:button wire:click="$dispatch('open-qr', { id: '{{ $row->id }}' })" variant="filled" size="xs">
    <flux:icon.qr-code class="w-4 h-4" />
</flux:button>
<flux:button wire:navigate :href="route('signature.edit', $row->id)" size="xs" variant="primary" color="yellow">
    <flux:icon.pencil class="w-4 h-4" />
</flux:button>
<flux:button wire:click="$dispatch('confirm-delete', { id: '{{ $row->id }}' })" wire:confirm="Are you sure?"
    size="xs" variant="danger">
    <flux:icon.trash class="w-4 h-4" />
</flux:button>
