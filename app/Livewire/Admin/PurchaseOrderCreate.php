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
    public function addProduct()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
        ],[],[
            'product_id' => 'Producto',
        ]);


        $existing = collect($this->products)->firstWhere('id', $this->product_id);
        if ($existing) {
           $this->dispatch('swal',[
                'icon' => 'warning',
                'title' => 'Producto ya agregado',
                'text' => 'El producto que intenta agregar ya se encuentra en la lista.',
            ]);
            return;
        }

        $product = \App\Models\Product::find($this->product_id);
        $this->products[] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' => 0,
            'subtotal' => 0,
        ];
        $this->reset('product_id');
    }
}
