<div class="h-full w-full flex-1">
    <flux:button class="mb-4" :href="route('signature.create')" wire:navigate>
        Create
    </flux:button>

    @if (session('success'))
        <flux:callout icon="check" variant="success" inline x-data="{ visible: true }" x-show="visible" class="mb-4">
            <flux:callout.heading class="flex gap-2 @max-md:flex-col items-start">
                {{ session('success') }}
            </flux:callout.heading>
            <x-slot name="controls">
                <flux:button icon="x-mark" variant="ghost" x-on:click="visible = false" />
            </x-slot>
        </flux:callout>
    @endif

    <livewire:signature-table />

    <flux:modal wire:model="showQrModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">QR Code</flux:heading>
                <flux:text class="mt-2">Tempelkan QR Code berikut pada dokumen.</flux:text>
            </div>
            <img src="{{ $qrCodeDataUri }}" class="w-64 h-64 mx-auto" />
            <p class="text-center mb-4">
                <b>{{ $selectedSignature?->nomor_dokumen }}</b>
                <br>
                {{ $selectedSignature?->nama_penandatangan }}
                <br>
                {{ \Carbon\Carbon::parse($selectedSignature?->tanggal)->translatedFormat('d F Y') }}
                <br>
                @if ($selectedSignature?->status == 'valid')
                    <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Valid
                    </span>
                @else
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Invalid
                    </span>
                @endif
            </p>
            <div class="text-center">
                <flux:button icon="arrow-down-tray" variant="primary" wire:click="downloadQr">
                    Download
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
