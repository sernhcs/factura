<x-admin-layout 

title="Categorías"

:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Categorías',
    ],
]">
    <x-slot name="action" blue>
        <x-wire-button href="{{ route('admin.categories.create') }}" blue >
            Nuevo
        </x-wire-button>
    </x-slot>
    @livewire('admin.datatables.category-table')
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