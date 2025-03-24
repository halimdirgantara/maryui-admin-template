<div>
    <livewire:component.header :searchBar=true :title=$title :subTitle=$subTitle />

    <x-drawer wire:model="showDrawer" class="w-11/12 lg:w-1/3" right>
        <div>...</div>
        <x-button label="Close" @click="$wire.showDrawer = false" />
    </x-drawer>

    <x-modal wire:model="userForm" title="Hello" subtitle="Livewire example">
        <x-form no-separator>
            <x-input label="Name" icon="o-user" placeholder="The full name" />
            <x-input label="Email" icon="o-envelope" placeholder="The e-mail" />
     
            {{-- Notice we are using now the `actions` slot from `x-form`, not from modal --}}
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.userForm = false" />
                <x-button label="Confirm" class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    <x-table :headers="$headers" :rows="$users" striped with-pagination>
        @scope('actions', $user)
            <div class="flex items-center space-x-2">
                <x-button icon="o-pencil" wire:click="edit({{ $user->id }})" spinner class="btn-sm" />
                <x-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner class="btn-sm" />
            </div>
        @endscope
    </x-table>
</div>
