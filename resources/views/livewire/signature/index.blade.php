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

    <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Cari data ..." class="mb-4" />

    <div class="overflow-x-auto mb-4">
        <table class="border-collapse min-w-full table-auto">
            <thead>
                <tr>
                    <th class="border dark:border-zinc-500 px-2 py-1">No</th>
                    <th class="border dark:border-zinc-500 px-2 py-1">Nama</th>
                    <th class="border dark:border-zinc-500 px-2 py-1">Nomor Dokumen</th>
                    <th class="border dark:border-zinc-500 px-2 py-1">Tanggal</th>
                    <th class="border dark:border-zinc-500 px-2 py-1">Keterangan</th>
                    <th class="border dark:border-zinc-500 px-2 py-1">Status</th>
                    <th class="border dark:border-zinc-500 px-2 py-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($signatures as $signature)
                    <tr>
                        <td class="border dark:border-zinc-500 px-2 py-1">
                            {{ $loop->iteration + $signatures->firstItem() - 1 }}
                        </td>
                        <td class="border dark:border-zinc-500 px-2 py-1">
                            {{ $signature->nama_penandatangan }}
                        </td>
                        <td class="border dark:border-zinc-500 px-2 py-1">
                            {{ $signature->nomor_dokumen }}
                        </td>
                        <td class="border dark:border-zinc-500 px-2 py-1">
                            {{ \Carbon\Carbon::parse($signature->tanggal)->translatedFormat('d F Y') }}
                        </td>
                        <td class="border dark:border-zinc-500 px-2 py-1">
                            {{ $signature->keterangan }}
                        </td>
                        <td class="border dark:border-zinc-500 px-2 py-1">
                            @if ($signature->status == 'valid')
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Valid
                                </span>
                            @else
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Invalid
                                </span>
                            @endif
                        </td>
                        <td class="border dark:border-zinc-500 px-2 py-1">
                            <flux:button target="_blank" :href="route('signature.show', $signature->id)" size="xs">
                                <flux:icon.arrow-top-right-on-square class="w-4 h-4" />
                            </flux:button>
                            <flux:button wire:click="qrcode('{{ $signature->id }}')" variant="filled" size="xs">
                                <flux:icon.qr-code class="w-4 h-4" />
                            </flux:button>
                            <flux:button wire:navigate :href="route('signature.edit', $signature->id)" size="xs"
                                variant="primary" color="yellow">
                                <flux:icon.pencil class="w-4 h-4" />
                            </flux:button>
                            <flux:button wire:click="destroy('{{ $signature->id }}')" wire:confirm="Are you sure?"
                                size="xs" variant="danger">
                                <flux:icon.trash class="w-4 h-4" />
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="border dark:border-zinc-500 px-2 py-1 text-center">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $signatures->links() }}

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
