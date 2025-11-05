<div>
    <x-wire-select
        label="Tipo de documento"
        wire:model="identity_id"
        :options="$identities->pluck('name','id')" 
        :selected="$identity_id"
    />

    <!-- Input oculto sincronizado -->
    <input type="hidden" name="identity_id" wire:model="identity_id">
</div>
