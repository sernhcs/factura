<div>
    <div class="grid grid-cols-4 gap-4">
    <x-wire-native-select class="col-span-1" label="Tipo de Comprobante" wire:model="voucher_type">
        <option value="1">Factura</option>
        <option value="2">Boleta</option>
    </x-wire-native-select>

    <x-wire-input class="col-span-1" disabled label="Serie" wire:model="serie" />
    <x-wire-input disabled class="col-span-1" label="Correlativo" wire:model="correlative" />
    <x-wire-input type="date" class="col-span-1" label="Fecha de emisión" wire:model="date" />


</div>
<div class="grid grid-cols-4 gap-4 mt-4">
  
    <x-wire-select
        label="Proveedor"
        wire:model="supplier_id"
        :async-data="[
            'api' => route('api.suppliers.index'),
            'method' => 'POST',
        ]"
        class="col-span-4"
        option-label="name"
        option-value="id"
        placeholder="Seleccione un proveedor"
    />


</div>

</div>