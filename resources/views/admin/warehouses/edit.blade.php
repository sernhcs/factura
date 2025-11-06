<x-admin-layout 

title="Almacenes"

:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Almacenes',
        'href' => route('admin.warehouses.index'),

    ],
    [
        'name' => 'Editar',
    ],
]">
    <x-wire-card>
        <form action="{{ route('admin.warehouses.update',$warehouse) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <x-wire-input label="Nombre" name="name" placeholder="Nombre del almacén" value="{{ old('name',$warehouse->name) }}" />
            
            <x-wire-textarea label="Ubicación" name="location"  placeholder="Ubicación del almacén">
            {{ old('location',$warehouse->location) }}
         </x-wire-textarea>
        
            <div class="flex justify-end ">
                <x-button>
                    Guardar
                </x-button>
            </div>
                
        </form>
    </x-wire-card>
</x-admin-layout>
