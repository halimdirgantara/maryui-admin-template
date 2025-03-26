<div>
    <livewire:component.header searchBar=true :filterBar=false :createBar=true :title=$title :subTitle=$subTitle />

    <x-drawer wire:model="showDrawer" class="w-11/12 lg:w-1/3" right>
        <div>...</div>
        <x-button label="Close" @click="$wire.showDrawer = false" />
    </x-drawer>

    <x-modal wire:model="roleForm" ttitle="Role Form" subtitle="Create Or Edit Role">
        <x-form no-separator>
            <x-input wire:model="name" label="Name" icon="o-user" placeholder="Role name" />
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.roleForm = false" />
                <x-button label="Confirm" class="btn-primary" wire:click="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    <x-table :headers="$headers" :rows="$roles" striped with-pagination>
        @scope('actions', $user)
            <div class="flex items-center space-x-2">
                <x-button icon="o-pencil" wire:click="edit({{ $user->id }})" spinner class="btn-sm" />
                <x-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner class="btn-sm" />
            </div>
        @endscope
    </x-table>
</div>
