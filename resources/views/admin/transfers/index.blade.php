<x-admin-layout 

title="Transferencias"

:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Transferencias',
    ],
]">
    <x-slot name="action" blue>
        <x-wire-button href="{{ route('admin.transfers.create') }}" blue >
            Nuevo
        </x-wire-button>
    </x-slot>
    @livewire('admin.datatables.transfer-table')

 

</x-admin-layout>