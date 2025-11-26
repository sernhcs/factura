<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;

class ProductTable extends DataTableComponent
{
    // protected $model = Product::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
        $this->setConfigurableAreas([
            'after-wrapper'=>[
                'admin.products.modal'
            ]
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            ImageColumn::make("Imagen")
                ->location(fn($row) => $row->image)
                ->attributes(function($row){
                    return [
                        'class' => '',
                        'style' => 'width:50px; height:50px; object-fit:cover; border-radius:30%;',
                    ];
                }),

            Column::make("Nombre", "name")
                ->searchable()
                ->sortable(),
            Column::make("Categoría", "category.name")
                ->searchable()
                ->sortable(),
            Column::make("Precio", "price")
                ->sortable(),
            Column::make("Stock", "stock")
                ->sortable()
                ->format(function($val,$row){
                    return view('admin.products.stock',[
                        'stock'=>$val,

                        'product'=>$row

                    ]);
                }),
            Column::make("Acciones", "description")
                ->label(function($row){
                    return view('admin.products.actions',['product'=>$row]);
                }),
        ];
    }


    public function builder():Builder
    {
        return Product::query()
            ->with(['category','images']);
    }

    public $openModal= false;

    public $inventories =[];

    public function showStock($productId){
        $this->openModal = true;
        $latestInventories = Inventory::where('product_id',$productId)
            ->select('warehouse_id', DB::raw('MAX(id) as id'))
            ->groupBy('warehouse_id')
            ->get();

    $ids = $latestInventories->pluck('id')->toArray();


    $this->inventories = Inventory::whereIn('id', $ids)
        ->with('warehouse')
        ->get();

    }
}
