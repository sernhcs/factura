<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;

class ProductTable extends DataTableComponent
{
    protected $model = Product::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable(),
            Column::make("Description", "description")
                ->sortable(),
            Column::make("Sku", "sku")
                ->sortable(),
            Column::make("Barcode", "barcode")
                ->sortable(),
            Column::make("Price", "price")
                ->sortable(),
            Column::make("Category id", "category_id")
                ->sortable(),
            Column::make("Observation", "observation")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
