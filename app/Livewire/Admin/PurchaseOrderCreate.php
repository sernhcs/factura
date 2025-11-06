<?php

namespace App\Livewire\Admin;

use App\Models\PurchaseOrder;
use Livewire\Component;

class PurchaseOrderCreate extends Component
{
    public $voucher_type=1;
    public $serie='OC01';
    public $correlative;
    public $date;
    public $supplier_id;
    public $total = 0;
    public $observation;

    public $product_id;
    public $products = [];

    public function mount()
    {
        $this->correlative = PurchaseOrder::max('correlative')+1 ;
    }   
    public function save()
    {}

    public function render()
    {
        
        return view('livewire.admin.purchase-order-create');
    }
}
