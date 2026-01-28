<?php

namespace App\Livewire\Signature;

use App\Models\Signature;
use Livewire\Component;

class Show extends Component
{
    public $signature;

    public function mount($id)
    {
        $this->signature = Signature::find($id);

        if ($this->signature === null) {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.signature.show');
    }
}
