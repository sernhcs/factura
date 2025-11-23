<?php

namespace App\Livewire\Admin;

use App\Models\Movement;
use App\Models\Quote;
use App\Models\Product;
use App\Models\Transfer;
use App\Facades\Kardex;
use Livewire\Component;

class TransferCreate extends Component
{
    public $serie='T001';
    public $correlative;
    public $date;
    public $origin_warehouse_id;
    public $destination_warehouse_id;
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
        $this->correlative = Transfer::max('correlative')+1 ;
    }

    public function updated($property,$value){
        if($property=='origin_warehouse_id'){
            $this->reset('destination_warehouse_id');
        }
    }

    public function save()
    {
        $this->validate([
            'serie' => 'required|string|max:10',
            'correlative' => 'required|numeric|min:1',
            'date' => 'nullable|date',
            'origin_warehouse_id' => 'required|exists:warehouses,id',
            // destino diferente al origen
            'destination_warehouse_id' => 'required|different:origin_warehouse_id|exists:warehouses,id',
            'total'=>'required|numeric|min:0',
            'observation' => 'nullable|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ],[],[
            'date' => 'Fecha',
            'origin_warehouse_id' => 'Almacén origen',
            'destination_warehouse_id' => 'Almacén destino',
            'total' => 'Total',
            'observation' => 'Observación',
            'products' => 'Productos',
            'products.*.id' => 'Producto',
            'products.*.quantity' => 'Cantidad',
            'products.*.price' => 'Precio',
        ]);

        // Crear la orden de compra
        $transfer = Transfer::create([
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date??now(),
            'origin_warehouse_id' => $this->origin_warehouse_id,
            'destination_warehouse_id' => $this->destination_warehouse_id,
            'total' => $this->total,
            'observation' => $this->observation,
        ]);

        // Asociar los productos a la orden de compra
        foreach ($this->products as $product) {
            $transfer->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);

            Kardex::registerExit(
                $transfer,
                $product,
                $this->origin_warehouse_id,
                "Transferencia salida"
            );
            Kardex::registerEntry(
                $transfer,
                $product,
                $this->destination_warehouse_id,
                "Transferencia entrada"
            );
        }


        // Redirigir o mostrar un mensaje de éxito
        session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Éxito',
            'text' => 'Transferencia se ha creado exitosamente.'
        ]);
        return redirect()->route('admin.transfers.index');
    }

    public function render()
    {

        return view('livewire.admin.transfer-create');
    }
    public function addProduct()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'origin_warehouse_id'=> 'required|exists:warehouses,id',
        ],[],[
            'product_id' => 'Producto',
            'origin_warehouse_id' => 'almacen origen',

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

        $lastRecord = Kardex::getLastRecord(
            $product->id,
            $this->origin_warehouse_id
        );


        $this->products[] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' => $lastRecord['cost'],
            'subtotal' => $lastRecord['cost'],
        ];
        $this->reset('product_id');
    }

}
