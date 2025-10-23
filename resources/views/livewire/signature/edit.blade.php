<div class="h-full w-full flex-1">
    <flux:button wire:navigate :href="route('signature.index')" size="sm" class="mb-4">
        Back
    </flux:button>

    <form wire:submit="update" class="w-full max-w-lg">
        <div class="mb-4">
            <flux:input wire:model="nama_penandatangan" type="text" label="Nama Penandatangan" />
        </div>
        <div class="mb-4">
            <flux:input wire:model="nomor_dokumen" type="text" label="Nomor Dokumen" />
        </div>
        <div class="mb-4">
            <flux:input wire:model="tanggal" type="date" label="Tanggal Surat" max="2999-12-31" />
        </div>
        <div class="mb-4">
            <flux:input wire:model="keterangan" type="text" label="Keterangan" />
        </div>
        <div class="mb-4">
            <flux:select label="Status" wire:model="status">
                <flux:select.option value="">-- Pilih Status --</flux:select.option>
                <flux:select.option value="valid">Valid</flux:select.option>
                <flux:select.option value="invalid">Invalid</flux:select.option>
            </flux:select>
        </div>
        <flux:button type="submit" variant="primary">Submit</flux:button>
    </form>

</div>
