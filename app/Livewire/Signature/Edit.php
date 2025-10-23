<?php

namespace App\Livewire\Signature;

use App\Models\Signature;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Edit extends Component
{
    public $signature_id;

    // nama penandatangan
    #[Rule('required', message: 'Nama penandatangan wajib diisi')]
    public $nama_penandatangan;

    // nomor dokumen
    #[Rule('required', message: 'Nomor dokumen wajib diisi')]
    public $nomor_dokumen;

    // tanggal
    #[Rule('required', message: 'Tanggal dokumen wajib diisi')]
    public $tanggal;

    // keterangan
    #[Rule('required', message: 'Keterangan wajib diisi')]
    public $keterangan;

    // status
    #[Rule('required', message: 'Status wajib diisi')]
    public $status;

    public function mount($id)
    {
        $signature = Signature::find($id);

        $this->signature_id = $signature->id;
        $this->nama_penandatangan = $signature->nama_penandatangan;
        $this->nomor_dokumen = $signature->nomor_dokumen;
        $this->tanggal = $signature->tanggal;
        $this->keterangan = $signature->keterangan;
        $this->status = $signature->status;
    }

    public function update()
    {
        $this->validate();

        $signature = Signature::find($this->signature_id);
        $signature->nama_penandatangan = $this->nama_penandatangan;
        $signature->nomor_dokumen = $this->nomor_dokumen;
        $signature->tanggal = $this->tanggal;
        $signature->keterangan = $this->keterangan;
        $signature->status = $this->status;
        $signature->save();

        session()->flash('success', 'Signature successfully updated.');

        $this->redirectRoute('signature.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.signature.edit');
    }
}
