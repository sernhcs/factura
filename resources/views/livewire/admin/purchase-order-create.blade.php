<div x-data="{
products: @entangle('products'),
total: @entangle('total'),


removeProduct(index) {
    this.products.splice(index, 1); 
},


init(){
    this.$watch('products', (newProducts) => {
        let total = 0;
        newProducts.forEach(product => {
            total += product.quantity * product.price;
        });
        this.total = total;
    });
    }
}">
<x-wire-card>

    <form wire:submit="save" class="space-y-4">
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
                    <template x-for="(product,index) in products" :key="product.id">
                                    
                        <tr class="border-b">
                            <td class="px-4 py-2 text-gray-700" x-text="product.name"></td>
                            <td class="px-4 py-2 text-gray-700">
                                <x-wire-input 
                                    type="number" 
                                    min="1" 
                                    class="w-20" 
                                    x-model="product.quantity"
                                    >  
                                </x-wire-input>
                            </td>
                            <td class="px-4 py-2 text-gray-700">
                                <x-wire-input 
                                    type="number" 
                                    min="0.01" 
                                    step="0.01" 
                                    class="w-24" 
                                    x-model="product.price"        
                                    >   
                                </x-wire-input>
                            </td>
                            <td class="px-4 py-2 text-gray-700" x-text="(product.quantity*product.price).toFixed(2)"></td>
                            <td class="px-4 py-2 text-gray-700">
                                <x-wire-mini-button 

                                    x-on:click="removeProduct(index)"
                                    color="red"
                                    icon="trash">
                                    
                                </x-wire-mini-button>
                            </td>
                        </tr>
                    </template>
                    <template x-if="products.length === 0">
                        <tr>
                            <td colspan="5" class="text-center px-4 py-2 text-gray-500">No hay productos agregados</td>
                        </tr>
                    </template>
                </tbody>
            </table>




        </div>
        <div class="grid grid-cols-4 gap-4 ml-4 mt-4 items-center bg-gray-50">
            <!-- Observación label -->
            <x-label class="font-bold col-span-1">
                Observación:
            </x-label>

            <!-- Input de observación -->
            <div class="col-span-1">
                <x-wire-input 
                    class="w-full" 
                    wire:model="observation">
                </x-wire-input>
            </div>

            <!-- Total -->
            <div class="col-span-1 flex justify-end items-center space-x-1">
                <x-label class="font-bold">
                    Total: S/.
                </x-label>
                <span class="text-sm" x-text="total.toFixed(2)"></span>
            </div>
            <x-wire-button 
            type="submit" icon="check" class="col-span-1 w-full"> 
                Guardar
                    </x-wire-button>
                </div>
            </div>
        </form>
    </x-wire-card>
</div>