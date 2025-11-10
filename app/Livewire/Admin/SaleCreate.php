<?php

namespace App\Livewire\Admin;

use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\Quote;
use App\Models\Sale;
use Livewire\Component;

class SaleCreate extends Component
{
    public $voucher_type=1;
    public $serie ="FOO1";
    public $correlative;
    public $date;

    public $quote_id;
    
    public $customer_id;
    
    public $warehouse_id;

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

    public function mount(){

        $this->correlative = Sale::max('correlative') + 1; // Asignar el siguiente correlativo
    }

    public function updated($property, $value)
    {
        if($property =='quote_id'){
            $quote = Quote::find($value);
            if($quote){

                $this->voucher_type = $quote->voucher_type;
                $this->customer_id = $quote->customer_id;   


                $this->products = $quote->products->map(function($product){
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'quantity' => $product->pivot->quantity,
                        'price' => $product->pivot->price,
                        'subtotal' => $product->pivot->subtotal,
                    ];
                })->toArray();
            }

        }
    }


    public function save()
    {
        $this->validate([
            'voucher_type' => 'required|in:1,2',
            'serie' => 'required|string|max:10',
            'correlative' => 'required|numeric|min:1',
            'date' => 'nullable|date',
            'quote_id' => 'nullable|exists:quotes,id',
            'customer_id' => 'required|exists:customers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'total'=>'required|numeric|min:0',
            'observation' => 'nullable|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',   
            'products.*.price' => 'required|numeric|min:0',
        ],[],[
            'voucher_type' => 'Tipo de comprobante',
            'date' => 'Fecha',
            'customer_id' => 'Cliente',
            'total' => 'Total',
            'observation' => 'Observación',
            'products' => 'Productos',
            'products.*.id' => 'Producto',
            'products.*.quantity' => 'Cantidad',
            'products.*.price' => 'Precio',
        ]);

        // Crear la orden de compra
        $sale = Sale::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date??now(),
            'customer_id' => $this->customer_id,
            'warehouse_id' => $this->warehouse_id,
            'quote_id' => $this->quote_id,
            'total' => $this->total,
            'observation' => $this->observation,
        ]);

        // Asociar los productos a la orden de compra
        foreach ($this->products as $product) {
            $sale->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);
        }


        // Redirigir o mostrar un mensaje de éxito
        session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Éxito',
            'text' => 'La venta se ha creado exitosamente.'
        ]);
        return redirect()->route('admin.sales.index');
    }

    public function render()
    {
        
        return view('livewire.admin.sale-create');
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
            'price' => $product->price,
            'subtotal' => $product->price,
        ];
        $this->reset('product_id');
    }

}
