<x-admin-layout 

title="Compras"

:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Compras',
    ],
]">
    <x-slot name="action" blue>
        <x-wire-button href="{{ route('admin.purchases.create') }}" blue >
            Nuevo
        </x-wire-button>
    </x-slot>
    @livewire('admin.datatables.purchase-table')

 

</x-admin-layout>