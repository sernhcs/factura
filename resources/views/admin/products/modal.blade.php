
<x-wire-modal-card title="Stock por almacèn" wire:model="openModal" >

    <ul class='space-y-3'>
        @forelse ($inventories as $inventory )
            <li class="felx items-center justify-between p-4 bg-gray-100 rounded-lg shadow-sm">
        <div>
            <p class= "text-sm text-gray-600">
        @empty
        @endforelse
    </ul>

</x-wire-modal-card>
<x-wire-modal-card title="Stock por almacén" wire:model="openModal">

    <ul class="space-y-3">
        @forelse ($inventories as $inventory)
            <li class="flex items-center justify-between p-4 bg-gray-100 rounded-lg shadow-sm">
                <div>
                    <p class="text-sm text-gray-600">
                        <strong>Almacén:</strong> {{ $inventory->warehouse->name ?? 'Sin nombre' }}
                    </p>
                    <p class="font-medium text-gray-600">
                        <strong>Ubicaciòn:</strong> {{ $inventory->warehouse->location }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <strong>Fecha:</strong> {{ $inventory->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">
                        Stock disponible:
                    </p>
                    <p class="text-sm {{ $inventory->quantity_balance > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $inventory->quantity_balance }}
                    </p>
                </div>
            </li>
        @empty
            <li class="p-4 bg-gray-100 rounded-lg text-center text-gray-500">
                No hay productos registrados.
            </li>
        @endforelse
    </ul>

</x-wire-modal-card>
