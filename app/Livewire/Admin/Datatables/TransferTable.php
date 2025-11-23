<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Movement;
use App\Models\Transfer;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;

class TransferTable extends DataTableComponent
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
                        
            Column::make("Fecha", "date")
                ->sortable()
                ->format(fn($value)=>$value?->format('d/m/Y')),
                        
            Column::make("Serie", "serie")
                ->sortable(),

            Column::make("Correlativo", "correlative")
                ->sortable(),
            
            Column::make("Almacén de Origen", "originWarehouse.name")
                ->sortable(),

            Column::make("Almacén de Destino", "destinationWarehouse.name")
                ->sortable(),

            Column::make("Total", "total")
                ->sortable()
                ->format(fn($value)=>'S/'.number_format($value,2,'.',',')),
            
            Column::make('Acciones')
                ->label(function($row) {
                    return view('admin.transfers.actions',
                        ['transfer' => $row]);
                }),
        ];
        
    }
    

    public function builder():Builder
    {
        return Transfer::query()
            ->with(['originWarehouse','destinationWarehouse']);
    }

}
