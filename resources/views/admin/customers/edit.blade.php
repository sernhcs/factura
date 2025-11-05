<x-admin-layout 

title="Clientes"

:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Clientes',
        'href' => route('admin.customers.index'),

    ],
    [
        'name' => 'Editar',
    ],
]">
    <x-wire-card>
        
        <form action="{{ route('admin.customers.update',$customer) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-wire-native-select label="Tipo de documento" name="identity_id" >
                @foreach ( $identities as $identity )
                    <option value="{{ $identity->id }}" @selected( old('identity_id',$customer->identity_id) == $identity->id )>
                        {{ $identity->name }}
                    </option>
                @endforeach
            </x-wire-native-select>

                <x-wire-input label="Número de identificación" name="document_number" placeholder="Número de identificación del cliente" value="{{ old('document_number',$customer->document_number) }}" required />

            </div>
            <x-wire-input label="Nombre" name="name" placeholder="Nombre del cliente" value="{{ old('name',$customer->name) }}" />

            <x-wire-input label="Dirección" name="address" placeholder="Dirección del cliente" value="{{ old('address', $customer->address) }}" />

            <x-wire-input label="Correo electrónico" name="email" type="email" placeholder="Correo electrónico del cliente" value="{{ old('email', $customer->email) }}" />

            <x-wire-input label="Teléfono" name="phone" placeholder="Teléfono del cliente" value="{{ old('phone',$customer->phone) }}" />
        
            <div class="flex justify-end ">
                <x-button>
                    Actualizar
                </x-button>
            </div>
                
        </form>
    </x-wire-card>
</x-admin-layout>
