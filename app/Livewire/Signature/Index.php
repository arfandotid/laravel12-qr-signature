<?php

namespace App\Livewire\Signature;

use App\Models\Signature;
use Livewire\Component;
use Livewire\WithPagination;


use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $showQrModal = false;
    public $qrCodeDataUri = null;
    public $selectedSignature;

    public function destroy($id)
    {
        //destroy
        $signature = Signature::find($id);

        if ($signature) {
            $signature->delete();
        }

        //flash message
        session()->flash('success', 'Data Berhasil Dihapus.');

        //redirect
        $this->redirectRoute('signature.index', navigate: true);
    }

    public function qrcode($id)
    {
        $signature = Signature::find($id);

        if (!$signature) {
            return;
        }

        $content = route('signature.show', ['id' => $signature->id]);

        $builder = new Builder(
            writer: new PngWriter(),
            data: $content,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
        );

        $result = $builder->build();

        $this->qrCodeDataUri = $result->getDataUri();
        $this->selectedSignature = $signature;
        $this->showQrModal = true;
    }

    public function downloadQr()
    {
        if (!$this->selectedSignature || !$this->qrCodeDataUri) {
            session()->flash('error', 'QR code belum dibuat.');
            return;
        }

        // Ambil base64 dari Data URI
        $base64Data = explode(',', $this->qrCodeDataUri)[1] ?? null;

        if (!$base64Data) {
            session()->flash('error', 'Data QR tidak valid.');
            return;
        }

        // Decode base64 ke binary
        $pngData = base64_decode($base64Data);

        $filename = 'qr-' . $this->selectedSignature->id . '.png';

        return response()->streamDownload(function () use ($pngData) {
            echo $pngData;
        }, $filename, [
            'Content-Type' => 'image/png',
        ]);
    }

    public function render()
    {
        $signatures = Signature::latest()->paginate(10);
        if ($this->search) {
            $signatures = Signature::where('nama_penandatangan', 'like', '%' . $this->search . '%')
                ->orWhere('nomor_dokumen', 'like', '%' . $this->search . '%')
                ->orWhere('tanggal', 'like', '%' . $this->search . '%')
                ->orWhere('keterangan', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10);
        }

        return view('livewire.signature.index', [
            'signatures' => $signatures,
        ]);
    }
}
