<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Builder;

class PurchaseTable extends DataTableComponent
{

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
        $this->setAdditionalSelects(['purchases.id']);    
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
                        
            Column::make("Fecha", "date")
                ->sortable()
                ->format(fn($value)=>$value?->format('d/m/Y')),
            
            Column::make("Serie", "serie")
                ->sortable(),

            Column::make("Correlativo", "correlative")
                ->sortable(),
            
            Column::make("Document", "supplier.document_number")
                ->sortable(),

            Column::make("Razon social", "supplier.name")
                ->sortable(),

            Column::make("Total", "total")
                ->sortable()
                ->format(fn($value)=>'S/'.number_format($value,2,'.',',')),
            
            Column::make('Acciones')
                ->label(function($row) {
                    return view('admin.purchases.actions',
                        ['purchase' => $row]);
                }),
        ];
        
    }
    

    public function builder():Builder
    {
        return Purchase::query()
            ->with(['supplier']);
    }

}
