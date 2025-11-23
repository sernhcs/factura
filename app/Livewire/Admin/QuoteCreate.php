<?php

namespace App\Livewire\Admin;

use App\Models\Quote;
use App\Models\Product;
use Livewire\Component;

class QuoteCreate extends Component
{
    public $voucher_type=1;
    public $serie='C01';
    public $correlative;
    public $date;
    public $customer_id;
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
        $this->correlative = Quote::max('correlative')+1 ;
    }   
    public function save()
    {
        $this->validate([
            'voucher_type' => 'required|in:1,2',
            'date' => 'nullable|date',
            'customer_id' => 'required|exists:customers,id',
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
        $quote = Quote::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date??now(),
            'customer_id' => $this->customer_id,
            'total' => $this->total,
            'observation' => $this->observation,
        ]);

        // Asociar los productos a la orden de compra
        foreach ($this->products as $product) {
            $quote->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);
        }


        // Redirigir o mostrar un mensaje de éxito
        session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Éxito',
            'text' => 'Cotizacion creada exitosamente.'
        ]);
        return redirect()->route('admin.quotes.index');
    }

    public function render()
    {
        
        return view('livewire.admin.quote-create');
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

        $product = Product::find($this->product_id);
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
