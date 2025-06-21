<div>
    <livewire:component.header searchBar=true :filterButton=false :createButton=true :title=$title :subTitle=$subTitle />

    <x-drawer wire:model="showDrawer" class="w-11/12 lg:w-1/3" right>
        <div>...</div>
        <x-button label="Close" @click="$wire.showDrawer = false" />
    </x-drawer>

    <x-modal wire:model="form" title="Permission Form" subtitle="Create Or Edit Permission">
        <x-form no-separator>
            <x-input wire:model="name" label="Name" icon="o-lock-open" placeholder="Permission name" />
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.form = false" />
                <x-button label="Confirm" class="btn-primary" wire:click="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    <x-table :headers="$headers" :rows="$permissions" striped with-pagination>
        @scope('actions', $permission)
            <div class="flex items-center space-x-2">
                <x-button icon="o-pencil" wire:click="edit({{ $permission->id }})" spinner class="btn-sm" />
                <x-button icon="o-trash" wire:click="delete({{ $permission->id }})" spinner class="btn-sm" />
            </div>
        @endscope
    </x-table>
</div>
