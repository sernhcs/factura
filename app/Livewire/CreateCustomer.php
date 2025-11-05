<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Identity;

class CreateCustomer extends Component
{
    public $identity_id = '';
    public $identities;

    public function mount()
    {
        $this->identities = Identity::all();
    }

    public function render()
    {
        return view('livewire.create-customer');
    }
}
