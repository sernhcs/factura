<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;

class CustomerTable extends DataTableComponent
{
    // protected $model = Customer::class;

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
                    return view('admin.customers.actions',['customer'=>$row]);
                }),
        ];
    }


    public function builder():Builder
    {
        return Customer::query()
            ->with(['identity']);
    }
}
