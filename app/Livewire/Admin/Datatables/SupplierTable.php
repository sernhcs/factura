<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder;

class SupplierTable extends DataTableComponent
{

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
            Column::make("Tipo DOC", "identity.name")
                ->sortable(),
            Column::make("Num DOC", "document_number")
                            
                ->searchable()
 
                ->sortable(),
            Column::make("Razón Social", "name")

                ->searchable()
                ->sortable(),
            Column::make("correo", "email")
                ->sortable(),
            Column::make("telefono", "phone")
                ->sortable(),
                   
            Column::make("Acciones", "description")
                ->label(function($row){
                    return view('admin.suppliers.actions',['supplier'=>$row]);
                }),
        ];
    }


    public function builder():Builder
    {
        return supplier::query()
            ->with(['identity']);
    }
}
