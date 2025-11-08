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
        <x-wire-button href="{{ route('admin.purchases.create') }}" blue >
            Nuevo
        </x-wire-button>
    </x-slot>
    @livewire('admin.datatables.purchase-table')

 

</x-admin-layout>