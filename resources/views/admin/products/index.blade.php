<x-admin-layout 

title="Productos"

:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Productos',
    ],
]">
    <x-slot name="action" blue>
        <x-wire-button href="{{ route('admin.products.create') }}" blue >
            Nuevo
        </x-wire-button>
    </x-slot>
    @livewire('admin.datatables.product-table')
    @push('js')
        <script>
            forms= document.querySelectorAll('.delete-form');
            
            forms.forEach(form=>{
                form.addEventListener('submit',function(e){
                    e.preventDefault();
                    Swal.fire({
                        title: "Estás seguro?",
                        text: "No podrás revertir",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, eliminar",
                        cancelButtonText: "Cancelar",
                        }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            })
        </script>
    @endpush

</x-admin-layout>