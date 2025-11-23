<x-admin-layout 

title="Ventas"

:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Ventas',
    ],
]">
    <x-slot name="action" blue>
        <x-wire-button href="{{ route('admin.sales.create') }}" blue >
            Nuevo
        </x-wire-button>
    </x-slot>
    @livewire('admin.datatables.sale-table')

 

</x-admin-layout>