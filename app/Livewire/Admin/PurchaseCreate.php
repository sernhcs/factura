<?php

namespace App\Livewire\Admin;

use App\Models\Purchase;
use Livewire\Component;

class PurchaseCreate extends Component
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

    public function boot()
    {
        $this->withValidator(function ($validator) {
           
                if ($validator->fails()) {
                    $errors = $validator->errors()->toArray();
                    $html="<ul class='text-left'>";
                    foreach ($errors as $error) {
                        $html.="<li> {$error[0]}</li>";
                    }
                    $html.="</ul>";
                    $this->dispatch('swal',[
                        'icon' => 'error',
                        'title' => 'Error de validación',
                        'html' => $html,
                    ]);
                }
        });
        
    }
    public function mount()
    {
        $this->correlative = Purchase::max('correlative')+1 ;
    }   
    public function save()
    {
        $this->validate([
            'voucher_type' => 'required|in:1,2',
            'date' => 'nullable|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'total'=>'required|numeric|min:0',
            'observation' => 'nullable|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',   
            'products.*.price' => 'required|numeric|min:0',
        ],[],[
            'voucher_type' => 'Tipo de comprobante',
            'date' => 'Fecha',
            'supplier_id' => 'Proveedor',
            'total' => 'Total',
            'observation' => 'Observación',
            'products' => 'Productos',
            'products.*.id' => 'Producto',
            'products.*.quantity' => 'Cantidad',
            'products.*.price' => 'Precio',
        ]);

        // Crear la orden de compra
        $purchaseOrder = Purchase::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date??now(),
            'supplier_id' => $this->supplier_id,
            'total' => $this->total,
            'observation' => $this->observation,
        ]);

        // Asociar los productos a la orden de compra
        foreach ($this->products as $product) {
            $purchaseOrder->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);
        }


        // Redirigir o mostrar un mensaje de éxito
        session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Éxito',
            'text' => 'Orden de compra creada exitosamente.'
        ]);
        return redirect()->route('admin.purchase.index');
    }

    public function render()
    {
        
        return view('livewire.admin.purchase-create');
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
