<div>
    <div class="grid grid-cols-4 gap-4">
        <x-wire-native-select 
            class="col-span-1" 
            label="Tipo de Comprobante" 
            wire:model="voucher_type"
        >
            <option value="1">Factura</option>
            <option value="2">Boleta</option>
        </x-wire-native-select>

        <x-wire-input 
            class="col-span-1" 
            disabled 
            label="Serie" 
            wire:model="serie" 
        />

        <x-wire-input 
            class="col-span-1" 
            disabled 
            label="Correlativo" 
            wire:model="correlative" 
        />

        <x-wire-input 
            type="date" 
            class="col-span-1" 
            label="Fecha de emisión" 
            wire:model="date" 
        />
    </div>

    <div class="grid grid-cols-3 gap-4 mt-4">
        <x-wire-select
            label="Proveedor"
            wire:model="supplier_id"
            :async-data="[
                'api' => route('api.suppliers.index'),
                'method' => 'POST',
            ]"
            option-label="name"
            option-value="id"
            placeholder="Seleccione un proveedor"
            class="col-span-1"
        />
         <x-wire-select
            label="Producto"
            wire:model="product_id"
            :async-data="[
                'api' => route('api.products.index'),
                'method' => 'POST',
            ]"
            option-label="name"
            option-value="id"
            placeholder="Seleccione un producto"
            class="col-span-1"
        />
        <div class="col-span-1 flex-shrink-0 flex items-end justify-center">
            <x-wire-button wire:click="addProduct" class="w-full">
                Agregar Producto
            </x-wire-button>
        </div>

        {{-- <div class="col-span-1">
            <x-wire-input 
                label="RUC" 
                wire:model="supplier_ruc" 
                disabled 
            />
        </div> --}}
    </div>
    <div>
        <table class="w-full text-sm text-left divide-y divide-gray-200 mt-4">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 font-medium text-gray-900">Producto</th>
                    <th class="px-4 py-2 font-medium text-gray-900">Cantidad</th>
                    <th class="px-4 py-2 font-medium text-gray-900">Precio Unitario</th>
                    <th class="px-4 py-2 font-medium text-gray-900">Total</th>
                    <th class="px-4 py-2 font-medium text-gray-900">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                   @forelse ( $products as $product )
                    <tr class="">
                        <td class="px-4 py-2 text-gray-700">{{ $product['name'] }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $product['quantity'] }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ number_format($product['price'], 2) }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ number_format($product['quantity'] * $product['price'], 2) }}</td>
                        <td class="px-4 py-2 text-gray-700">
                            <x-wire-mini-button 
                                wire:click="removeProduct({{ $loop->index }})" 
                                color="red"
                                 icon="trash">
                                
                            </x-wire-mini-button>
                        </td>
                    </tr>
                       
                   @empty
                                            
                    <tr>
                        <td colspan="5" class="text-center px-4 py-2 text-gray-150">No hay productos agregados</td>

                    </tr>  
                   @endforelse
            </tbody>
        </table>
    </div>
</div>
