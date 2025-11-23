<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;

class ProductTable extends DataTableComponent
{
    // protected $model = Product::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
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

}
